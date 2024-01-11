<?php
    namespace Server\Router;

    use Model\Request;
    use Util\Headers;
    use Util\Plateform;
    use Routes\Middleware;

    session_start();

    class Router
    {
        private static $getPaths = [];
        private static $postPaths = [];
        private static $putPaths = [];
        private static $deletePaths = [];
        private static $path;

        /**
         * @param string $key URL path
         * @param mixed $value File path or array[class, method name]
         */
        public static function GET(string $key, mixed $value, bool $private = false)
        {
            Router::$getPaths[$key] = ['file' => $value, 'private' => $private];
        }

        /**
         * @param string $key URL path
         * @param mixed $value File path or array[class, method name]
         */
        public static function POST(string $key, mixed $value, bool $private = false)
        {
            Router::$postPaths[$key] = ['file' => $value, 'private' => $private];
        }

        public static function PUT(string $key, mixed $value, bool $private = false)
        {
            Router::$putPaths[$key] = ['file' => $value, 'private' => $private];
        }

        public static function DELETE(string $key, mixed $value, bool $private = false)
        {
            Router::$deletePaths[$key] = ['file' => $value, 'private' => $private];
        }

        public static function on() {
            $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0]; // Obtenez l'URI sans la chaîne de requête
            $request_uri = trim($request_uri, '/'); // Supprimez les slashes de début et de fin
            
            if (empty($request_uri)) {
                Router::$path = '/';
            } else {
                Router::$path = '/' . $request_uri;
            }
            
            Router::redirect(Router::$path);
        }

        public static function redirect(string $path) {
            Middleware::middleware(new Request(
                (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
                '/' . $path,
                $_SERVER["REQUEST_METHOD"],
                Headers::getAll(),
                json_decode(file_get_contents('php://input'), true)
            ));

            if ($_SERVER['REQUEST_METHOD'] === 'GET')
            {
                if (array_key_exists("$path", Router::$getPaths))
                {

                    $redirect = Router::$getPaths["$path"];

                    self::go($redirect);
                    return;
                }

                self::error_404();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                if (array_key_exists("$path", Router::$postPaths))
                {
                    $redirect = Router::$postPaths["$path"];

                    self::go($redirect);
                    return;
                }

                self::error_404();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'PUT')
            {
                if (array_key_exists("$path", Router::$putPaths))
                {
                    $redirect = Router::$putPaths["$path"];

                    self::go($redirect);
                    return;
                }

                self::error_404();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
            {
                if (array_key_exists("$path", Router::$deletePaths))
                {
                    $redirect = Router::$deletePaths["$path"];

                    self::go($redirect);
                    return;
                }

                self::error_404();
            }

        }

        private static function go(mixed $redirect) {
            if ($redirect['private'] && $_SESSION['id'] || !$redirect['private']) {
                $where = $redirect['file'];

                if (is_callable($where))
                {
                    call_user_func($where);
                    return;
                }
    
                throw new \Exception('Use of uncallable object : ' . print_r($where, true));
            }

            header('Location: /');
            return;
        }

        private static function error_404() {
            include Plateform::transform_path(__DIR__ . "/../../app/Views/404.php");
            return;
        }

        public static function serve_assets() {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri = urldecode($uri);

            $parts = explode('.', $uri);

            if (isset($parts[1])) {
                $extension = $parts[1];

                switch ($extension)
                {
                    case 'css':
                        self::serve_style($uri);
                        break;
                    
                    case 'module':
                        self::serve_module($uri, $parts);
                        break;
    
                    case 'js':
                        self::serve_script($uri);
                        break;
                }
            }

            include __DIR__ . '/../../public/index.php';
        }

        private static function serve_style($path) {
            header('Content-Type: text/css; charset=utf-8');
            include __DIR__ . "/../../app/Styles/$path";
            die();
        }

        private static function serve_script($path) {
            header('Content-Type: application/js; charset=utf-8');
            include __DIR__ . "/../../app/Javascripts/$path";
            die();
        }

        private static function serve_module($path, $parts) {
            if (isset($parts[2])) {
                switch ($parts[2]) {
                    case 'css':
                        header('Content-Type: text/css; charset=utf-8');
                        break;

                    case 'js':
                        header('Content-Type: application/js; charset=utf-8');
                        break;
                }
                include __DIR__ . "/../../app/Views/$path";
                die();
            }
        }
    }

    Router::serve_assets();
?>
