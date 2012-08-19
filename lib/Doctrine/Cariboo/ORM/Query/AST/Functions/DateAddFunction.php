<?php

namespace Doctrine\Cariboo\ORM\Query\AST\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;

/**
 * "DATEADD(date1, interval, unit)"
 */
class DateAddFunction extends FunctionNode
{
    public $firstDateExpression = null;
    public $intervalExpression = null;
    public $unit = null;

    public function getSql(SqlWalker $sqlWalker)
    {
        return $sqlWalker->getConnection()->getDatabasePlatform()->getDateAddIntervalExpression(
            $this->firstDateExpression->dispatch($sqlWalker),
            $this->intervalExpression->dispatch($sqlWalker),
            $this->unit->dispatch($sqlWalker)
        );
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstDateExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->intervalExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->unit = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
