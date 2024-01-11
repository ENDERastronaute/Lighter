<?php
    namespace Routes;
    use Model\Request;
    use Model\Response;
    use Server\Auth\Auth;

    class Middleware
    {
        public static function middleware(Request $req) {
            if (($req->path === '/private') && !Auth::isLogged()) {
                header('Location: /login');
            }

            if (($req->path === '/response')) {
                $res = new Response();

                $res->status(401)->end(['' => '']);

                die();
            }
        }
    }
?>