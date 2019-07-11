<?php
/**
 * Douglas Fanucchi <douglasfanucchi@gmail.com>
 * Router library to use on my MVC strutcture
 * Repository: https://github.com/douglasfanucchi/router
 */
namespace fanucchi\Router;

use fanucchi\Router\Interfaces\RouterInterface;

class Router implements RouterInterface {
    private $instace = null, $get_routes = [], $post_routes = [], $put_routes = [], $delete_routes = [];

    private function __construct() {}

    public static function getInstance() : self {
        if( self::$instance === null )
            self::$instance = new self;

        return self::$instance;
    }

    public function get() : bool {}
    public function post() : bool {}
    public function put() : bool {}
    public function delete() : bool {}
    
    private function getRequestMethod() : String {
        return $_SERVER["REQUEST_METHOD"];
    }
}