<?php

namespace EC\Utils\Backtrac {

    class Website
    {
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
         * @param $name
         * @param $url
         */
        public function __construct($name, $url)
        {
            $this->name = $name;
            $this->url = $url;
        }
    }
}
