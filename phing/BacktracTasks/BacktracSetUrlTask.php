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

        private $username;

        public function setUsername($str)
        {
            $this->username = $str;
        }

        private $pass;

        public function setPassword($str)
        {
            $this->pass = $str;
        }

        public function init()
        {
        }

        public function main()
        {
            $client = new \EC\Utils\Backtrac\Client(
                $this->project_id,
                $this->auth_token
            );

            /**
             * Create a website object
             */
            $website = new \EC\Utils\Backtrac\Website('test-site', $this->url);

            // Dirty mode :
            if (in_array($this->environment, ['prod', 'stage', 'dev'])) {
                $client->setWebsite($website, $this->environment);
                $this->log('Backtrac environment ' . $this->environment . ' url set to ' . $this->url);
            }
            else
            {
                throw new \ConfigurationException("Backtrac environment should be one of dev/prod/staging");
            }


        }
    }
}
