<?php
/**
 * Douglas Fanucchi <douglasfanucchi@gmail.com>
 * Router library to use on my MVC strutcture
 * Repository: https://github.com/douglasfanucchi/router
 */
namespace fanucchi\Router;

use fanucchi\Router\Interfaces\RouterInterface;

class Router implements RouterInterface {
    private static $instance = null, $get_routes = [], $post_routes = [], $put_routes = [], $delete_routes = [];

    private function __construct() {}

    public static function getInstance() : self {
        if( self::$instance === null )
            self::$instance = new self;

        return self::$instance;
    }

    /**
     * Register Route/Controller@Action in the self::$get_routes
     * @param String $route - The route to be accessed
     * @param String $controllerAction - The Controller@Action to be called
     * @return bool
     */
    public function get(String $route, String $controllerAction) : bool {
        return self::registerRoute("get", $route, $controllerAction);
    }

    /**
     * Register Route/Controller@Action in the self::$post_routes
     * @param String $route - The route to be accessed
     * @param String $controllerAction - The Controller@Action to be called
     * @return bool
     */
    public function post(String $route, String $controllerAction) : bool {
        return self::registerRoute("put", $route, $controllerAction);
    }

    /**
     * Register Route/Controller@Action in the self::$put_routes
     * @param String $route - The route to be accessed
     * @param String $controllerAction - The Controller@Action to be called
     * @return bool
     */
    public function put(String $route, String $controllerAction) : bool {
        return self::registerRoute("put", $route, $controllerAction);
    }

    /**
     * Register Route/Controller@Action in the self::$delete_routes
     * @param String $route - The route to be accessed
     * @param String $controllerAction - The Controller@Action to be called
     * @return bool
     */
    public function delete(String $route, String $controllerAction) : bool {
        return self::registerRoute("delete", $route, $controllerAction);
    }
    
    /**
     * Register Route/Controller@Action in a certain array which represents the request method routes.
     * @param String $reqMethod - Request method, used to identify which array the info should be saved.
     * @param String $route - The route to be accessed
     * @param String $controllerAction - Controller@Action to be called
     * @return bool
     */
    private function registerRoute(String $reqMethod, String $route, String $controllerAction) : bool {
        if( empty($reqMethod) || empty($route) || empty($controllerAction) || !preg_match("/\@/", $controllerAction) || !preg_match("/\//", $route) ) 
            return false;

        switch( $reqMethod ) {
            case 'get':
                self::$get_routes[] = [$route => $controllerAction];
                break;
            case 'post':
                self::$post_routes[] = [$route => $controllerAction];
                break;
            case 'put':
                self::$put_routes[] = [$route => $controllerAction];
                break;
            case 'delete':
                self::$delete_routes[] = [$route => $controllerAction];
                break;
            default:
                return false;
        }

        return true;
    }

    private function getRequestMethod() : String {
        return $_SERVER["REQUEST_METHOD"];
    }
}