<?php

namespace Igorw\Ilias;

class Encoder
{
    public function encode(array $ast)
    {
        $encodedForms = array_map([$this, 'encodeForm'], $ast);
        return implode(' ', $encodedForms);
    }

    public function encodeForm($form)
    {
        if ($form instanceof QuotedValue) {
            return "'".$this->encodeForm($form->getValue());
        }

        if (!is_array($form)) {
            return $form;
        }

        return '('.$this->encode($form).')';
    }
}
