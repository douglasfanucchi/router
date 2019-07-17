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
     * Identifies which Controller@Action to call depending on the $uri
     * @param String $uri - Route being accessed
     * @return bool - Wheter or not the route matched
     */
    public function parser(String &$uri) : bool {
        $routes = $this->getRoutes( $this->getRequestMethod() );

        if( empty($routes) )
            return false;

        foreach( $routes as $route => $controllerAction ) {
            $regex = $this->getRouteRegex($route);

            if( preg_match($regex, $uri, $params) ) {
                $this->changeUri($uri, $controllerAction, $params);
                return true;
            }
        }
        return false;
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
    
    /**
     * Get routes according to the Request method
     * @param String $reqMethod - Request method
     * @return Array
     */
    private function getRoutes(String $reqMethod) : Array {
        if( empty($reqMethod) )
            return [];

        switch( $reqMethod ) {
            case 'GET':
               return self::$get_routes;
            case 'POST':
               return  self::$post_routes;
            case 'PUT':
               return  self::$put_routes;
            case 'DELETE':
               return  self::$delete_routes;
            default:
                return [];
        }
    }

    /**
     * Make a regex pattern based on $route
     * @param String $route - Route 
     * @return String
     */
    private function getRouteRegex(String $route) : String {
        $route = preg_replace("/\{[A-z0-9]{1,}\}/", "([A-z0-9]{1,})", $route);
        $route = preg_replace("/\//", "\/", $route);
        return "/^" . $route . "$/";
    }

    private function changeUri(Sting $uri, String $controllerAction, Array $params) : void {
        array_shift($params);

        foreach($params as $param)
            $controllerAction = preg_replace("/(\:[A-z0-9]{1,})/", $param, $controllerAction, 1);

        $uri = $controllerAction;
    }

    private function getRequestMethod() : String {
        return $_SERVER["REQUEST_METHOD"];
    }
}