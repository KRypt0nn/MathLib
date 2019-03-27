<?php

namespace MathLib\Other;

function swap (&$a, &$b)
{
    $c = $a;
    $a = $b;
    $b = $c;
}

function is_number ($string)
{
    return strlen (preg_replace ('/[\-]{0,1}[1-9]{1}[0-9]{0,}/', '', $string)) == 0 || $string == 0;
}

function is_upper ($num_a, $num_b)
{
    if (!is_number ($num_a))
        throw new \Exception ('$num_a param must be numeric, "'. $num_a .'" recieved');

    if (!is_number ($num_b))
        throw new \Exception ('$num_b param must be numeric, "'. $num_b .'" recieved');
        
    $num_a = (string) $num_a;
    $num_b = (string) $num_b;

    $len_a = strlen ($num_a);
    $len_b = strlen ($num_b);

    if ($len_a == $len_b)
    {
        $similar = true;

        for ($i = 0; $i < $len_a; ++$i)
            if ($num_a[$i] != $num_b[$i])
                $similar = false;

        if ($similar)
            return false;
    }

    if ($num_a[0] == '-')
        return $num_b[0] == '-' ?
            !is_upper (substr ($num_a, 1), substr ($num_b, 1)) :
            false;

    elseif ($num_b[0] == '-')
        return $num_a[0] == '-' ?
            !is_upper (substr ($num_a, 1), substr ($num_b, 1)) :
            true;

    if ($len_a != $len_b)
        return $len_a > $len_b;

    else
    {
        for ($i = 0; $i < $len_a; ++$i)
            if ($num_a[$i] > $num_b[$i])
                return true;

            elseif ($num_a[$i] < $num_b[$i])
                return false;

        return false;
    }
}

function is_similar ($num_a, $num_b)
{
    if (!is_number ($num_a))
        throw new \Exception ('$num_a param must be numeric, "'. $num_a .'" recieved');

    if (!is_number ($num_b))
        throw new \Exception ('$num_b param must be numeric, "'. $num_b .'" recieved');
        
    /*if ($num_a[0] != $num_b[0])
        return false;

    if (($length = strlen ($num_a)) != strlen ($num_b))
        return false;

    for ($i = 0; $i < $length; ++$i)
        if ($num_a[$i] != $num_b[$i])
            return false;

    return true;*/

    return crc32 ($num_a) == crc32 ($num_b);
}
