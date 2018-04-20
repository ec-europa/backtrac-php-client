<?php

namespace BacktracTasks {

    class BacktracSetUrlTask extends \Task
    {
        private $auth_token;

        public function setAuth_token($str)
        {
            $this->auth_token = $str;
        }

        private $projectId;

        public function setProject_id($str)
        {
            $this->project_id = $str;
        }
        
        private $secure;

        public function setSecure($bool)
        {
            $this->secure= $bool;
        }

        private $environment;

        public function setEnvironment($str)
        {
            $this->environment = $str;
        }

        private $url;

        public function setUrl($str)
        {
            $this->url = $str;
        }

        private $uris;

        public function setUris($arr)
        {
            $this->uris = $arr;
        }

        public function init()
        {
        }

        public function main()
        {
            $client = new \EC\Utils\Backtrac\Client(
                $this->project_id,
                $this->auth_token,
                $this->secure
            );

            $website = new \EC\Utils\Backtrac\Website('test-site', $this->url, $this->environment, $this->uris);
            $client->setWebsite($website);

            $this->log('Backtrac environment ' . $this->environment . ' url set to ' . $this->url . PHP_EOL);
        }
    }
}
