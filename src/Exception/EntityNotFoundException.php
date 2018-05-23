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
 * An exception used when an entity was not found.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class EntityNotFoundException extends Exception
{
    /**
     * {@inheritdoc}
     *
     * @param string $entityName An entity name
     * @param int    $entityId   An entity id
     */
    public function __construct(string $entityName, int $entityId)
    {
        $entityShortName = substr($entityName, strrpos($entityName, '\\') + 1);
        $template = 'Not found entity %s with id=\'%s\'.';

        $message = sprintf($template, $entityShortName, $entityId);

        parent::__construct($message);
    }
}
