<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Exception\EntityNotFoundException;
use App\Helper\JsonResponseHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * ExceptionSubscriber
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var JsonResponseHelper
     */
    private $jsonResponseHelper;

    /**
     * Class constructor
     *
     * @param JsonResponseHelper $jsonResponseHelper
     */
    public function __construct(JsonResponseHelper $jsonResponseHelper)
    {
        $this->jsonResponseHelper = $jsonResponseHelper;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    /**
     * Handler for the Kernel "kernel.exception" event.
     *
     * @param GetResponseForExceptionEvent $event
     *
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        /*
         * Get the exception object from the received event
         */
        $exception = $event->getException();

        /*
         * todo: handle all exceptions for Api JSON (route: /api/)
         * see: https://symfony.com/doc/current/event_dispatcher.html
         */
        if ($exception instanceof EntityNotFoundException) {

            /*
             * Customize response object to display the exception in Json format
             */
            $jsonResponse = $this
                ->jsonResponseHelper
                ->notFoundResponse($exception->getMessage());

            /*
             * Sends the modified response object to the event
             */
            $event->setResponse($jsonResponse);
        }

        return;
    }
}
