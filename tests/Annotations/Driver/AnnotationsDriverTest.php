<?php

namespace Tests\Symftony\XpressionBundle\Annotations\Driver;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Annotations\Reader;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symftony\Xpression\Expr\ExpressionBuilderInterface;
use Symftony\XpressionBundle\Annotations\Driver\AnnotationsDriver;
use Symftony\XpressionBundle\ExpressionBuilderRegistry;

class AnnotationsDriverTest extends TestCase
{
    /**
     * @var FilterControllerEvent
     */
    private $filterControllerEvent;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var ExpressionBuilderRegistry
     */
    private $expressionBuilderRegistryMock;

    /**
     * @var ExpressionBuilderInterface|ObjectProphecy
     */
    private $expressionBuilderMock;

    /**
     * @var AnnotationsDriver
     */
    private $annotationsDriver;

    public function setUp()
    {
        $controllerMock = new FakeController();
        $httpKernelMock = $this->prophesize(HttpKernelInterface::class);
        $request = new Request(['query' => '{aze=5}']);
        $this->filterControllerEvent = new FilterControllerEvent($httpKernelMock->reveal(), [$controllerMock, 'myAction'], $request, HttpKernelInterface::MASTER_REQUEST);

        $this->reader = new AnnotationReader();

        $this->expressionBuilderMock = $this->prophesize(ExpressionBuilderInterface::class);
        $this->expressionBuilderRegistryMock = $this->prophesize(ExpressionBuilderRegistry::class);
        $this->expressionBuilderRegistryMock
            ->get('fake_expression_builder')
            ->willReturn($this->expressionBuilderMock)
            ->shouldBeCalled();

        $this->annotationsDriver = new AnnotationsDriver(
            $this->reader,
            $this->expressionBuilderRegistryMock->reveal()
        );
    }

    public function testOnKernelController()
    {
        $this->annotationsDriver->onKernelController($this->filterControllerEvent);
    }
}

use Symftony\XpressionBundle\Annotations\Xpression;

class FakeController
{
    /**
     * @\Symftony\XpressionBundle\Annotations\Xpression(expressionBuilder="my_fake_expression_builder")
     */
    public function myAction($require, $optionnal = null)
    {

    }
}