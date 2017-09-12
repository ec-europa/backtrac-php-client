<?php
namespace EC\Utils\Backtrac {
    class BacktracSetUrl extends \Task {
        private $authToken;

        public function setAuthToken($str) {
            $this->authToken = $str;
        }

        private $projectId;

        public function setProjectId($str) {
            $this->projectId = $str;
        }

        public function init() {

        }

        public function main() {
            $client = new \EC\Utils\Backtrac\Client(
                $this->projectId,
                $this->authToken
            );
            /**
             * Compare prod a dev :
             */
            $diffId = $client->compareEnvironments($this->compareMode)->result->nid;
            print('Backtrack diff ID :'.$diffId);
        }
    }
}