<?php

namespace MathLib\Data;

abstract class BaseStructure implements \ArrayAccess
{
    protected $data;

    public function offsetExists ($offset)
    {
        return isset ($this->data[$offset]);
    }

    public function offsetGet ($offset)
    {
        return isset ($this->data[$offset]) ?
            $this->data[$offset] : null;
    }

    public function offsetSet ($offset, $value)
    {
        if ($offset === null)
            $this->data[] = $value;

        else $this->data[$offset] = $value;
    }

    public function offsetUnset ($offset)
    {
        unset ($this->data[$offset]);
    }

    public function splay ()
    {
        return $this->data;
    }

    public function build ($data)
    {
        $this->data = $data;
    }

    public function foreach (\Closure $callback)
    {
        foreach ($this->data as $index => $value)
            $callback ($index, $value);
    }

    public function __toString ()
    {
        return print_r ($this->data, true);
    }

    public function __debugInfo ()
    {
        return $this->data;
    }
}
