<?php

namespace Frontend\Controllers;


use Frontend\Template;

class MainController
{
    public function index()
    {
        $formFirst = Template::render('Views/form_first.tpl.php',[]);
        
        $vars = [
            'titlePage'=>'Основная страница',
            'content'=>$formFirst,
            'header'=>'Основная страница'
        ];
        
        echo Template::render('Views/main.tpl.php',$vars);
    }
}