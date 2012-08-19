<?php
namespace Doctrine\Cariboo\ORM\Query\AST\Functions;
 
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;
 
/**
 * DQL function for calculating distances between two points
 *
 * Example: DISTANCE(foo.point, :param)
 */
class DistanceFunction extends FunctionNode {
    
    private $firstPoint = null;
    private $secondPoint = null;
 
    public function getSql(SqlWalker $sqlWalker)
    {
        return $sqlWalker->getConnection()->getDatabasePlatform()->getDistanceExpression(
            $this->firstPoint->dispatch($sqlWalker),
            $this->secondPoint->dispatch($sqlWalker)
        );
    }
 
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstPoint = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->secondPoint = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
