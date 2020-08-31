<?php


function echoln(string $var, $eol = PHP_EOL)
{
    echo $var . PHP_EOL;
}

function print_json($var, $eol = PHP_EOL)
{
    echo json_encode($var, JSON_PRETTY_PRINT) . $eol;
}

function dd($var)
{
    var_dump($var);
    die;
}

function env(string $key, $default = "")
{
    return $_ENV[$key] ?? $default ?: '';
}

function allWithValuesOrThrow(array $vars): void{

    if (empty($vars)) {
       throw new InvalidArgumentException("Empty variable given");
    }

    foreach ($vars as $key => $var) {
        if (empty($var)) {
            throw new InvalidArgumentException("Variable key {$key} empty.");
        }
    }
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();