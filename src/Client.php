<?php

namespace EC\Utils\Backtrac {

    class Client
    {
        const BACKTRAC_API_ENDPOINT = 'https://backtrac.io/api';
        const COMPARE_PROD_STAGE = 'compare_prod_stage';
        const COMPARE_PROD_DEV = 'compare_prod_dev';
        const COMPARE_STAGE_DEV = 'compare_stage_dev';

        /**
         * @var string Backtrac project id
         */
        private $projectId;
        /**
         * @var \RestClient $httpClient
         */
        public $httpClient;
        /**
         * @var string $token Backtrac.io api key
         */
        private $apiKey;

        /**
         * Backtrac ls teClient constructor.
         * @param $projectId string Backtrac project id
         * @param $apiKey string Backtrac api key
         */
        public function __construct($projectId, $apiKey)
        {
            $this->apiKey = $apiKey;
            $this->projectId = $projectId;
            $this->httpClient = new \RestClient();
            $this->httpClient->options['user_agent'] = 'EC-BACKTRAC-PHP-CLIENT/0.1';
            $this->httpClient->options['curl_options'] = [];
            $this->httpClient->options['headers'] = [
                'Accept' => 'application/json',
                'x-api-key' => $this->apiKey
            ];
            $this->httpClient->options['base_url'] = self::BACKTRAC_API_ENDPOINT;
        }

        /**
         * Request a compare between 2 environment
         *
         * @param $method string One of the self::COMPARE_* constant
         * @return mixed
         */
        public function compareEnvironments($method)
        {
            $url = '/project/' . $this->projectId . '/' . $method;
            return $this->checkResponse($this->httpClient->post(
                $url
            ));
        }

        /**
         * Request a compare between 2 custom URLs
         *
         * @param $diffName
         * @param Website $site1
         * @param Website $site2
         */
        public function customCompare($diffName, Website $site1, Website $site2)
        {
            $url = '/project/' . $this->projectId . '/custom_compare';
            return $this->checkResponse($this->httpClient->post(
                $url,
                json_encode([
                    'url1' => $site1->url,
                    'url2' => $site2->url,
                    'sn1_name' => $site1->name,
                    'sn2_name' => $site2->name,
                    'diff_name' => $diffName
                ])
            ));
        }

        /**
         * Checks an API response and return the decoded object, or throw an exception if failed.
         * @param \RestClient $client
         * @return mixed
         * @throws \Exception
         */
        public function checkResponse(\RestClient $client)
        {
            if (empty($client->response)) {
                throw new \Exception('Empty response from API');
            }
            $response = json_decode($client->response);
            if (empty($response) || $response->status !== "success") {
                throw new \Exception('API call failed : ' . $client->response);
            }
            return $response;
        }

        /**
         * @param Website $website
         * @return mixed
         */
        public function setProductionWebsite(Website $website)
        {
            $url = '/project/' . $this->projectId;
            return $this->checkResponse($this->httpClient->put(
                $url,
                json_encode([
                    'prod' => [
                        'url' => $website->url
                    ]
                ])
            ));
        }

        /**
         * @param Website $website
         * @return mixed
         */
        public function setStageWebsite(Website $website)
        {
            $url = '/project/' . $this->projectId;
            return $this->checkResponse($this->httpClient->put(
                $url,
                json_encode([
                    'stage' => [
                        'url' => $website->url
                    ]
                ])
            ));
        }

        /**
         * @param Website $website
         * @return mixed
         */
        public function setDevWebsite(Website $website)
        {
            $url = '/project/' . $this->projectId;
            return $this->checkResponse($this->httpClient->put(
                $url,
                json_encode([
                    'dev' => [
                        'url' => $website->url
                    ]
                ])
            ));
        }

        /**
         * Gets a job / diff result
         *
         * Results is (decoded ) :
         *
         * {"status":"success","result":{"message":"Diff is completed","result":"Amount of differences: 100 %"}}
         *
         * @param $id
         * @return mixed
         */
        public function getResult($id)
        {
            $url = '/result/' . $id;
            return $this->checkResponse($this->httpClient->put(
                $url
            ));
        }

        /**
         * Wait for the end of the diff to return the result :
         *
         * Highly experimental, relying on "Diff is completed" text
         * is unreliable
         *
         * @param $id
         * @param int $timeout
         * @return mixed
         */
        public function waitForResults($id, $timeout = 10)
        {
            while ($this->getResult($id)->result->message !== "Diff is completed") {
                sleep($timeout);
            }
            return $this->getResult($id);
        }
    }
}
