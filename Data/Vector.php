<?php

namespace MathLib\Data;

class Vector extends BaseStructure
{
    public function push ($data)
    {
        $this->offsetSet (null, $data);
    }

    public function pop ()
    {
        if (($size = sizeof ($this->data)) > 0)
        {
            $data = end ($this->data);

            $this->offsetUnset ($size - 1);

            return $data;
        }

        else return null;
    }

    public function fill ($begin, $length, $value = 0)
    {
        for ($i = 0; $i < $length; ++$i)
            $this->offsetSet ($begin++, $value);
    }

    public function random ($begin, $length, $min = -10, $max = 10)
    {
        for ($i = 0; $i < $length; ++$i)
            $this->offsetSet ($begin++, rand ($min, $max));
    }
}
