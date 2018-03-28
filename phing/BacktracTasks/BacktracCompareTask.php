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

        private $results_file;

        public function setResults_file($str)
        {
            $this->results_file = $str;
        }

        public function init()
        {
            // Get default properties from project.
            $properties_mapping = array(
                'setAuth_token' => 'backtrac.auth_token',
                'setCompare_mode' => 'backtrac.compare_mode',
                'setEnvironment' => 'backtrac.environment',
                'setProject_id' => 'backtrac.project_id',
                'setResults_file' => 'backtrac.results_file',
            );
            foreach ($properties_mapping as $class_method => $backtrac_property) {
                if ($property = $this->getProject()->getProperty($backtrac_property)) {
                    call_user_func(array($this, $class_method), $property);
                }
            }
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
            if ($this->compare_mode === 'check_results') {
                $jobId = $this->project_id;
                $this->log("Awaiting result for job number: " . $jobId);
            }
            elseif (!in_array($this->compare_mode, array('compare_itself', 'snapshot'))) {
                $result = $client->compareEnvironments($this->compare_mode)->result;
            }
            elseif (empty($this->environment)) {
                throw new \ConfigurationException("Environment parameter should be one of development, production or staging to take snapshot");
            }
            else {
                $result = $client->takeSnapshot($this->compare_mode, $this->environment)->result;
            }

            /**
             * Log action to user.
             */
            if (!empty($result)) {
                $this->log($result->message);
                $this->log($result->url);
                $jobId = $result->nid;
                if (!empty($this->results_file)) {
                    file_put_contents($this->results_file, $jobId . ',', FILE_APPEND | LOCK_EX);
                }
            }

            /**
             * Wait for results if needed :
             */
            if ($this->check_results) {
                if ($client->waitForResults($jobId)) {
                    $endResult = $client->getResult($jobId)->result;
                    if (isset($endResult->message)) {
                        $this->log($endResult->message);
                    }
                    if (isset($endResult->result)) {
                        $this->log($endResult->result);
                    }
                }
            }
        }
    }
}
