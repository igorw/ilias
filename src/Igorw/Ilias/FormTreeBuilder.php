<?php

namespace Igorw\Ilias;

class FormTreeBuilder
{
    public function parseAst(array $ast)
    {
        return array_map([$this, 'parseSexpr'], $ast);
    }

    public function parseSexpr($sexpr)
    {
        if (!is_array($sexpr)) {
            return $this->parseAtom($sexpr);
        }

        $list = $this->parseAst($sexpr);
        return new Form\ListForm($list);
    }

    private function parseAtom($atom)
    {
        if ($atom instanceof Ast\QuotedValue) {
            return new Form\QuoteForm($atom->getValue());
        }

        if (is_string($atom)) {
            return new Form\SymbolForm($atom);
        }

        return new Form\LiteralForm($atom);
    }
}
