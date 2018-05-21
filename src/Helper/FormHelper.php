<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helper;

use App\Entity\Traits\BaseInterface;
use App\Serializer\FormErrorSerializer;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * FormHelper
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class FormHelper
{
    /**
     * @var array
     */
    private $formErrors;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;

    /**
     * Class constructor
     *
     * @param FormFactoryInterface $formFactory
     * @param FormErrorSerializer  $formErrorSerializer
     */
    public function __construct(FormFactoryInterface $formFactory,
                                FormErrorSerializer $formErrorSerializer)
    {
        $this->formErrors = [];
        $this->formFactory = $formFactory;
        $this->formErrorSerializer = $formErrorSerializer;
    }

    /**
     * @param string        $type
     * @param BaseInterface $entity
     * @param               $data
     * @param bool          $allProperties
     *
     * @return BaseInterface|null
     */
    public function submitEntity(string $type = FormType::class, BaseInterface $entity,
                                 array $data, bool $allProperties = true): ?BaseInterface
    {
        $form = $this->formFactory->create($type, $entity);

        if ($allProperties) {
            /*
             * Update all properties
             */
            $form->submit($data);
        } else {
            /*
             * update selected properties
             */
            $form->submit($data, false);
        }

        if ($this->formIsNotValid($form)) {
            return null;
        }

        return $form->getData();
    }

    /**
     * @param FormInterface $form
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
     * Get errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->formErrors;
    }
}
