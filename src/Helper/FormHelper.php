<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helper;

use App\Serializer\FormErrorSerializer;
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
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;

    /**
     * Class constructor
     *
     * @param FormErrorSerializer $formErrorSerializer
     */
    public function __construct(FormErrorSerializer $formErrorSerializer)
    {
        $this->formErrors = [];
        $this->formErrorSerializer = $formErrorSerializer;
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
