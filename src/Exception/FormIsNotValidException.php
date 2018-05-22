<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Exception;

use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * FormIsNotValidException
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class FormIsNotValidException extends Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $template = 'Form is not valid exception.';
        $message = sprintf($template);

        parent::__construct($message);
    }
}
