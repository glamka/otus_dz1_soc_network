<?php
/**
 * Class AppAuth Управление авторизацией пользователя
 */
class AppAuth{
    /**
     * @var Обьект подключения к БД
     */
    public $db;
    
    /**
     * Статус авторизации пользователя
     * @var bool|integer  false - не авторизован, id пользователя, под которым авторизован
     */
    
    public $isLogged = false;
    /**
     * @var bool
     */
    public $authChecked = false;
    
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->db = new PDO("mysql:host=".DB['host'].";dbname=".DB['name'], DB['user'], DB['password']);
    }
    
    /**
     * Возможность вызывать методы как статические через вызов инстанса
     * @return AppAuth
     */
    static function getInstance(){
        static $me = null;
        if ($me == null){
            $class = get_called_class();
            $me = new $class();
        }
        return $me;
    }
    
    /**
     * Проверка авторизации
     * @return bool
     */
    public function checkAuth(){
       if ($this->authChecked){
            return $this->isLogged;
        }
        elseif ($userID = $this->authSessionCheck()){
            $this->isLogged = $userID;
        }
        elseif ($userID = $this->authCookieCheck()){
            $this->isLogged = $userID;
        }
        elseif (isset($_POST['login'],$_POST['password'])){
            if ($userID = $this->authPost($_POST['login'],$_POST['password'])){
                $this->isLogged = $userID;
            }
        }
        $this->authChecked = true;
        return $this->isLogged;
    }
    
    /**
     * Проверка куков при авторизации и сохранение их в сессию
     * @return bool
     */
    private function authCookieCheck(){
        if (isset($_COOKIE['hash'], $_COOKIE['login'])){
            $login = $_COOKIE['login'];
            $loginHash = $_COOKIE['hash'];
    
            $data = $this->db->query("select * from users where login = '$login' and cookie = '$loginHash'");
    
            foreach ($data as $row) {
                AppSession::save("login", $_COOKIE['login']);
                AppSession::save("hash", $_COOKIE['hash']);
                
                return $row['id'];
            }
        }
        return false;
    }
    
    /**
     * Проверка авторизации сессии - сравнение со значениями в БД хеша и логина пользователя
     * @return bool|integer
     */
    private function authSessionCheck(){
        $login = AppSession::get('login');
        $loginHash = AppSession::get('hash');
        
        if (isset($login, $loginHash)){
            
            $data = $this->db->query("select * from users where login = '$login' and cookie = '$loginHash'");
    
            foreach ($data as $row) {
                return $row['id'];
            }
        }
        return false;
    }
    
    /**
     * Проверка логина и пароля и установка их при успешной валидации в куки и сессию
     * @param $login
     * @param $password
     * @return bool
     */
    private function authPost($login, $password){
        $password = md5($password);
        $data = $this->db->query("select * from users where login = '$login' and password = '$password'");
        
        foreach ($data as $row) {
            $this->authRemember($login, $password);
            return $row['id'];
        }
        return false;
    }
    
    /**
     * Установка куков авторизации
     * @param $login
     * @param $password
     */
    public function authRemember($login, $password){
        $hash = md5(microtime(true).$password);
        
        $this->db->exec("update users set cookie = '$hash' where login = $login");
    
        // Установка значений в сессии
        \AppSession::save("login", $login);
        \AppSession::save("hash", $hash);
    
        // Установка значений в куках
        setcookie('login', $login, time() + 180 * 24 * 60 * 60, "/");
        setcookie('hash', $hash, time() + 180 * 24 * 60 * 60, "/");
    }
}