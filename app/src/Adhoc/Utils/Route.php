<?php

declare(strict_types=1);

namespace Adhoc\Utils;

if (!defined('DEFAULT_CONTROLLERS_PATH')) {
    define('DEFAULT_CONTROLLERS_PATH', __DIR__ . '/../../../../src/Adhoc/Controller/');
}
define('DEFAULT_CONTROLLER_SUFFIX', '.php');
define('DEFAULT_CONTROLLERS_FORMAT', 'html');

/**
 * Gestion des routes
 *
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Route
{
    /**
     * @var array<string,mixed>
     */
    protected static array $routes = [];

    /**
     * @var array<string,mixed>
     */
    protected static array $action_params = [];

    /**
     * @var string
     */
    protected static string $controllers_path = DEFAULT_CONTROLLERS_PATH;

    /**
     * @var string
     */
    protected static string $controller_suffix = DEFAULT_CONTROLLER_SUFFIX;

    /**
     * @var int
     */
    protected static int $http_code = 200;

    /**
     * @var string
     */
    public static string $response_format = DEFAULT_CONTROLLERS_FORMAT;

    /**
     * @param int $http_code n° de code http
     *
     * @return void
     */
    public static function setHttpCode(int $http_code): void
    {
        self::$http_code = $http_code;
    }

    /**
     * @param array<string,string> $params params
     *
     * @return void
     */
    public static function mapConnect(array $params): void
    {
        $extra_params = $params;
        foreach (['path', 'controller', 'action', 'method'] as $key) {
            unset($extra_params[$key]);
        }
        if (empty($params['method'])) {
            $params['method'] = 'GET';
        }
        array_push(
            self::$routes,
            [
                'controller' => $params['controller'],
                'path' => $params['path'],
                'splitted_path' => explode('/', $params['path']),
                'method' => strtoupper($params['method']),
                'action' => $params['action'],
                'extra_params' => $extra_params,
            ]
        );
    }

    /**
     * @param string $key clé
     *
     * @return mixed|null
     */
    public static function params(string $key)
    {
        if (isset(self::$action_params[$key])) {
            return self::$action_params[$key];
        }
        return null;
    }

    /**
     * @param array<string,string> $params paramètres
     *
     * @return array<string,mixed>|false
     */
    public static function findRoute(array $params): array|false
    {
        $response_format = DEFAULT_CONTROLLERS_FORMAT;
        $method = $params['method'];
        $path = $params['path'];
        $matches = [];
        $path = str_replace('?', '', $path);
        if (!empty($_SERVER['QUERY_STRING'])) {
            $path = str_replace($_SERVER['QUERY_STRING'], '', $path);
        }

        // si le path se termine par "/", retirer le dernier "/", reformer le path complet avec query string
        // retourner un http 302 direct
        if ((preg_match('/^(.+)\/$/', $path, $matches)) > 0) {
            $url = HOME_URL . $matches[1];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $url .= '?' . $_SERVER['QUERY_STRING'];
            }
            header('HTTP/1.0 302 Found');
            header('Location: ' . $url);
            die();
        }

        // recherche extension de fichier dans url
        if ((preg_match('/^(.+)[.]([a-z0-9-]+)$/i', $path, $matches)) > 0) {
            $path = $matches[1];
            $response_format = $matches[2];
        }
        unset($matches);
        $splitted_path = explode('/', $path);
        $sizeof_splitted_path = count($splitted_path);

        $ret = false;
        $route = '';
        foreach (self::$routes as $route) {
            if (strcasecmp($route['method'], $method) !== 0) {
                continue;
            }
            $ret = self::examineSplittedPaths(
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
     *
     * @return bool
     */
    public static function load(string $file): bool
    {
        if (file_exists($file) && is_readable($file)) {
            $routes = file($file);
            foreach ($routes as $route) {
                $r = explode('|', trim($route));
                self::mapConnect(
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
     * @return bool
     */
    public static function run(): bool
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = '';
        if (isset($_SERVER['PATH_INFO'])) {
            $path = $_SERVER['PATH_INFO'];
        }
        $ret = self::findRoute(
            [
                'method' => $method,
                'path' => $path,
            ]
        );
        if ($ret === false) {
            self::routeLog('-', '-', 'Route non trouvée : ' . $method . ' - ' . $path);
            header('HTTP/1.0 404 Not Found');
            die("HTTP 404 Not Found<script>window.location='" . HOME_URL . "/map?from=404'</script>");
        }
        self::initParams();
        self::$action_params = array_merge(
            self::$action_params,
            $ret['extra_params']
        );
        $route = $ret['route'];
        $action = $ret['action'];
        $response_format = $ret['response_format'];
        $controller = $route['controller']; // ??
        $controller_file = self::$controllers_path . preg_replace('/[^a-z0-9-]/i', '_', $controller) . self::$controller_suffix;
        if (file_exists($controller_file) === false) {
            self::routeLog($controller, $action, 'Contrôleur inaccessible');
            header('HTTP/1.0 503 Service Unavailable');
            die('HTTP 503 Service Unavailable');
        }
        include_once $controller_file;
        if (is_callable(['Adhoc\\Controller\\Controller', $action]) === false) {
            self::routeLog($controller, $action, 'Action non implémentée dans le contrôleur');
            header('HTTP/1.0 501 Not implemented');
            die('HTTP 501 Not implemented');
        }
        $ret = true;

        self::$response_format = strtolower($response_format);

        $ret = call_user_func(['\\Adhoc\\Controller\\Controller', $action]);

        if (is_array($ret) && array_key_exists('mode', $ret)) {
            header('HTTP/1.1 200 OK');
            if ($ret['mode'] === 'inline') {
                header('Content-Type: ' . $ret['content-type']);
                header('Content-Disposition: inline; filename="' . $ret['basename'] . '"');
            } elseif ($ret['mode'] === 'download') {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $ret['basename'] . '"');
            }
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . $ret['size']);
            echo $ret['data'];
            die();
        }

        if ($ret === false) {
            self::routeLog($controller, $action, 'Erreur generique');
            header('HTTP/1.0 500 Internal Server Error');
            die('500 Internal Server Error');
        }

        if (is_string($ret)) {
            switch (strtolower($response_format)) {
                case 'jpeg':
                case 'jpg':
                    self::output('image/jpeg', $ret);
                    return true;
                case 'gif':
                    self::output('image/gif', $ret);
                    return true;
                case 'png':
                    self::output('image/png', $ret);
                    return true;
                case 'css':
                    self::output('text/css', $ret);
                    return true;
                case 'js':
                    self::output('application/javascript', $ret);
                    return true;
                case 'txt':
                    self::output('text/plain', Tools::htmlToText($ret));
                    return true;
                case 'rss':
                    self::output('application/rss+xml', $ret);
                    return true;
                case 'xml':
                    self::output('text/xml', $ret);
                    return true;
                case 'ics':
                    self::output('text/calendar', $ret);
                    return true;
                case 'html':
                    self::output('text/html', $ret);
                    return true;
                default:
                    return false;
            }
        }

        if (!is_array($ret)) {
            self::routeLog($controller, $action, 'Le retour n\'est pas un tableau');
            header('HTTP/1.0 500 Internal Server Error');
            die('500 Internal Server Error');
        }

        if (isset($ret['return_code']) && $ret['return_code'] <= 0) {
            self::routeLog(
                $controller,
                $action,
                'Code de retour : [' . $ret['return_code'] . '] Erreur : [' . $ret['error_message'] . ']'
            );
        }

        // a affiner, pour API, ouverture cross-domain
        header("Access-Control-Allow-Origin: *");

        switch (strtolower($response_format)) {
            case 'json':
                self::output('application/json', json_encode($ret));
                return true;
            case 'phpser':
                //self::output('application/php-serialized', serialize($ret));
                self::output('text/plain', serialize($ret));
                return true;
            case 'txt':
                self::output('text/plain', print_r($ret, true));
                return true;
        }

        header('HTTP/1.0 500 Internal Server Error');
        die('500 Internal Server Error');
    }

    /**
     * @return void
     */
    protected static function initParams(): void
    {
        self::$action_params = array_merge(self::$action_params, $_GET);
        self::$action_params = array_merge(self::$action_params, $_POST);
    }

    /**
     * @param array<string,mixed> $params paramètres
     *
     * @return array<string,mixed>|false
     */
    protected static function examineSplittedPaths(array $params): array|false
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
            if (
                ($ret = self::examineSplittedPathComponent(
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
     * @param array<string,mixed> $params paramètres
     *
     * @return array<string,mixed>|false
     */
    protected static function examineSplittedPathComponent(array $params)
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
     * @param string $content_type type de contenu
     * @param string $content      contenu
     *
     * @return void
     */
    protected static function output(string $content_type, string $content): void
    {
        if ($content_type === 'application/xhtml+xml') {
            if (!(isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') !== false)) {
                $content_type = 'text/html';
            }
        }

        $http_codes = [
            200 => 'HTTP/1.1 200 OK',
            301 => 'HTTP/1.1 301 Moved Permanently',
            302 => 'HTTP/1.1 302 Moved Temporarily',
            304 => 'HTTP/1.1 304 Not Modified',
            400 => 'HTTP/1.1 400 Bad Request',
            403 => 'HTTP/1.1 403 Forbidden',
            404 => 'HTTP/1.1 404 Not Found',
            500 => 'HTTP/1.1 500 Internal Server Error',
        ];

        header($http_codes[self::$http_code]);
        header('Content-Type: ' . $content_type . '; charset=utf-8');
        header('Content-Length: ' . strlen($content));
        echo $content;
        flush();
    }

    /**
     * Ajoute une log
     *
     * @param string $controller controlleur
     * @param string $action     action
     * @param string $log        log
     *
     * @return void
     */
    protected static function routeLog(string $controller, string $action, string $log): void
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
