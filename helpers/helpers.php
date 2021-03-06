<?php

function dd($value)
{
    die(var_dump($value));
}

function templatePath()
{
    return __DIR__ . "/../template";
}

function pageNotFound()
{
    header("Location: index.php?page=404");
    exit();
}

function sanitizeArray($array)
{
    array_walk_recursive($array, function(&$data) {
        $data = htmlentities($data);
    });

    return $array;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || strpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== FALSE;
}