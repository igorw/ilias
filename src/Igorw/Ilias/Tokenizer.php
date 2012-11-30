<?php

namespace Igorw\Ilias;

class Tokenizer
{
    public function tokenize($code)
    {
        $tokens = [];

        for ($i = 0, $length = strlen($code); $i < $length; $i++) {
            $char = $code[$i];

            if (in_array($char, ['(', ')'])) {
                $tokens[] = $char;
                continue;
            }

            if (preg_match('/\s/', $char)) {
                $tokens[] = ' ';
                do {
                    $next = ($length > $i) ? $code[$i+1] : null;
                } while (preg_match('/\s/', $next) && $i++);
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
            } while (null !== $next && !in_array($next, ['(', ')', ' ', "\t", "\r", "\n"]) && ++$i);
            $tokens[] = $atom;
        }

        return $tokens;
    }
}
