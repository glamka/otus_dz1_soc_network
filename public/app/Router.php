<?php

namespace Frontend;


class Router
{
    // массив с маршрутами
    private $routes;
    private $uri;
    
    private $controllerName;
    private $actionName;

    /**
     * Router constructor.
     */
    public function __construct(array $routes, string $uri)
    {
        $this->routes = $routes;
        $this->uri = $uri;
    }

    public function run()
    {
        // Поиск нужного роутера (контроллера и метода) по текущему урлу
        $this->isFoundRoute();

        if($this->isUserAuth()){
            $this->runController();
        }else{
            $this->uri = '/login';
        }
    }
    
    /**
     * Поиск нужного роутера, посредством перебора регулярок и текущего урла
     * И при удачном поиске получение в глобальные переменные названия контроллера и метода действия
     * При неудачном поиске - выводим главную страницу
     * @return bool true - роутер найден, false - роутер не найден
     */
    private function isFoundRoute()
    {
        // Определение маршрута и действия ->  чек регуляроками из файла роутерс открытого урла
        foreach ($this->routes as $route){
            if (preg_match("~".$route['route']."~", $this->uri, $matches)){
            $this->controllerName = $route['controller'];
            $this->actionName = $route['action'];
            
            return true;
            }
        }
        
        // Если роутеры не найдены, переадресовывает на главную страницу
        $this->uri = '/';
        $this->controllerName = $this->routes['MainController']['controller'];
        $this->actionName = $this->routes['MainController']['action'];
        return false;
    }
    
    /**
     * Запуск контроллера и необходимого метода
     */
    public function runController()
    {
        $controllerName = '\Frontend\\Controllers\\'.$this->controllerName;

        // Запускаем соответствующий входящему пути контроллер и метод
        $controller = new $controllerName();
        $controller->{$this->actionName}();
    }
    
    /**
     * Проверка на авторизацию пользователя
     * @return bool
     */
    public function isUserAuth(){
        // код проверки
        return true;
}

}