<?php
namespace Server\Environment;

class Dotenv
{
    /**
     * Load .env to environment variables.
     */
    public static function load(): void
    {
        $lines = file(__DIR__ . '/../../.env');
        foreach ($lines as $line) {
            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            putenv(sprintf('%s=%s', $key, $value));
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}