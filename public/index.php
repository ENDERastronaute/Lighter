<?php
    session_start();

    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/../routes/Web.php';

    use \Server\Router\Router;
    use \Server\Environment\Dotenv;

    Dotenv::load();
    Router::on();
?>