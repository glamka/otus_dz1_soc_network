<?php

namespace Frontend\Controllers;

use Frontend\Models\TestModel;

class TestController
{
    public function index()
    {
        echo 'Тестовая страница';
        // получаем данные из ДБ и выводим
        echo $this->getData();

}
    public function getData(){
        $testModel = new TestModel();
       return $testModel->getDataFromDB();
    }
}