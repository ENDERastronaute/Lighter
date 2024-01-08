<?php
    namespace Model;

    /**
     * Model for requests
     */
    class Request
    {
        public $url = "";
        public $path = "";
        public $method = "";
        public $headers = [];
        public $body = [];

        /**
         * @param string $url full URL
         * @param string $path path
         * @param string $method request method
         * @param array $headers request headers
         * @param array $body request body
         */
        public function __construct(string $url, string $path, string $method, array $headers = [], array|null $body = [])
        {
            $this->url = $url;
            $this->path = $path;
            $this->method = $method;
            $this->headers = $headers;
            $this->body = $body;
        }
    }

?>