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

    public function algorithms()
    {
        if (is_null($this->algorithms) && is_null($this->client)) {
            $callback_url = \Config::get('compredict.ai_core.callback');
            $this->client = new CPAlgoClient($this->APIKey, $callback_url);
            // Get the URL if found in env. Otherwise, get default url from client
            $this->client->setURL(env('COMPREDICT_SERVER_URL', $this->client->getURL()));
            $this->algorithms = $this->client->getAlgorithms();
        }
        return $this->algorithms;
    }

}
