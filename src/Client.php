<?php
namespace EC\Utils\Backtrac {
    class Client
    {
        const BACKTRAC_API_ENDPOINT = 'https://backtrac.io/api';

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
            $this->httpClient = new \RestClient();
            $this->httpClient->options['user_agent'] = 'EC-BACKTRAC-PHP-CLIENT/0.1';
            $this->httpClient->options['curl_options'] = [];
            $this->httpClient->options['headers'] = [
                'Accept' => 'application/json',
                'x-api-key' => $this->apiKey
            ];
            $this->httpClient->options['base_url'] =  self::BACKTRAC_API_ENDPOINT;

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
            $url = '/project/'.$this->projectId.'/custom_compare';
            return $this->checkResponse($this->httpClient->post(
                $url,
                [
                    'url1' => $site1->url,
                    'url2' => $site2->url,
                    'sn1_name' => $site1->name,
                    'sn2_name' => $site2->name,
                    'diff_name' => $diffName
                ]
            ));
        }

        /**
         * Checks an API response and return the decoded object, or throw an exception if failed.
         * @param \RestClient $client
         * @return mixed
         * @throws \Exception
         */
        public function checkResponse(\RestClient $client) {
            if (empty($client->response)) {
                throw new \Exception('Empty response from API');
            }
            $response = json_decode($client->response);
            if(empty($response) || $response->status !== "success") {
                throw new \Exception('API call failed : '.$client->response);
            }
            return $response;
        }
    }
}