<?php

namespace Compredict\Algorithm\Models;

use Compredict\API\Algorithms\Client as CPAlgoClient;

trait CPAlgorithmTrait
{

    protected $algorithms;
    protected $client;

    public function getAlgorithmsAttribute()
    {
        return $this->algorithms;
    }

    public function algorithms()
    {
        if (is_null($this->algorithms) && is_null($this->client)) {
            $callback_url = \Config::get('compredict.ai_core.callback');
            $this->client = new CPAlgoClient($this->APIKey, $callback_url);
            $this->algorithms = $this->client->getAlgorithms();
        }
        return $this->algorithms;
    }

}
