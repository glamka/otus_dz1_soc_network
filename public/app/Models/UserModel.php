<?php

namespace Frontend\Models;


class UserModel extends Model
{
    /**
     * Получение из БД информации по пользователю по его ID
     * @param $id integer ID пользователя
     * Сборка данных пользователя в массив
     * @return array|null Массив данных пользователя или null при его отсутствии
     */
    public function getUserInfo($id)
    {
        $result = null;
        
        $data = $this->db->query('select * from users where id = '.$id);
        foreach ($data as $row) {
            $result['id'] = $row['id'];
            $result['firstname'] = $row['firstname'];
            $result['lastname'] = $row['lastname'];
            $result['age'] = $row['age'];
            $result['sex'] = $row['sex'];
            $result['interests'] = $row['interests'];
            $result['city'] = $row['city'];
        }
        return $result;
    }
    
    /**
     * Получение данных всех пользователей из БД
     * @param $id integer ID пользователя для которого нужно получить массив данных пользователей, не являющихся его друзьями
     * @return array|null Массив данных пользователя или null при его отсутствии
     */
    public function getUsersList($id){
        $result = null;
    
        $data = $this->db->query("select * from users where id not in (select user_two from friends where user_one = $id and status = '2') and id != $id");
        foreach ($data as $key => $row) {
            $result[$key]['id'] = $row['id'];
            $result[$key]['firstname'] = $row['firstname'];
            $result[$key]['lastname'] = $row['lastname'];
            $result[$key]['age'] = $row['age'];
            $result[$key]['sex'] = $row['sex'];
            $result[$key]['interests'] = $row['interests'];
            $result[$key]['city'] = $row['city'];
            $result[$key]['parentUserId'] = $id;
        }
        return $result;
    }
    
    /**
     * Получение из БД друзей пользователя по его ID
     * @param $id integer ID пользователя
     * @return array|null Массив друзей пользователя или null при их отсутствии
     */
    public function getFriendsList($id)
    {
        $result = null;
        
        $data = $this->db->query("select * from users where id in (select user_two from friends where user_one = $id and status = '2')");
        foreach ($data as $key => $row) {
            $result[$key]['id'] = $row['id'];
            $result[$key]['firstname'] = $row['firstname'];
            $result[$key]['lastname'] = $row['lastname'];
            $result[$key]['age'] = $row['age'];
            $result[$key]['sex'] = $row['sex'];
            $result[$key]['interests'] = $row['interests'];
            $result[$key]['city'] = $row['city'];
            $result[$key]['parentUserId'] = $id;
        }
        return $result;
    }
    
    /**
     * Удаление пользователя из друзей по его ID и ID родительского пользователя
     * TODO При удалении из друзей, у того друга, который отклонил в дружбе, появляется статус - 0, вторая дублирующая запись удаляется';
     * При удалении удаляются обе обратные записи
     */
    public function deleteUserFriend($userId, $friendId){
        $this->db->exec("delete from friends where user_two = $userId and user_one = $friendId;");
        $this->db->exec("delete from friends where user_two = $friendId and user_one = $userId;");
        //$this->db->exec("delete from friends where user_two = $userId and user_one = $friendId;");
        //$this->db->exec("update friends set status = '0' where user_one = $userId and user_two = $friendId;");
    }
    
    /**
     * Добавление пользователя в друзья по его ID и ID родительского пользователя
     * При добавлении в друзья создается запись с полями, где user_one - инициатор дружбы, user_two - пользователь, кому предлагается дружба
     * и устанавливается статус записи - 2, и создается аналогичная обратная запись
     * TODO - другая вариация подхода и устанавливается статус записи 1 и подается только заявка
     */
    public function addUserFriend($userId, $friendId){
        $this->db->exec("insert into friends (user_one, user_two, status) value ($userId, $friendId, '2')");
        $this->db->exec("insert into friends (user_one, user_two, status) value ($friendId, $userId, '2')");
    }
}
