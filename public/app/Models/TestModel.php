<?php

namespace Frontend\Models;


class TestModel extends Model
{

    public function getDataFromDB()
    {
        return $this->db->exec('select * from friends');
    }
}