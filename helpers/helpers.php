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