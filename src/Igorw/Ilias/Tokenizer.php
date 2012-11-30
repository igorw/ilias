<?php

namespace Igorw\Ilias;

class Tokenizer
{
    private $whitespace = [' ', "\t", "\r", "\n"];
    private $nonAtom = ['(', ')', ' ', "\t", "\r", "\n"];

    public function tokenize($code)
    {
        $tokens = [];

        for ($i = 0, $length = strlen($code); $i < $length; $i++) {
            $char = $code[$i];

            if (in_array($char, ['(', ')'])) {
                $tokens[] = $char;
                continue;
            }

            if (in_array($char, $this->whitespace)) {
                $tokens[] = ' ';
                do {
                    $next = ($length > $i) ? $code[$i+1] : null;
                } while (in_array($next, $this->whitespace) && ++$i);
                continue;
            }

            if ("'" === $char) {
                $tokens[] = $char;
                continue;
            }

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
