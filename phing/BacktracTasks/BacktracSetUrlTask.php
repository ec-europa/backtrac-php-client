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
            switch ($this->environment) {
                case 'dev':
                    $client->setDevWebsite($website);
                    break;
                case 'prod':
                    $client->setProductionWebsite($website);
                    break;
                case 'staging':
                    $client->setStageWebsite($website);
                    break;
                default:
                    throw new \ConfigurationException("Backtrac environment should be one of dev/prod/staging");
                    break;
            }

            $this->log('Backtrac environment ' . $this->environment . ' url set to ' . $this->url . PHP_EOL);
        }
    }
}
