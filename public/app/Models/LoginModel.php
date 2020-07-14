<?php

namespace Frontend\Models;

class LoginModel extends Model
{
    /**
     * Проверка валидация пароля пользователя при авторизации
     * @param $login string Логин пользователя
     * @param $password string Пароль пользователя
     * @return bool Возвращает id пользователя при его успешной авторизации, если логин и пароль есть в БД, или false, если данные не корректные
     */
    public function checkUserAuth($login, $password)
    {
        $password = md5($password);
        $data = $this->db->query("select * from users where login = '$login' and password = '$password'");
        
        foreach ($data as $row) {
            return $row['id'];
        }
        return false;
    }
    
    /**
     * Запись в БД сгенерированного cookie пользователя
     * @param $id integer ID пользователя
     * @param $hash string Сгенерированный Хеш - cookie
     */
    public function installUserCookie($id, $hash){
        $this->db->exec("update users set cookie = '$hash' where id = $id");
    }
    
    /**
     * Создание учетной записи пользователя
     * @param $userInfo array Массив данных пользователя
     * @return bool|integer Возращает false в случае неудачи или ID зарегистрированного пользователя
     */
    public function registerUser($userInfo){
        $userInfo['password'] = md5($userInfo['password']);
        $query = "insert into users (firstname, lastname, age, sex, interests, city, login, password)
                    value ('{$userInfo['firstname']}','{$userInfo['lastname']}',{$userInfo['age']},'{$userInfo['sex']}',
                           '{$userInfo['interests']}','{$userInfo['city']}','{$userInfo['login']}','{$userInfo['password']}')";
        
        $this->db->exec($query);
        
        $data = $this->db->query("select * from users where login = '{$userInfo['login']}' and password = '{$userInfo['password']}'");
    
        foreach ($data as $row) {
            return $row['id'];
        }
        return false;
    }
}