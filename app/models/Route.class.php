<?php declare(strict_types=1);

if (!defined('DEFAULT_CONTROLLERS_PATH')) {
    define('DEFAULT_CONTROLLERS_PATH', __DIR__ . '/../controllers/');
}
define('DEFAULT_CONTROLLER_SUFFIX', '_controller.php');
define('DEFAULT_CONTROLLERS_FORMAT', 'html');

define('ROUTE_MANAGE_FILES', true);

/**
 * Gestion des routes
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Route
{
    /**
     * @var array
     */
    protected static $routes = [];

    /**
     * @var array
     */
    protected static $action_params = [];

    /**
     * @var string
     */
    protected static $controllers_path = DEFAULT_CONTROLLERS_PATH;

    /**
     * @var string
     */
    protected static $controller_suffix = DEFAULT_CONTROLLER_SUFFIX;

    /**
     * @var string
     */
    protected static $http_code = '200';

    /**
     * @var string
     */
    public static $response_format = DEFAULT_CONTROLLERS_FORMAT;

    /**
     * @param string
     */
    static function set_http_code($code)
    {
        self::$http_code = $code;
    }

    /**
     * @param array
     */
    static function map_connect($params)
    {
        $extra_params = $params;
        foreach (['path', 'controller', 'action', 'method'] as $key) {
            unset($extra_params[$key]);
        }
        if (empty($params['method'])) {
            $params['method'] = 'GET';
        }
        array_push(self::$routes, [
            'controller' => $params['controller'],
            'path' => $params['path'],
            'splitted_path' => explode('/', $params['path']),
            'method' => strtoupper($params['method']),
            'action' => $params['action'],
            'extra_params' => $extra_params,
        ]);
    }

    /**
     * @param string
     * @return mixed
     */
    static function params($key)
    {
        if (!isset(self::$action_params[$key])) {
            return null;
        }

        return self::$action_params[$key];
    }

    /**
     * @param array $params parmètres
     */
    static function find_route(array $params)
    {
        $response_format = DEFAULT_CONTROLLERS_FORMAT;
        $method = $params['method'];
        $path = $params['path'];
        $matches = [];
        $path = str_replace('?', '', $path);
        $path = str_replace($_SERVER['QUERY_STRING'], '', $path);
        if ((preg_match('/^(.+)[.]([a-z0-9-]+)$/i', $path, $matches)) > 0) {
            $path = $matches[1];
            $response_format = $matches[2];
        }
        unset($matches);
        $splitted_path = explode('/', $path);
        $sizeof_splitted_path = count($splitted_path);

        $ret = false;
        foreach (self::$routes as $route) {
            if (strcasecmp($route['method'], $method) !== 0) {
                continue;
            }
            $ret = self::_examine_splitted_paths(
                [
                    'route' => $route,
                    'splitted_path' => $splitted_path,
                    'route_splitted_path' => $route['splitted_path'],
                ]
            );
            if ($ret === false) {
                continue;
            }
            break;
        }
        if ($ret === false) {
            return false;
        }
        return [
            'route' => $route,
            'action' => $ret['action'],
            'response_format' => $response_format,
            'extra_params' => $ret['extra_params'],
        ];
    }

    /**
     * @param string $file fichier
     */
    static function load(string $file)
    {
        if (file_exists($file) && is_readable($file)) {
            $routes = file($file);
            foreach ($routes as $route) {
                $r = explode('|', trim($route));
                self::map_connect(
                    [
                        'controller' => (string) $r[0],
                        'action' => (string) $r[1],
                        'method' => (string) $r[2],
                        'path' => (string) $r[3]
                    ]
                );
            }
            return true;
        }
        return false;
    }

    /**
     *
     */
    static function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = '';
        if (isset($_SERVER['PATH_INFO'])) {
            $path = $_SERVER['PATH_INFO'];
        }
        $ret = self::find_route(
            [
                'method' => $method,
                'path' => $path,
            ]
        );
        if ($ret === false) {
            self::_route_log('-', '-', 'Route non trouvée : ' . $method . ' - ' . $path);
            header('HTTP/1.0 404 Not Found');
            die("404 <script>window.location='" . HOME_URL . "/map?from=404'</script>");
        }
        self::_init_params();
        self::$action_params = array_merge(
            self::$action_params,
            $ret['extra_params']
        );
        $route = $ret['route'];
        $action = $ret['action'];
        $response_format = $ret['response_format'];
        $controller = $route['controller'];
        $controller_file = self::$controllers_path . preg_replace('/[^a-z0-9-]/i', '_', $controller) . self::$controller_suffix;
        if (file_exists($controller_file) === false) {
            self::_route_log($controller, $action, 'Contrôleur inaccessible');
            header('HTTP/1.0 503 Service Unavailable');
            die('503');
        }
        include_once $controller_file;
        if (is_callable(['Controller', $action]) === false) {
            self::_route_log($controller, $action, 'Action non implémentée dans le contrôleur');
            header('HTTP/1.0 501 Not implemented');
            die('501');
        }
        $ret = true;

        self::$response_format = strtolower($response_format);

        $ret = call_user_func(['Controller', $action]);

        if (is_array($ret) && array_key_exists('mode', $ret)) {
            header('HTTP/1.1 200 OK');
            if ($ret['mode'] == 'inline') {
                header('Content-Type: ' . $ret['content-type']);
                header('Content-Disposition: inline; filename="' . $ret['basename'] . '"');
            } elseif ($ret['mode'] == 'download') {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $ret['basename'] . '"');
            }
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . $ret['size']);
            echo $ret['data'];
            die();
        }

        if ($ret === false) {
            self::_route_log($controller, $action, 'Erreur generique');
            header('HTTP/1.0 500 Internal Server Error');
            die('500');
        }

        if (is_string($ret)) {
            switch (strtolower($response_format))
            {
                case 'jpeg':
                case 'jpg':
                    self::_output('image/jpeg', $ret);
                    return true;
                case 'gif':
                    self::_output('image/gif', $ret);
                    return true;
                case 'png':
                    self::_output('image/png', $ret);
                    return true;
                case 'css':
                    self::_output('text/css', $ret);
                    return true;
                case 'js':
                    self::_output('application/javascript', $ret);
                    return true;
                case 'txt':
                    self::_output('text/plain', Tools::htmlToText($ret));
                    return true;
                case 'rss':
                    self::_output('application/rss+xml', $ret);
                    return true;
                case 'xml':
                    self::_output('text/xml', $ret);
                    return true;
                case 'ics':
                    self::_output('text/calendar', $ret);
                    return true;
                case 'html':
                    self::_output('text/html', $ret);
                    return true;
                case 'xhtml':
                    self::_output('application/xhtml+xml', $ret);
                    return true;
                default:
                    return false;
            }
        }

        if (!is_array($ret)) {
            self::_route_log($controller, $action, 'Le retour n\'est pas un tableau');
            header('HTTP/1.0 500 Internal Server Error');
            die('500');
        }

        if (isset($ret['return_code']) && $ret['return_code'] <= 0) {
            self::_route_log(
                $controller,
                $action,
                'Code de retour : [' . $ret['return_code'] . '] Erreur : [' . $ret['error_message'] . ']'
            );
        }

        // a affiner, pour API, ouverture cross-domain
        header("Access-Control-Allow-Origin: *");

        switch (strtolower($response_format))
        {
            case 'json':
                self::_output('application/json', json_encode($ret));
                return true;
            case 'phpser':
                //self::_output('application/php-serialized', serialize($ret));
                self::_output('text/plain', serialize($ret));
                return true;
            case 'txt':
                self::_output('text/plain', print_r($ret, true));
                return true;
        }

        header('HTTP/1.0 500 Internal Server Error');
        die('500');
    }

    /**
     *
     */
    protected static function _init_params()
    {
        self::$action_params = array_merge(self::$action_params, $_GET);
        self::$action_params = array_merge(self::$action_params, $_POST);

        if (ROUTE_MANAGE_FILES === true) {
            foreach ($_FILES as $param_name => $file) {
                if ($file['tmp_name']) {
                    self::$action_params[$param_name] = file_get_contents($file['tmp_name']);
                }
            }
        }
    }

    /**
     * @param array $params
     */
    protected static function _examine_splitted_paths(array $params)
    {
        $action = false;
        $extra_params = [];
        $splitted_path = $params['splitted_path'];
        $route_splitted_path = $params['route_splitted_path'];
        $route = $params['route'];

        if (count($splitted_path) !== count($route_splitted_path)) {
            return false;
        }
        $i = 0;
        foreach ($route_splitted_path as $scanned_component) {
            $component = $splitted_path[$i];
            $i++;
            if (($ret = self::_examine_splitted_path_component(
                [
                    'scanned_component' => $scanned_component,
                    'component' => $component,
                    'route' => $route
                ]
            )) === false
            ) {
                return false;
            }
            if (!empty($ret['found_action'])) {
                $action = $ret['found_action'];
            }
            if (!empty($ret['found_params'])) {
                $extra_params = array_merge(
                    $extra_params,
                    $ret['found_params']
                );
            }
        }
        if (empty($action)) {
            $action = $route['action'];
        }
        return [
            'action' => $action,
            'extra_params' => $extra_params,
        ];
    }

    /**
     * @param array
     */
    protected static function _examine_splitted_path_component($params)
    {
        $found_action = false;
        $found_params = [];
        $route = $params['route'];
        $scanned_component = $params['scanned_component'];
        $component = $params['component'];
        if (empty($scanned_component)) {
            if (empty($component)) {
                return [];
            }
            return false;
        }
        if ($scanned_component[0] !== ':') {
            if ($scanned_component !== $component) {
                return false;
            }
        } else {
            $matches = [];
            preg_match('/^:([a-z0-9_-]+)/i', $scanned_component, $matches);
            if (empty($matches[1])) {
                return false;
            }
            $scanned_component_splitted_action = explode(';', $scanned_component);
            $component_splitted_action = explode(';', $component);
            if (!empty($scanned_component_splitted_action[1])) {
                if (empty($component_splitted_action[1])) {
                    return false;
                }
                $component_action = $component_splitted_action[1];
                if (empty($scanned_component_splitted_action[1])) {
                    return false;
                }
                $scanned_component_action = $scanned_component_splitted_action[1];
                if ($scanned_component_action !== $component_action) {
                    return false;
                }
                $found_action = $route['action'];
            } elseif (!empty($component_splitted_action[1])) {
                return false;
            }
            $found_params[$matches[1]] = $component_splitted_action[0];
        }
        if (!empty($found_params['action'])) {
            $found_action = $found_params['action'];
        }
        return [
            'found_action' => $found_action,
            'found_params' => $found_params,
        ];
    }

    /**
     *
     */
    protected static function _output($content_type, $content)
    {
        if ($content_type === 'application/xhtml+xml') {
            if (!(isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') !== false)) {
                $content_type = 'text/html';
            }
        }

        $http_codes = [
            '200' => 'HTTP/1.1 200 OK',
            '301' => 'HTTP/1.1 301 Moved Permanently',
            '302' => 'HTTP/1.1 302 Moved Temporarily',
            '304' => 'HTTP/1.1 304 Not Modified',
            '400' => 'HTTP/1.1 400 Bad Request',
            '403' => 'HTTP/1.1 403 Forbidden',
            '404' => 'HTTP/1.1 404 Not Found',
            '500' => 'HTTP/1.1 500 Internal Server Error',
        ];

        header($http_codes[self::$http_code]);
        header('Content-Type: ' . $content_type . '; charset=utf-8');
        header('Content-Length: ' . strlen($content));
        echo $content;
        flush();
    }

    /**
     *
     */
    protected static function _route_log($controller, $action, $log)
    {
        $log_message = '[' . addcslashes($controller, "\r\n|[]") . '] ' .
                       '[' . addcslashes($action, "\r\n|[]") . '] ' .
                       '[' . addcslashes($log, "\r\n|[]") . '] ';
        if (($fp = fopen(ADHOC_LOG_PATH . '/route-errors.log', 'a')) !== false) {
            fputs($fp, $log_message . "\n");
            fclose($fp);
        }
    }
}
