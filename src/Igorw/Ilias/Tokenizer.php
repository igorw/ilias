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

            if (' ' === $char) {
                $tokens[] = $char;
                do {
                    $next = ($length > $i) ? $code[$i+1] : null;
                } while (' ' === $next && $i++);
                continue;
            }

            $atom = '';
            $next = $char;
            do {
                $atom .= $next;
                $next = ($length > $i+1) ? $code[$i+1] : null;
            } while (null !== $next && !in_array($next, ['(', ')', ' ']) && ++$i);
            $tokens[] = $atom;
        }

        return $tokens;
    }
}
