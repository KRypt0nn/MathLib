<?php

namespace MathLib\Math;

class Number
{
    protected $number;
    protected $length;
    protected $is_negative;

    public function __construct ($number = null)
    {
        if ($number !== null)
            $this->convertFromInt ($number);
    }

    public function convertFromInt ($number)
    {
        if (is_a ($number, self::class))
            $this->convertFromInt ($number->convertToInt ());

        elseif (!\MathLib\Other\is_number ($number))
            throw new \Exception ('$number param must be numeric, "'. $number .'" recieved');

        else
        {
            $number = (string) $number;

            if ($number[0] == '-')
            {
                $this->is_negative = true;

                $number = substr ($number, 1);
            }

            $this->number = array_reverse (str_split ($number));
            $this->length = strlen ($number);
        }
    }

    public function convertToInt ()
    {
        $number = $this->number;

        while (sizeof ($number) > 1 && end ($number) == 0)
            array_pop ($number);

        return ($this->is_negative ? '-' : ''). implode ('', array_reverse ($number));
    }

    public function absolute ()
    {
        return new Number (implode ('', array_reverse ($this->number)));
    }

    public function negative ()
    {
        return new Number (($this->is_negative ? '' : '-'). implode ('', array_reverse ($this->number)));
    }

    public function __get ($name)
    {
        if (isset ($this->$name))
            return $this->$name;

        else return null;
    }

    public function __toString ()
    {
        return $this->convertToInt ();
    }

    public function __debugInfo ()
    {
        return array
        (
            'number' => $this->convertToInt (),
            'this'   => json_encode ($this, defined ('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0)
        );
    }
}
