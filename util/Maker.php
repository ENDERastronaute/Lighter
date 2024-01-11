<?php
namespace Util;

class Maker
{
    public static function createRepository(string $name)
    {
        $name .= "Repository";

        $template_file = fopen(__DIR__ . '/../server/templates/Repository.txt', 'r');

        $template = fread($template_file, filesize(__DIR__ . '/../server/templates/Repository.txt'));

        $repository = self::replaceClassnamePlaceholder($template, $name);

        $repository_file = fopen(__DIR__ . "/../repository/$name.php", "w");

        fwrite($repository_file, $repository);

        fclose($repository_file);
    }

    public static function createController(string $name)
    {
        $name .= "Controller";

        $template_file = fopen(__DIR__ . "/../server/templates/Controller.txt", 'r');

        $template = fread($template_file, filesize(__DIR__ . '/../server/templates/Controller.txt'));

        $controller = self::replaceClassnamePlaceholder($template, $name);

        $controller_file = fopen(__DIR__ . "/../app/Controllers/$name.php", 'w');

        fwrite($controller_file, $controller);

        fclose($controller_file);
    }

    public static function createResource(string $name)
    {
        $controllerName = ucfirst($name) . "Controller";
        $repositoryName = ucfirst($name) . "Repository";
        $repoName = ucfirst($name) . "Repo";

        $template_file = fopen(__DIR__ . "/../server/templates/Resource.txt", 'r');

        $template = fread($template_file, filesize(__DIR__ . '/../server/templates/Resource.txt'));
        
        $controller = self::replaceClassnamePlaceholder($template, $controllerName);
        $controller = self::replaceRepositorynamePlaceholder($controller, $repositoryName);
        $controller = self::replaceRepositorynamePlaceholder($controller, $repoName, true);

        $controller_file = fopen(__DIR__ . "/../app/Controllers/$controllerName.php", 'w');

        fwrite($controller_file, $controller);

        fclose($controller_file);

        self::createRepository($name);
    }

    private static function replaceClassnamePlaceholder(string $template, string $name)
    {
        return str_replace('{classname}', $name, $template);
    }

    private static function replaceRepositorynamePlaceholder(string $template, string $name, bool $short = false)
    {
        if ($short) {
            return str_replace('{shortrepositoryname}', $name, $template);
        }
        
        return str_replace('{repositoryname}', $name, $template);
    }
}