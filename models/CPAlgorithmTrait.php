<?php

namespace Compredict\Algorithm\Models;

use Compredict\API\Algorithms\Client as CPAlgoClient;
use \App

trait CPAlgorithmTrait
{

    protected $algorithms;
    protected $client;

    public function getAlgorithmsAttribute(){
        return $this->algorithms;
    }

    public function algorithms()
    {
        if(is_null($algorithms) && is_null($client)){
            $callback_url = Config::get('compredict.ai_core.callback_url');
            $this->client = CPAlgoClient($this->token, $callback_url);
            $this->algorithms = $this->client->getAlgorithms();
        }
        return $this->algorithms;
    }

}
