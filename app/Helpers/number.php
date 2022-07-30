<?php

function numbFormat(int $num)
{
    return number_format($num, 0, '.', '.');
}

function spell(int $num, $lang = 'id')
{
    if (!class_exists(NumberFormatter::class)) {
        return $num;
    }

    $f = new NumberFormatter($lang, NumberFormatter::SPELLOUT);
    return $f->format($num);
}
