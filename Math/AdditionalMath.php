<?php

namespace MathLib\AdditionalMath;

use MathLib\Math\LongMath;
use MathLib\Math\Number;

function div ($num, $div)
{
    return LongMath::div ($num, $div)->convertToInt ();
}

function mod ($num, $mod)
{
    return LongMath::sub ($num, LongMath::multiply (div ($num, $mod), $mod))->convertToInt ();
}

function pow ($base, $exp = 2)
{
    if ($exp == 0)
        return 1;

    elseif ($exp < 0)
        return 1 / pow ($base, -$exp);

    else
    {
        $step = 1;

        while ($exp)
        {
            if ($exp & 1)
                $step = LongMath::multiply ($step, $base);

            $base = LongMath::multiply ($base, $base);
            $exp >>= 1;
        }

        return $step->convertToInt ();
    }
}

function powmod ($base, $exp = 2, $mod = 2)
{
    $t = powmod ($base, div ($exp, 2), $mod);
    
    return mod ($exp, 2) == 0 ?
        mod (pow ($t, 2), $mod) :
        mod (LongMath::multiply ($base, pow ($t, 2)), $mod);
}

function root ($num, $step = 2)
{
    $l = 1;
    $r = $num;
    
    $m[$num] = 1;

    while (\MathLib\Other\is_upper ($r, LongMath::sum ($l, 1)))
    {
        $m[$num] = div (LongMath::sum ($l, $r), 2);
        $result  = pow ($m[$num], $step);

        if (\MathLib\Other\is_similar ($result, $num))
            return $m[$num];

        elseif (\MathLib\Other\is_upper ($num, $result))
            $l = $m[$num];

        else $r = $m[$num];
    }

    return $m[$num];
}

function fib ($num)
{
    $dp[0] = new Number (0);
    $dp[1] = new Number (1);

    for ($i = 2; $i <= $num; ++$i)
        if (!isset ($dp[$i]))
            $dp[$i] = LongMath::sum ($dp[$i - 1], $dp[$i - 2]);

    return $dp[$num]->convertToInt ();
}

function fact ($num)
{
    $result[1] = new Number (1);

    for ($i = 2; $i <= $num; ++$i)
        $result[$i] = LongMath::multiply ($result[$i - 1], $i);

    return $result[$num]->convertToInt ();
}

function is_simple ($num)
{
    $sieve[0] = false;
    $sieve[1] = true;

    for ($i = 2; $i <= $num; ++$i)
        $sieve[$i] = true;

    for ($i = 2; ($j = pow ($i)) <= $num; ++$i)
        if ($sieve[$i] == true)
            for ($j; $j <= $num; $j += $i)
                $sieve[$j] = false;

    return $sieve[$num];
}
