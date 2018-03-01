<?php

namespace BacktracTasks {

    class BacktracCompareTask extends \Task
    {
        private $auth_token;

        public function setAuth_token($str)
        {
            $this->auth_token = $str;
        }

        private $check_results = true;

        public function setCheck_results($bool)
        {
            $this->check_results = $bool;
        }

        private $compare_mode;

        public function setCompare_mode($str)
        {
            $this->compare_mode = $str;
        }

        private $environment;

        public function setEnvironment($str)
        {
            $this->environment = $str;
        }

        private $project_id;

        public function setProject_id($str)
        {
            $this->project_id = $str;
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
             * Compare callbacks :
             */
            if ($this->compare_mode != 'compare_itself') {
                $diffId = $client->compareEnvironments($this->compare_mode)->result->nid;
            }
            elseif (empty($this->environment)) {
                throw new \ConfigurationException("Environment parameter should be one of development, production or staging");
            }
            else {
                $diffId = $client->compareItself($this->environment)->result->nid;
            }
            $this->log('Backtrack diff ID :' . $diffId);

            /**
             * Wait for results if needed :
             */
            if ($this->check_results) {
                $client->waitForResults($diffId);
            }
        }
    }
}
