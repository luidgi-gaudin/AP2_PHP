<?php

namespace App\Core;

class Autoloader
{
    /**
     * Enregistre notre autoloader
     */
    public static function register(): void
    {
        spl_autoload_register([self::class, 'autoload']);
    }

    /**
     * Inclut le fichier correspondant à la classe
     */
    public static function autoload(string $class): void
    {
        $class = str_replace('\\', '/', $class);
        $class = strtolower(dirname($class)) . '/' . basename($class) . '.php';

        // On ne tient compte que des classes de notre application
        if (strpos($class, 'app/') === 0) {
            $file = '../' . $class;
        } else {
            $file = '../app/' . $class;
        }

        // Si le fichier existe, on l'inclut
        if (file_exists($file)) {
            require_once $file;
        }
    }
}