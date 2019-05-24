<?php

/**
 * @param string   $domaine
 * @param int|null $key
 */
function domaine($domaine, $key = null)
{
    echo "\n\n-------------------------------------\n\n$key - $domaine\n\n-------------------------------------\n\n";
}

/**
 * @param int $key
 */
function d($key)
{
    var_dump($key);
}

/**
 * @param string $var
 */
function e($var)
{
    echo "\n\n" . $var . "\n\n";
}
