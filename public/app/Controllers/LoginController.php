<?php

namespace Frontend\Controllers;

use Frontend\Models\LoginModel;
use Frontend\Template;

class LoginController
{
    /**
     * Авторизация пользователя
     * Проверка валидности пароля -> редирект на страницу пользователя
     */
    public function index()
    {
        // Проверка куков или сессии пользователя и возврат ID пользователя, при успешной авторизации
        $checkAuthUserId = \AppAuth::getInstance()->checkAuth();
    
        // Если пользователь уже авторизован, редирект на страницу пользователя
        if ($checkAuthUserId !== false){
            @header("Location: /user?userId=$checkAuthUserId");
        }
        
        // Если есть данные для авторизации - попытка авторизации
        if (isset($_POST['password'],$_POST['login'])){
            $this->authProcess();
        } else {
            $formLogin = Template::render('Views/login.tpl.php', []);
    
            $vars = [
                'titlePage'=>'Страница авторизации',
                'content'=>$formLogin,
                'header'=>'Страница авторизации'
            ];
            
            echo Template::render('Views/main.tpl.php', $vars);
        }
    }
    
    /**
     * Выход из учетной записи пользователя
     * Закрытие сессии, удаление куков
     * Редирект на главную страницу
     */
    public function logout(){
        // Проверка куков или сессии пользователя и возврат ID пользователя, при успешной авторизации
        $checkAuthUserId = \AppAuth::getInstance()->checkAuth();
    
        // Если пользователь уже авторизован, выход из учетной записи
        if ($checkAuthUserId !== false){
            setcookie('login', "", time() + 180 * 24 * 60 * 60, "/");
            setcookie('hash', "", time() + 180 * 24 * 60 * 60, "/");
            
            \AppSession::save("login", false);
            \AppSession::save("hash", false);
            
            session_destroy();
            
            $_COOKIE['hash'] = null;
            $_COOKIE['login'] = null;
            
            unset($_COOKIE['hash']);
            unset($_COOKIE['login']);
            
            header("Location: /");
        }
    }
    
    /**
     * Регистрация нового пользователя
     * Проверка авторизации пользователя
     * Проверка необходимых полей и регистрация нового аккаунта
     */
    public function register(){
        // Проверка куков или сессии пользователя и возврат ID пользователя, при успешной авторизации
        $checkAuthUserId = \AppAuth::getInstance()->checkAuth();
    
        // Если пользователь уже авторизован, редирект на страницу пользователя
        if ($checkAuthUserId !== false){
            @header("Location: /user?userId=$checkAuthUserId");
        }
    
        // Если есть данные для регистрации - попытка регистрации
        if (isset($_POST['login'],$_POST['password'],$_POST['firstname'],$_POST['lastname'],$_POST['age'],$_POST['sex'],$_POST['interests'],$_POST['city'])){
            $this->registerProcess();
        } else {
            $formLogin = Template::render('Views/register.tpl.php', []);
        
            $vars = [
                'titlePage'=>'Страница регистрации',
                'content'=>$formLogin,
                'header'=>'Страница регистрации'
            ];
        
            echo Template::render('Views/main.tpl.php', $vars);
        }
    }
    
    /**
     * Авторизация пользователя
     * Валидация пароля, сохранение куков и сессии -> Редирект на страницу пользователя
     */
    private function authProcess(){
        $login = $_POST['login'];
        $password = $_POST['password'];
        
        $loginModel = new LoginModel();
        $userId = $loginModel->checkUserAuth($login, $password);
        
        // Если произошла успешная валидация -> сохраняются куки пользователя
        if($userId !== false){
            $hash = md5(microtime(true).$password);
            $loginModel->installUserCookie($userId, $hash);
            
            // Установка значений в сессии
            \AppSession::save("login", $login);
            \AppSession::save("hash", $hash);
            
            // Установка значений в куках
            setcookie('login', $login, time() + 180 * 24 * 60 * 60, "/");
            setcookie('hash', $hash, time() + 180 * 24 * 60 * 60, "/");
            
            if (!empty($_GET['back'])){
                @header("Location: {$_GET['back']}");
            }
            else{
                @header("Location: /user?userId=$userId");
            }
        }
        else{
            @header("Location: /login");
        }
    }
    
    /**
     * Процесс регистрации пользователя, создания новой учетной записи
     * Сохранение куков и сессии после успешной регистрации
     */
    private function registerProcess(){
        $userInfo['login'] = $_POST['login'];
        $userInfo['password'] = $_POST['password'];
        $userInfo['firstname'] = $_POST['firstname'];
        $userInfo['lastname'] = $_POST['lastname'];
        $userInfo['age'] = (int)$_POST['age'];
        $userInfo['sex'] = $_POST['sex'];
        $userInfo['interests'] = $_POST['interests'];
        $userInfo['city'] = $_POST['city'];
    
        $loginModel = new LoginModel();
        $userId = $loginModel->registerUser($userInfo);
        
        // Если произошла успешная регистрация -> сохраняются куки пользователя и дальнейший редирект
        if($userId !== false){
            $hash = md5(microtime(true).$userInfo['password']);
            $loginModel->installUserCookie($userId, $hash);
        
            // Установка значений в сессии
            \AppSession::save("login", $userInfo['login']);
            \AppSession::save("hash", $hash);
        
            // Установка значений в куках
            setcookie('login', $userInfo['login'], time() + 180 * 24 * 60 * 60, "/");
            setcookie('hash', $hash, time() + 180 * 24 * 60 * 60, "/");
        
            if (!empty($_GET['back'])){
                @header("Location: {$_GET['back']}");
            }
            else{
                @header("Location: /user?userId=$userId");
            }
        }
        else{
            @header("Location: /register");
        }
    }
}