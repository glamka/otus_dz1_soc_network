<?php
/**
 * Class AppSession Управление сессией
 */
class AppSession{
    /**
     * Получить значение по ключу сессии
     * @param $key
     * @return bool|mixed
     */
    static function get($key){
        if (!isset($_SESSION["app_data"])){
            $_SESSION["app_data"] = array();
        }
        
        if (!isset($_SESSION["app_data"][$key])) {
            return false;
        }
        
        return $_SESSION["app_data"][$key];
    }
    
    /**
     * Сохранить значения ключа в сессии
     * @param $key string Ключ
     * @param $val string Значение
     */
    static function save($key, $val){
        $_SESSION["app_data"][$key] = $val;
    }
}