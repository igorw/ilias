<?php

namespace Igorw\Ilias;

class FormBuilder
{
    public function parse(array $ast)
    {
        return array_map([$this, 'parseSexpr'], $ast);
    }

    public function parseSexpr($sexpr)
    {
        if (!is_array($sexpr)) {
            return $this->parseAtom($sexpr);
        }

        $list = $this->parse($sexpr);
        return new Form\ListForm($list);
    }

    private function parseAtom($atom)
    {
        if ($atom instanceof Ast\QuotedValue) {
            return new Form\QuoteForm($atom);
        }

        if (is_string($atom)) {
            return new Form\SymbolForm($atom);
        }

        return new Form\LiteralForm($atom);
    }
}
