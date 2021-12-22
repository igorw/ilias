<?php

namespace Igorw\Ilias;

class Lexer
{
    private $whitespace = [' ', "\t", "\r", "\n"];
    private $nonAtom = ['(', ')', ' ', "\t", "\r", "\n"];

    public function tokenize($code)
    {
        $tokens = [];

        for ($i = 0, $length = strlen($code); $i < $length; $i++) {
            $char = $code[$i];

            // kill whitespace
            if (in_array($char, $this->whitespace)) {
                continue;
            }

            // parens are single tokens
            if (in_array($char, ['(', ')'])) {
                $tokens[] = $char;
                continue;
            }

            // quote token (just the quote character)
            if ("'" === $char) {
                $tokens[] = $char;
                continue;
            }


            // String
            if ('"' === $char){
                $tokens[] = "'";
                $atom = '';
                $max_i = strlen($code);
                do {
                    $i++;
                    $char = $code[$i];
                    if ($char === '"'){
                        break;
                    }
                    $atom .= $char;
                } while ($i < $max_i);
                $tokens[] = $atom;
                continue;
            }
            

            // atom token
            $atom = '';
            $next = $char;
            do {
                $atom .= $next;
                $next = ($length > $i+1) ? $code[$i+1] : null;
            } while (null !== $next && !in_array($next, $this->nonAtom) && ++$i);
            $tokens[] = $atom;
        }

        return $tokens;
    }
}
