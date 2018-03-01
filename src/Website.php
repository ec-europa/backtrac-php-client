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
         * Website constructor
         * @param $env
         * @param $name
         * @param $url
         */
        public function __construct($name, $url, $env = 'development')
        {
            $this->env = $env;
            $this->name = $name;
            $this->url = $url;
        }
    }
}
