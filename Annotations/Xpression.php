<?php

namespace Symftony\XpressionBundle\Annotations;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * @Annotation
 */
class Xpression extends ConfigurationAnnotation
{
    private $source;
    private $sourceName;
    private $targetName;
    private $expressionBuilder;
    private $allowedTokenType;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->source = $this->sourceName = $this->targetName = 'query';
        parent::__construct($values);
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getSourceName()
    {
        return $this->sourceName;
    }

    /**
     * @param mixed $sourceName
     */
    public function setSourceName($sourceName)
    {
        $this->sourceName = $sourceName;
    }

    /**
     * @return mixed
     */
    public function getTargetName()
    {
        return $this->targetName;
    }

    /**
     * @param mixed $targetName
     */
    public function setTargetName($targetName)
    {
        $this->targetName = $targetName;
    }

    /**
     * @return mixed
     */
    public function getExpressionBuilder()
    {
        return $this->expressionBuilder;
    }

    /**
     * @param mixed $expressionBuilder
     */
    public function setExpressionBuilder($expressionBuilder)
    {
        $this->expressionBuilder = $expressionBuilder;
    }

    /**
     * @return mixed
     */
    public function getAllowedTokenType()
    {
        return $this->allowedTokenType;
    }

    /**
     * @param mixed $allowedTokenType
     */
    public function setAllowedTokenType($allowedTokenType)
    {
        $this->allowedTokenType = $allowedTokenType;
    }

    /**
     * @return mixed
     */
    public function getAliasName()
    {
        return 'Xpression';
    }

    /**
     * @return mixed
     */
    public function allowArray()
    {
        return true;
    }
}