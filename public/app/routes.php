<?php
// Массив роутеров

// Страница пользователя - открытие
$routes['userPage'] = array(
    "route" => "^(/user)+", // Регулярное выражение для поиска соотвествия с реальным урлом
    "controller" => "UserController", // Название файла класса / Название контроллера
    "action" => "index", // Название метода из класса
);

// Страница пользователя - удаление из друзей
$routes['deleteUserFriend'] = array(
    "route" => "^(/delFriend)+$",
    "controller" => "UserController",
    "action" => "deleteUserFriend",
);

// Страница пользователя - добавление в друзья
$routes['addUserFriend'] = array(
    "route" => "^(/addFriend)+$",
    "controller" => "UserController",
    "action" => "addUserFriend",
);

// Выход из учетной записи
$routes['LogoutUser'] = array(
    "route" => "^(/logout)+$",
    "controller" => "LoginController",
    "action" => "logout",
);

// Авторизация пользователя
$routes['LoginUser'] = array(
    "route" => "^(/login)+$",
    "controller" => "LoginController",
    "action" => "index",
);

// Регистрация пользователя
$routes['RеgisterUser'] = array(
    "route" => "^(/register)+$",
    "controller" => "LoginController",
    "action" => "register",
);

// Главная страница
$routes['MainController'] = array(
    "route" => "^(/)+$",
    "controller" => "MainController",
    "action" => "index",
);

