<?php
    namespace Model;

    /**
     * Model for responses
     */
    class Response
    {
        private $status;

        /**
         * @param int $status status code of response (default is 200)
         */
        public function __construct(int $status = 200)
        {
            $this->status = $status;
        }

        /**
         * Sets the status code of the response
         * @param int $status status code of response
         */
        public function status(int $status)
        {
            $this->status = $status;

            return $this;
        }

        /**
         * Sends stringified JSON back.  
         * Avoid sending data after it (like includes or echos).
         * 
         * @param mixed $response data to be sent
         */
        public function end($response)
        {
            http_response_code($this->status);

            echo json_encode($response);
        }
    }
?>