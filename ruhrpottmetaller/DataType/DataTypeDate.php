<?php

namespace ruhrpottmetaller\DataType;

class DataTypeDate extends \DateTime implements IDataType
{
    private bool $isNull;

    public function __construct(?string $value)
    {
        parent::__construct($value);
        $this->reactToInputValueType($value);
    }

    public static function new(?string $value): DataTypeDate
    {
        return new self($value);
    }

    public function set(?string $value): DataTypeDate
    {
        parent::modify($value);
        $this->reactToInputValueType($value);
        return $this;
    }

    public function get(): ?string
    {
        if ($this->isNull) {
            return null;
        }

        return parent::format('Y-m-d');
    }

    public function print(): DataTypeDate
    {
        if ($this->isNull) {
            echo '';
        } else {
            echo parent::format('Y-m-d');
        }
        return $this;
    }

    private function reactToInputValueType(?string $value)
    {
        if (is_null($value)) {
            $this->isNull = true;
        } else {
            $this->reactToString($value);
        }
    }

    private function reactToString(string $value)
    {
        $this->isNull = false;
        parent::setTime('0', '0');
    }
}
