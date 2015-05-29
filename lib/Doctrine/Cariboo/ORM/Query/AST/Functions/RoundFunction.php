<?php
namespace Doctrine\Cariboo\ORM\Query\AST\Functions;
 
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;
 
/**
 * DQL function for calculating distances between two points
 *
 * Example: ROUND(value, decimals)
 */
class RoundFunction extends FunctionNode {
    
    private $value = null;
    private $decimals = null;
 
    public function getSql(SqlWalker $sqlWalker)
    {
        return $sqlWalker->getConnection()->getDatabasePlatform()->getRoundExpression(
            $this->value->dispatch($sqlWalker),
            $this->decimals->dispatch($sqlWalker)
        );
    }
 
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->value = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->decimals = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
