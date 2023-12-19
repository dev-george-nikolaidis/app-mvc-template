<?php

declare(strict_types=1);

namespace Src\helpers;

class Debugger
{
    public static function log(string $message, string $file = 'debug.log')
    {
        $timestamp = date("[Y-m-d H:s:s]");
        $logMessage = "$timestamp $message\n";

        // Log to a file
        file_put_contents($file, $logMessage, FILE_APPEND);

        // Output to the console
        echo $logMessage;
    }



    public static function dump(mixed $var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
    public static function dd(mixed $var)
    {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        die();
    }

}
