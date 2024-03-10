<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

class RmString extends AbstractRmString
{
    public function asFirstUppercase(): RmString
    {
        return RmString::new(ucfirst($this->value));
    }

    public function getFirstChar(): RmString
    {
        return RmString::new(substr($this->value, 0, 1));
    }

    public function asPrefixedWidth(RmString $prefix): RmString
    {
        return RmString::new($prefix->concatWith($this));
    }

    public function asSubmitButton(): RmString
    {
        return RmString::new('<button type="submit">' . $this->value . '</button>');
    }

    public function isEmpty(): bool
    {
        return $this->value == '';
    }

    public function hasSpecialFirstChar(): bool
    {
        return !preg_match('/^[a-zA-Z]/', $this->value);
    }

    public function filter(): RmString
    {
        $this->value = htmlentities($this->value, ENT_QUOTES);
        return $this;
    }
}
