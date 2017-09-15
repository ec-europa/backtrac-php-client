<?php

namespace EC\Utils\Backtrac {

    class Website
    {
        /**
         * @var string $name Title of the project
         */
        public $title;
        /**
         * @var string $url Basic authentication password
         */
        public $pass;
        /**
         * @var string $url URL of the environment
         */
        public $url;
        /**
         * @var string $url Basic authentication username
         */
        public $username;


        /**
         * Website constructor
         *
         * @param $name
         * @param $pass
         * @param $url
         * @param $username
         */
        public function __construct($name, $url, $username = '', $pass = '')
        {
            $this->name = $name;
            $this->pass = $pass;
            $this->url = $url;
            $this->username = $username;
        }
    }
}
