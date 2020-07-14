<?php
namespace Frontend;

session_start();
// Композер
require __DIR__.'/../vendor/autoload.php';

// Подключаем файл конфигурации
require __DIR__.'/app/config.php';

// Подключаем список маршрутов
require __DIR__.'/app/routes.php';

// Класс для работы с сессиями
require __DIR__."/classes/session.class.php";

// Класс для работы с авторизацией
require __DIR__."/classes/auth.class.php";

// Узнаем путь с которого пришел запрос
$uri  = $_SERVER['REQUEST_URI'];

// Создаем роутер управляющий приложением
$router = new Router($routes,$uri);

// Запускаем обработку входящего пути
$router->run();

