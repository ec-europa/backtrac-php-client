<?php

namespace EC\Utils\Backtrac {

    class Website
    {
        /**
         * @var string $env Website environment
         */
        public $env;

        /**
         * @var string $name Website name
         */
        public $name;

        /**
         * @var string $url Website url
         */
        public $url;

        /**
         * @var array $uris Website uris
         */
        public $uris;

        /**
         * Website constructor
         * @param $env
         * @param $name
         * @param $url
         */
        public function __construct($name, $url, $env = 'development', $uris = [])
        {
            $this->env = $env;
            $this->name = $name;
            $this->url = $url;
            $this->uris = $uris;
        }
    }
}
