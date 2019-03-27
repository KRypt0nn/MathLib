<?php

namespace MathLib\Math;

function div ($num, $div)
{
    return (int)($num / $div);
}

function mod ($num, $mod)
{
    return $num - div ($num, $mod) * $mod;
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
                $step *= $base;

            $base *= $base;
            $exp >>= 1;
        }

        return $step;
    }
}

function powmod ($base, $exp = 2, $mod = 2)
{
    $t = powmod ($base, div ($exp, 2), $mod);
    
    return $exp % 2 == 0 ?
        pow ($t, 2) % $mod :
        $base * pow ($t, 2) % $mod;
}

function root ($num, $step = 2)
{
    $l = 1;
    $r = $num;

    while ($l + 1 < $r)
    {
        $m      = div (($l + $r), 2);
        $result = pow ($m, $step);

        if ($result == $num)
            return $m;

        elseif ($result < $num)
            $l = $m;

        else $r = $m;
    }

    return $m;
}

function fib ($num)
{
    $dp[0] = 0;
    $dp[1] = 1;

    for ($i = 2; $i <= $num; ++$i)
        $dp[$i] = $dp[$i - 1] + $dp[$i - 2];

    return $dp[$num];
}

function fact ($num)
{
    $result = 1;

    for ($i = 2; $i <= $num; ++$i)
        $result *= $i;

    return $result;
}

function is_simple ($num)
{
    for ($i = 2; $i <= $num; ++$i)
        $sieve[$i] = true;

    for ($i = 2; ($j = pow ($i)) <= $num; ++$i)
        if ($sieve[$i] == true)
            for ($j; $j <= $num; $j += $i)
                $sieve[$j] = false;

    return !$sieve[$num];
}
