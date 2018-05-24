<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helper;

use App\Entity\Traits\BaseEntityInterface;
use App\Exception\FormIsNotValidException;
use App\Serializer\FormErrorSerializer;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Helper for create or update and validate an entity.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class FormHelper
{
    /**
     * The form errors.
     *
     * @var array
     */
    private $formErrors;

    /**
     * The factory to create a form.
     *
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * Serializes invalid Form instances.
     *
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;

    /**
     * Class constructor.
     *
     * @param FormFactoryInterface $formFactory         The factory to create a form
     * @param FormErrorSerializer  $formErrorSerializer Serializes invalid Form instances
     */
    public function __construct(FormFactoryInterface $formFactory,
                                FormErrorSerializer $formErrorSerializer)
    {
        $this->formErrors = [];
        $this->formFactory = $formFactory;
        $this->formErrorSerializer = $formErrorSerializer;
    }

    /**
     * Validates a form and create or update an entity.
     *
     * @param string              $formType      An entity form type class name
     * @param BaseEntityInterface $baseEntity    An entity object
     * @param array               $data          The data for an entity
     * @param bool                $allProperties (optional) False if selected properties are updated
     *
     * @return BaseEntityInterface
     */
    public function submitEntity(string $formType = FormType::class,
                                 BaseEntityInterface $baseEntity,
                                 array $data,
                                 bool $allProperties = true): BaseEntityInterface
    {
        $form = $this->formFactory->create($formType, $baseEntity);

        if ($allProperties) {
            /*
             * Update all properties.
             */
            $form->submit($data);
        } else {
            /*
             * Update selected properties.
             */
            $form->submit($data, false);
        }

        if ($this->formIsNotValid($form)) {
            throw new FormIsNotValidException($this->getErrors());
        }

        return $form->getData();
    }

    /**
     * Checks if a form is not valid,
     * true - form is not valid, false - form is valid.
     *
     * @param FormInterface $form The form
     *
     * @return bool
     */
    public function formIsNotValid(FormInterface $form): bool
    {
        if (false === $form->isValid()) {
            $this->formErrors = $this
                ->formErrorSerializer
                ->convertFormToArray($form);

            return true;
        }

        return false;
    }

    /**
     * Get the form errors.
     *
     * @return array The form errors
     */
    public function getErrors(): array
    {
        return $this->formErrors;
    }
}
