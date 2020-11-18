<?php

namespace yedincisenol\Parasut\Models;

use GuzzleHttp\Exception\GuzzleException;
use yedincisenol\Parasut\Exceptions\NotFoundException;
use yedincisenol\Parasut\Exceptions\ParasutException;
use yedincisenol\Parasut\Exceptions\UnproccessableEntityException;
use yedincisenol\Parasut\Response;

class Me extends Model
{
    protected $path = 'me';

    /**
     * List all models
     * @param array $parameters
     * @return Response
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function get($parameters = [])
    {
        $models = $this->parasut->request('GET', $this->path, $parameters, [], false);

        return new Response($models->getBody());
    }
}