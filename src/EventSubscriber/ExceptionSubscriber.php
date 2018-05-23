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
use App\Exception\FormIsNotValidException;
use App\Helper\JsonResponseHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * ExceptionSubscriber
 *
 * todo: handle all exceptions for Api JSON (route: /api/)
 * see: https://symfony.com/doc/current/event_dispatcher.html
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
            KernelEvents::EXCEPTION => [
                [
                    'onNotFoundException',
                    10,
                ],
                [
                    'onFormIsNotValidException',
                    20,
                ],
            ],
        ];
    }

    /**
     * Handler for the Kernel "kernel.exception" event.
     *
     * @param GetResponseForExceptionEvent $event
     *
     * @return void
     */
    public function onNotFoundException(GetResponseForExceptionEvent $event): void
    {
        /*
         * Get the exception object from the received event
         */
        $exception = $event->getException();

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

    /**
     * Handler for the Kernel "kernel.exception" event.
     *
     * @param GetResponseForExceptionEvent $event
     *
     * @return void
     */
    public function onFormIsNotValidException(GetResponseForExceptionEvent $event): void
    {
        /*
         * Get the exception object from the received event
         */
        $exception = $event->getException();

        if ($exception instanceof FormIsNotValidException) {

            /*
             * Customize response object to display the exception in Json format
             */
            $jsonResponse = $this
                ->jsonResponseHelper
                ->badRequestResponse($exception->getMessage(), $exception->getFormErrors());

            /*
             * Sends the modified response object to the event
             */
            $event->setResponse($jsonResponse);
        }

        return;
    }
}
