<?php

namespace MathLib\Data;

use MathLib\Math\LongMath;

class ContainersMath
{
    public static function sum (Vector $a, Vector $b)
    {
        $sum = new Vector;

        $a->foreach (function ($index, $value) use ($sum, $b)
        {
            $sum->push ($value + $b[$index]);
        });

        return $sum;
    }

    public static function long_sum (Vector $a, Vector $b)
    {
        $sum = new Vector;

        $a->foreach (function ($index, $value) use ($sum, $b)
        {
            $sum->push (LongMath::sum ($value, $b[$index])->convertToInt ());
        });

        return $sum;
    }

    public static function sub (Vector $a, Vector $b)
    {
        $sub = new Vector;

        $a->foreach (function ($index, $value) use ($sub, $b)
        {
            $sub->push ($value - $b[$index]);
        });

        return $sub;
    }

    public static function long_sub (Vector $a, Vector $b)
    {
        $sub = new Vector;

        $a->foreach (function ($index, $value) use ($sub, $b)
        {
            $sub->push (LongMath::sub ($value, $b[$index])->convertToInt ());
        });

        return $sub;
    }

    public static function multiply (Vector $a, Vector $b)
    {
        $multiply = new Vector;

        $a->foreach (function ($index, $value) use ($multiply, $b)
        {
            $multiply->push ($value * $b[$index]);
        });

        return $multiply;
    }

    public static function long_multiply (Vector $a, Vector $b)
    {
        $multiply = new Vector;

        $a->foreach (function ($index, $value) use ($multiply, $b)
        {
            $multiply->push (LongMath::multiply ($value, $b[$index])->convertToInt ());
        });

        return $multiply;
    }

    public static function div (Vector $a, Vector $b)
    {
        $div = new Vector;

        $a->foreach (function ($index, $value) use ($div, $b)
        {
            $div->push ($value / $b[$index]);
        });

        return $div;
    }

    public static function long_div (Vector $a, Vector $b)
    {
        $div = new Vector;

        $a->foreach (function ($index, $value) use ($div, $b)
        {
            $div->push (LongMath::div ($value, $b[$index])->convertToInt ());
        });

        return $div;
    }
}
