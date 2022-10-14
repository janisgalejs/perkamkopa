<?php

/**
 * Generate full file path from views directory or include empty if the file not exists.
 *
 * @param $path
 * @return string
 */
function views_path($path = ''): string
{
    $path = VIEWS_PATH . $path . '.php';

    if (file_exists($path)) {
        return $path;
    }

    return VIEWS_PATH . 'layout/empty.php';
}

/**
 * Simple debug function
 *
 * @param $value
 * @return void
 */
function dd($value)
{
    var_dump($value);
    die();
}