<?php

namespace Symftony\XpressionBundle;

use Symftony\Xpression\Expr\ExpressionBuilderInterface;

class ExpressionBuilderRegistry
{
    /**
     * @var ExpressionBuilderInterface[]
     */
    private $expressionBuilders;

    /**
     * @param ExpressionBuilderInterface[] $expressionBuilders
     */
    public function __construct(array $expressionBuilders = [])
    {
        $this->expressionBuilders = $expressionBuilders;
    }

    /**
     * @param $name
     *
     * @return ExpressionBuilderInterface
     */
    public function get($name)
    {
        if (!array_key_exists($name, $this->expressionBuilders)) {
            throw new \LogicException(sprintf('Expression builder "%s" not exist.', $name));
        }

        return $this->expressionBuilders[$name];
    }

    /**
     * @param ExpressionBuilderInterface $expressionBuilder
     * @param $name
     */
    public function add(ExpressionBuilderInterface $expressionBuilder, $name)
    {
        if (array_key_exists($name, $this->expressionBuilders)) {
            throw new \LogicException(sprintf('Expression builder "%s" already exist.', $name));
        }

        $this->expressionBuilders[$name] = $expressionBuilder;
    }

    /**
     * @param $name
     */
    public function remove($name)
    {
        if (!array_key_exists($name, $this->expressionBuilders)) {
            throw new \LogicException(sprintf('Expression builder "%s" not exist.', $name));
        }

        unset($this->expressionBuilders[$name]);
    }
}