<?php

namespace Symftony\XpressionBundle\Bridge\Doctrine\Common;

use Doctrine\Common\Collections\ExpressionBuilder;
use Symftony\Xpression\Bridge\Doctrine\Common\ExpressionBuilderAdapter;

class ExpressionBuilderAdapterFactory
{
    /**
     * @return ExpressionBuilderAdapter
     */
    static public function createExpressionBuilderAdapter()
    {
        return new ExpressionBuilderAdapter(new ExpressionBuilder());
    }
}