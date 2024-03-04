<?php

namespace ruhrpottmetaller\Data\LowLevel\String;

use ruhrpottmetaller\Data\LowLevel\AbstractLowLevelData;
use ruhrpottmetaller\Data\LowLevel\Int\RmInt;
use ruhrpottmetaller\Data\LowLevel\INullBehaviour;
use ruhrpottmetaller\Data\LowLevel\IsNullBehaviour;
use ruhrpottmetaller\Data\LowLevel\NotNullBehaviour;

abstract class AbstractRmString extends AbstractLowLevelData
{
    protected INullBehaviour $nullBehaviour;

    protected function __construct($value, INullBehaviour $nullBehaviour)
    {
        $this->nullBehaviour = $nullBehaviour;
        parent::__construct($value);
    }

    public static function new($value)
    {
        return self::createObject($value);
    }

    public function set($value)
    {
        return self::createObject($value);
    }

    public function get(): ?string
    {
        return $this->value;
    }

    public function isNull(): bool
    {
        return $this->nullBehaviour->isNull();
    }

    public function concatWith(AbstractRmString $string): AbstractRmString
    {
        $this->value .= $string->get();
        return $this;
    }

    public function asWwwUrl(): AbstractRmString
    {
        $this->filter();
        return RmString::new('<a href="' . $this->value . '">www</a>');
    }

    public function asTableInput(
        RmString $fieldName,
        RmString $description,
        RmInt $rowId
    ): RmString {
        $this->filter();
        $format = '<label for="%1$s_%2$u" class="visually-hidden">%4$s</label>
            <input id="%1$s_%2$u" name="%1$s" value="%3$s" placeholder="%4$s">';
        $primitive = sprintf(
            $format,
            $fieldName->get(),
            $rowId->get(),
            $this->value,
            $description
        );
        return RmString::new($primitive);
    }

    protected static function createObject($value)
    {
        if (is_null($value)) {
            return new RmNullString(null, new IsNullBehaviour());
        }

        return new RmString($value, new NotNullBehaviour());
    }
}
