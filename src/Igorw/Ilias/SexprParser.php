<?php

namespace Igorw\Ilias;

class SexprParser
{
    public function parse(array $tokens)
    {
        $ast = [];

        for ($i = 0, $length = count($tokens); $i < $length; $i++) {
            $token = $tokens[$i];

            while (null !== $token && '(' !== $token && ')' !== $token) {
                if (' ' !== $token) {
                    $ast[] = $this->normalizeAtom($token);
                }

                $token = isset($tokens[$i+1]) ? $tokens[++$i] : null;
            }

            if (null === $token) {
                break;
            }

            if ('(' === $token) {
                list($tokenRange, $i) = $this->getTokenRange($tokens, $i);
                $ast[] = $this->parse($tokenRange);
                continue;
            }
        }

        return $ast;
    }

    private function normalizeAtom($atom)
    {
        if (is_numeric($atom)) {
            return (int) $atom;
        }

        return $atom;
    }

    private function getTokenRange(array $tokens, $i)
    {
        $level = 0;

        $init = $i;

        for ($length = count($tokens); $i < $length; $i++) {
            $token = $tokens[$i];

            if ('(' === $token) {
                $level++;
            }

            if (')' === $token) {
                $level--;
            }

            if (0 === $level) {
                return [
                    array_slice($tokens, $init + 1, $i - ($init + 1)),
                    $i
                ];
            }
        }
    }
}
