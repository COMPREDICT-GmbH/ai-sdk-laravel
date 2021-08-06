<?php

namespace Compredict\Algorithm\Models;

use Compredict\API\Algorithms\Client as CPAlgoClient;

trait CPAlgorithmTrait
{

    protected $algorithms;
    protected $client;

    public function getAlgorithmsAttribute()
    {
        return $this->algorithms->algorithms;
    }

    public function getAlgorithmsLastError()
    {
        $lastError = $this->client->getLastError();
        if ($lastError != null && property_exists($lastError, 'error')) {
            $lastError->errors = $lastError->error;
            unset($lastError->error);
        }
        return $lastError;
    }

    public function algorithms()
    {
        if (is_null($this->algorithms) && is_null($this->client)) {
            $callback_url = \Config::get('compredict.ai_core.callback');
            $this->client = new CPAlgoClient($this->APIKey, $callback_url);
            // Get the URL if found in env. Otherwise, get default url from client
	        $httpURL = \Config::get('compredict.ai_core.server_url').\Config::get('compredict.ai_core.api_version');
	        $this->client->setURL(!empty($httpURL) ? $httpURL : $this->client->getURL());
            $this->algorithms = $this->client->getAlgorithms();
        }
        return $this->algorithms;
    }

}
