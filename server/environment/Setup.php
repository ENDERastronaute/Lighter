<?php

function view(string $view)
{
    include Util\Plateform::transform_path(__DIR__ . "/../../app/Views/$view.php");
}

function component(string $component)
{
    include Util\Plateform::transform_path(__DIR__ . "/../../app/Components/$component.php");
}

function redirect(string $path)
{
    header("Location: $path");
}