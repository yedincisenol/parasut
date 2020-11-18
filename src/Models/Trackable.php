<?php

namespace yedincisenol\Parasut\Models;

use GuzzleHttp\Exception\GuzzleException;
use yedincisenol\Parasut\Client;
use yedincisenol\Parasut\Exceptions\NotFoundException;
use yedincisenol\Parasut\Exceptions\ParasutException;
use yedincisenol\Parasut\Exceptions\UnproccessableEntityException;
use yedincisenol\Parasut\Response;

class Trackable
{

    protected $path = 'trackable_jobs';

    protected $parasut;

    /**
     * Model constructor.
     * @param Client $parasut
     */
    public function __construct(Client $parasut)
    {
        $this->parasut = $parasut;
    }

    /**
     * Get a model object
     * @param $id
     * @param array $query
     * @return Response
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function show($id, $query = [])
    {
        $response = $this->parasut->request('GET', $this->path . '/' . $id, $query);

        return new Response($response->getBody());
    }
}