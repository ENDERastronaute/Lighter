<?php
namespace Server\Environment;

use Util\Plateform;

class Dotenv
{

   public static function load(): void
   {
       $lines = file(__DIR__ . Plateform::transform_path('/../../.env'));
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