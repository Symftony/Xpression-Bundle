<?php

namespace Symftony\XpressionBundle\Annotations\Driver;

use Symftony\Xpression\Parser;
use Symftony\Xpression\Exception\Parser\InvalidExpressionException;
use Symftony\XpressionBundle\Annotations\Xpression;
use Symftony\XpressionBundle\ExpressionBuilderRegistry;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class AnnotationsDriver implements EventSubscriberInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var ExpressionBuilderRegistry
     */
    private $expressionBuilderRegistry;

    /**
     * @param Reader $reader
     * @param ExpressionBuilderRegistry $expressionBuilderRegistry
     */
    public function __construct(Reader $reader, ExpressionBuilderRegistry $expressionBuilderRegistry)
    {
        $this->reader = $reader;
        $this->expressionBuilderRegistry = $expressionBuilderRegistry;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);
        $optionalArguments = [];
        foreach($method->getParameters() as $parameter) {
            if ($parameter->isDefaultValueAvailable()) {
                $optionalArguments[$parameter->getName()] = $parameter;
            }
        }
        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            if (!$configuration instanceof Xpression) {
                continue;
            }

            $expressionBuilder = $this->expressionBuilderRegistry->get($configuration->getExpressionBuilder());
            $source = $configuration->getSource();
            $targetName = $configuration->getTargetName();
            $request = $event->getRequest();
            $input = $request->{$source}->get($configuration->getSourceName());
            if (null === $input || '' === $input) {
                if (!array_key_exists($targetName, $optionalArguments)) {
                    throw new HttpException(400, sprintf('Expression "%s" is require.', $source));
                }
                continue;
            }
            try {
                $parser = new Parser($expressionBuilder);
                $expr = $parser->parse($input);
                $request->attributes->set($targetName, $expr);
            } catch (InvalidExpressionException $exception) {
                throw new HttpException(400, sprintf('Invalid expression in "%s".', $source), $exception);
            }
        }
    }
}
