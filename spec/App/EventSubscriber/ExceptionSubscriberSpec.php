<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\EventSubscriber;

use App\EventSubscriber\ExceptionSubscriber;
use App\Exception\EntityNotFoundException;
use App\Exception\FormIsNotValidException;
use App\Helper\JsonResponseHelper;
use PhpSpec\ObjectBehavior;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Specification for ExceptionSubscriber.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class ExceptionSubscriberSpec extends ObjectBehavior
{
    public function let(JsonResponseHelper $jsonResponseHelper)
    {
        $this->beConstructedWith($jsonResponseHelper);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ExceptionSubscriber::class);
    }

    public function it_should_be_event_subscriber()
    {
        $this->shouldImplement(EventSubscriberInterface::class);
    }

    public function it_should_subscribe_kernel_exception_event()
    {
        $this::getSubscribedEvents()
            ->shouldReturn([
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
            ]);
    }

    public function it_should_handle_not_found_exception(
        GetResponseForExceptionEvent $event,
        EntityNotFoundException $exception,
        JsonResponseHelper $jsonResponseHelper,
        JsonResponse $jsonResponse)
    {
        $event
            ->getException()
            ->willReturn($exception);

        $jsonResponseHelper
            ->notFoundResponse('')
            ->willReturn($jsonResponse);

        $event
            ->setResponse($jsonResponse)
            ->shouldBeCalledTimes(1);

        $this->onNotFoundException($event);
    }

    public function it_should_handle_form_is_not_valid(
        GetResponseForExceptionEvent $event,
        FormIsNotValidException $exception,
        JsonResponseHelper $jsonResponseHelper,
        JsonResponse $jsonResponse)
    {
        $event
            ->getException()
            ->willReturn($exception);

        $exception
            ->getFormErrors()
            ->willReturn([]);

        $jsonResponseHelper
            ->badRequestResponse('', [])
            ->willReturn($jsonResponse);

        $event
            ->setResponse($jsonResponse)
            ->shouldBeCalledTimes(1);

        $this->onFormIsNotValidException($event);
    }
}
