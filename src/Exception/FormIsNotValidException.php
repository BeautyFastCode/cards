<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Exception;

use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * An exception used when a form is not valid.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class FormIsNotValidException extends Exception
{
    /**
     * The form errors.
     *
     * @var array
     */
    private $formErrors;

    /**
     * {@inheritdoc}
     *
     * @param array $formErrors The form errors
     */
    public function __construct(array $formErrors)
    {
        $this->formErrors = $formErrors;

        parent::__construct('Form is not valid.');
    }

    /**
     * Returns the form errors.
     *
     * @return array
     */
    public function getFormErrors(): array
    {
        return $this->formErrors;
    }
}
