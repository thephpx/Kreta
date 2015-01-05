<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\EventListener;

use Doctrine\ORM\NoResultException;
use Kreta\Bundle\CoreBundle\Form\Handler\Exception\InvalidFormException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class JsonExceptionListenerSpec.
 *
 * @package spec\Kreta\Bundle\ApiBundle\EventListener
 */
class JsonExceptionListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\EventListener\JsonExceptionListener');
    }

    function it_converts_exception_into_json_response_by_default_option(
        GetResponseForExceptionEvent $event,
        Request $request,
        \Exception $exception
    )
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getRequestFormat()->shouldBeCalled()->willReturn('json');
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }

    function it_converts_doctrines_no_result_exception_into_json_response(
        GetResponseForExceptionEvent $event,
        Request $request,
        NoResultException $exception
    )
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getRequestFormat()->shouldBeCalled()->willReturn('json');
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }

    function it_converts_kretas_invalid_form_exception_into_json_response(
        GetResponseForExceptionEvent $event,
        Request $request,
        InvalidFormException $exception
    )
    {
        $event->getRequest()->shouldBeCalled()->willReturn($request);
        $request->getRequestFormat()->shouldBeCalled()->willReturn('json');
        $event->getException()->shouldBeCalled()->willReturn($exception);
        $exception->getFormErrors()->shouldBeCalled()->willReturn(
            ['name' =>
                 ['This value should not be blank', 'An object with identical name is already exists']
            ]
        );
        $event->setResponse(Argument::type('Symfony\Component\HttpFoundation\JsonResponse'))->shouldBeCalled();

        $this->onKernelException($event);
    }
}
