<?php

namespace yedincisenol\Parasut\Models;

use yedincisenol\Parasut\Client;
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
     * @param $query
     * @return Response
     */
    public function show($id, $query = [])
    {
        $response = $this->parasut->request('GET', $this->path. '/' . $id, $query);

        return new Response($response->getBody());
    }
}