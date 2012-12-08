<?php

namespace Igorw\Ilias;

class Reader
{
    public function parse(array $tokens)
    {
        $ast = [];

        for ($i = 0, $length = count($tokens); $i < $length; $i++) {
            $token = $tokens[$i];

            // wrap quoted value
            if ("'" === $token) {
                list($parsedToken, $i) = $this->parseQuotedToken($tokens, $i);
                $ast[] = $parsedToken;
                continue;
            }

            // extract atoms
            if ('(' !== $token && ')' !== $token) {
                $ast[] = $this->normalizeAtom($token);
                continue;
            }

            // parse list recursively
            if ('(' === $token) {
                list($listTokens, $i) = $this->extractListTokens($tokens, $i);
                $ast[] = $this->parse($listTokens);
                continue;
            }
        }

        return $ast;
    }

    private function parseQuotedToken(array $tokens, $i)
    {
        // skip past quote char
        $i++;

        // quoted atom
        if ('(' !== $tokens[$i]) {
            $atom = $this->normalizeAtom($tokens[$i]);
            return [
                new QuotedValue($atom),
                $i,
            ];
        }

        // quoted list
        list($listTokens, $i) = $this->extractListTokens($tokens, $i);
        $list = $this->parse($listTokens);

        return [
            new QuotedValue($list),
            $i,
        ];
    }

    private function normalizeAtom($atom)
    {
        if (is_numeric($atom)) {
            return (int) $atom;
        }

        return $atom;
    }

    private function extractListTokens(array $tokens, $i)
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
                    $i,
                ];
            }
        }
    }
}
