<?php

namespace Symftony\XpressionBundle\Bridge\Doctrine\ORM;

use Doctrine\ORM\Query\Expr;
use Symftony\Xpression\Bridge\Doctrine\ORM\ExprAdapter;

class ExprAdapterFactory
{
    /**
     * @return ExprAdapter
     */
    static public function createExprAdapter()
    {
        return new ExprAdapter(new Expr());
    }
}