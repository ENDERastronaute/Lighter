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
            $request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
            $script_name = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
            $parts = array_diff($request_uri, $script_name);

            if (empty($parts)) {
                Router::$path = '/';
                Router::redirect(Router::$path);
                return;
            }

            Router::$path = implode('/', $parts);

            if (($position = strpos(Router::$path,'?')) !== false) {
                Router::$path = substr(Router::$path, 0, $position);
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
                if (array_key_exists("/$path", Router::$getPaths))
                {
                    $redirect = Router::$getPaths["/$path"];

                    self::go($redirect);
                    return;
                }

                self::error_404();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                if (array_key_exists("/$path", Router::$postPaths))
                {
                    $redirect = Router::$postPaths["/$path"];

                    self::go($redirect);
                    return;
                }

                self::error_404();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'PUT')
            {
                if (array_key_exists("/$path", Router::$putPaths))
                {
                    $redirect = Router::$putPaths["/$path"];

                    self::go($redirect);
                    return;
                }

                self::error_404();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
            {
                if (array_key_exists("/$path", Router::$deletePaths))
                {
                    $redirect = Router::$deletePaths["/$path"];

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
    }
?>
