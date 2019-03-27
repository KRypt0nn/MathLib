<?php

namespace MathLib\Math;

class LongMath
{
    public static function sum ($num_a, $num_b)
    {
        $num_a = new Number ($num_a);
        $num_b = new Number ($num_b);

        if ($num_a->is_negative)
            return $num_b->is_negative ?
                self::sum ($num_a->absolute (), $num_b->absolute ())->negative () :
                self::sub ($num_b, $num_a->absolute ());

        elseif ($num_b->is_negative)
            return $num_a->is_negative ?
                self::sum ($num_a->absolute (), $num_b->absolute ())->negative () :
                self::sub ($num_a, $num_b->absolute ());

        $length  = max ($num_a->length, $num_b->length);
        $new_num = array_fill (0, $length, 0);
        $postnum = 0;
        
        for ($i = 0; $i < $length || $postnum; ++$i)
        {
            $new_num[$i] = $postnum + (isset ($num_a->number[$i]) ?
                $num_a->number[$i] : 0) + (isset ($num_b->number[$i]) ?
                $num_b->number[$i] : 0);

            $postnum = $new_num[$i] >= 10;

            if ($postnum)
                $new_num[$i] -= 10;
        }

        return new Number (self::getCleanNum ($new_num));
    }
    
    public static function sub ($num_a, $num_b)
    {
        $num_a = new Number ($num_a);
        $num_b = new Number ($num_b);

        if ($num_a->is_negative)
            return $num_b->is_negative ?
                self::sum ($num_a, $num_b->absolute ()) :
                self::sum ($num_a->absolute (), $num_b)->negative ();

        elseif ($num_b->is_negative)
            return $num_a->is_negative ?
                self::sum ($num_b, $num_a->absolute ()) :
                self::sum ($num_b->absolute (), $num_a);

        if (\MathLib\Other\is_upper ($num_b->convertToInt (), $num_a->convertToInt ()))
            return self::sub ($num_b, $num_a)->negative ();

        $new_num = $num_a->number;
        $length  = $num_b->length;
        $postnum = 0;

        for ($i = 0; $i < $length || $postnum; ++$i)
        {
            $new_num[$i] = $num_a->number[$i] - $postnum - (isset ($num_b->number[$i]) ?
                $num_b->number[$i] : 0);

            $postnum = $new_num[$i] < 0;
            
            if ($postnum)
                $new_num[$i] += 10;
        }

        return new Number (self::getCleanNum ($new_num));
    }
    
    public static function multiply ($num_a, $num_b): Number
    {
        $num_a = new Number ($num_a);
        $num_b = new Number ($num_b);

        if ($num_a->is_negative)
            return $num_b->is_negative ?
                self::multiply ($num_a->absolute (), $num_b->absolute ()) :
                self::multiply ($num_a->absolute (), $num_b)->negative ();

        elseif ($num_b->is_negative)
            return $num_a->is_negative ?
                self::multiply ($num_b->absolute (), $num_a->absolute ()) :
                self::multiply ($num_b->absolute (), $num_a)->negative ();

        $new_num = array ();

        $len_a   = $num_a->length;
        $len_b   = $num_b->length;
        $postnum = 0;

        for ($i = 0; $i < $len_a; ++$i)
            for ($j = 0; $j < $len_b || $postnum; ++$j)
            {
                if (!isset ($new_num[$i + $j]))
                    $new_num[$i + $j] = 0;

                $cur = $new_num[$i + $j] + $num_a->number[$i] * (isset ($num_b->number[$j]) ?
                    $num_b->number[$j] : 0) + $postnum;

                $new_num[$i + $j] = mod ($cur, 10);
                $postnum          = div ($cur, 10);
            }

        return new Number (self::getCleanNum ($new_num));
    }

    public static function div ($num_a, $num_b)
    {
        $num_a = new Number ($num_a);
        $num_b = new Number ($num_b);

        if ($num_b->convertToInt () == 0)
            throw new \Exception ('$num_b param mustn\'t be zero');

        if ($num_a->is_negative)
            return $num_b->is_negative ?
                self::div ($num_a->absolute (), $num_b->absolute ()) :
                self::div ($num_a->absolute (), $num_b)->negative ();

        elseif ($num_b->is_negative)
            return $num_a->is_negative ?
                self::div ($num_a->absolute (), $num_b->absolute ()) :
                self::div ($num_a, $num_b->absolute ())->negative ();

        $div = 0;

        while (\MathLib\Other\is_upper ($num_a->convertToInt (), $num_b->convertToInt ()))
        {
            $num_a = self::sub ($num_a, $num_b);

            ++$div;
        }

        if (\MathLib\Other\is_similar ($num_a->convertToInt (), $num_b->convertToInt ()))
            ++$div;

        return new Number ($div);
    }

    protected static function getCleanNum ($number)
    {
        while (sizeof ($number) > 1 && end ($number) == 0)
            array_pop ($number);

        return implode ('', array_reverse ($number));
    }
}
