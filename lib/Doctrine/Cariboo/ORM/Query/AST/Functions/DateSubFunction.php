<?php

namespace Doctrine\Cariboo\ORM\Query\AST\Functions;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;

/**
 * "DATEADD(date1, interval, unit)"
 */
class DateSubFunction extends DateAddFunction
{
    public $firstDateExpression = null;
    public $intervalExpression = null;
    public $unit = null;

    public function getSql(SqlWalker $sqlWalker)
    {
        return $sqlWalker->getConnection()->getDatabasePlatform()->getDateSubIntervalExpression(
            $this->firstDateExpression->dispatch($sqlWalker),
            $this->intervalExpression->dispatch($sqlWalker),
            $this->unit->dispatch($sqlWalker)
        );
    }
}
