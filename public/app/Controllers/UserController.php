<?php

namespace Frontend\Controllers;

use Frontend\Models\UserModel;
use Frontend\Template;

class UserController
{
    /**
     * Построение страницы пользователя
     */
    public function index()
    {
        $content = '';
        
        // Проверка куков или сессии пользователя и возврат ID пользователя, при успешной авторизации
        $checkAuthUserId = \AppAuth::getInstance()->checkAuth();
        
        // Если авторизация не проходит, идет редирект на страницу Логина
        if ($checkAuthUserId === false){
            header("Location: /login");
        }
        else{
            $formUserLogout = Template::render('Views/user_logout.tpl.php',[$checkAuthUserId]);
            $content .= $formUserLogout;
        }
        
        // Строит форму с данными пользователя по его ID если он известен
        if (isset($_GET['userId']) && !empty($_GET['userId'])){
            $userId = (int)$_GET['userId'];
    
            $userInfo = $this->getUserInfo($userId);
            $friendsList = $this->getFriendsList($userId);
            $usersList = $this->getUsersList($userId);
        }
        
        if (isset($userId,$userInfo)){
            $formUser = Template::render('Views/user.tpl.php',$userInfo);
        }
        else{
            $formUser = Template::render('Views/user_empty.tpl.php',[]);
        }
        
        $content .= $formUser;

        // Если совпадает ID авторизованного пользователя и запрашиваемого пользователя, то выводятся блоки данных с друзьями пользователя и возможностью их редактировать
        if (isset($userId,$userInfo) && $checkAuthUserId == $userId){
            if (isset($friendsList)){
                $formFriendsList = Template::render('Views/user_friends.tpl.php',$friendsList);
                $content .= $formFriendsList;
            }
    
            if (isset($usersList)){
                $formUsersList = Template::render('Views/users_list.tpl.php',$usersList);
                $content .= $formUsersList;
            }
        }
        
        $vars = [
            'titlePage'=>'Страница пользователя',
            'content'=>$content,
            'header'=>'Страница пользователя'
        ];
        
        echo Template::render('Views/main.tpl.php',$vars);
    }
    
    /**
     * Удаление пользователя из друзей по его ID и ID родительского пользователя
     * Редирект обратно на страницу пользователя
     */
    public function deleteUserFriend(){
        if(isset($_POST['parentUserId']) && isset($_POST['delFriendId'])){
            $userModel = new UserModel();
            $userModel->deleteUserFriend((int)$_POST['parentUserId'], (int)$_POST['delFriendId']);
    
            header('Location: /user?userId='.(int)$_POST['parentUserId'],true, 301);
        }
    }
    
    /**
     * Добавление пользователя в друзья по его ID и ID родительского пользователя
     * Редирект обратно на страницу пользователя
     */
    public function addUserFriend(){
        if(isset($_POST['parentUserId']) && isset($_POST['addFriendId'])){
            $userModel = new UserModel();
            $userModel->addUserFriend((int)$_POST['parentUserId'], (int)$_POST['addFriendId']);
            
            header('Location: /user?userId='.(int)$_POST['parentUserId'],true, 301);
        }
    }
    
    /**
     * Получает массив данных пользователя
     * @param $id integer ID пользователя
     * @return array|null Массив данных пользователя
     */
    private function getUserInfo($id){
        $userModel = new UserModel();
        return $userModel->getUserInfo($id);
    }
    
    /**
     * Получает массив данных пользователей
     * @param $id integer ID пользователя для которого нужно получить массив данных пользователей, не являющихся его друзьями
     * @return array|null Массив данных пользователей
     */
    private function getUsersList($id){
        $userModel = new UserModel();
        return $userModel->getUsersList($id);
    }
    
    /**
     * Получает массив данных друзей пользователя
     * @param $id integer ID пользователя чьих друзей необходимо получить
     * @return array|null Массив друзей пользователя
     */
    private function getFriendsList($id){
        $userModel = new UserModel();
        return $userModel->getFriendsList($id);
    }
}