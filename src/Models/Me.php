<?php

namespace yedincisenol\Parasut\Models;

use yedincisenol\Parasut\Response;

class Me extends Model
{
    protected $path = 'me';

    /**
     * List all models
     * @param array $parameters
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \yedincisenol\Parasut\Exceptions\NotFoundException
     * @throws \yedincisenol\Parasut\Exceptions\ParasutException
     * @throws \yedincisenol\Parasut\Exceptions\UnproccessableEntityException
     */
    public function get($parameters = [])
    {
        $models = $this->parasut->request('GET', $this->path, $parameters, [], false);

        return new Response($models->getBody());
    }
}