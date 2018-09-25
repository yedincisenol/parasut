<?php

namespace yedincisenol\Parasut\Models;

use yedincisenol\Parasut\Client;
use yedincisenol\Parasut\RequestModel;
use yedincisenol\Parasut\Response;

abstract class Model
{
    protected $parasut = null;

    /**
     * Model constructor.
     * @param Client $parasut
     */
    public function __construct(Client $parasut)
    {
        $this->parasut = $parasut;
    }

    /**
     * List all models
     * @param array $parameters
     * @return Response
     */
    public function all($parameters = [])
    {
        $models = $this->parasut->request('GET', $this->path, $parameters);

        return new Response($models->getBody());
    }

    /**
     * Create new model
     * @param Request|RequestModel $request
     * @param array $query
     * @return Response
     */
    public function create(RequestModel $request, $query = [])
    {
        $model = $this->parasut->request('POST', $this->path, $query, $request->toArray());

        return new Response($model->getBody());
    }

    /**
     * Update a model
     * @param Request|RequestModel $request
     * @param array $query
     * @return Response
     */
    public function update(RequestModel $request, $query = [])
    {
        $model = $this->parasut->request('PUT', $this->path . '/' . $request->getId(), $query, $request->toArray());

        return new Response($model->getBody());
    }

    /**
     * Delete a model
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $response = $this->parasut->request('DELETE', $this->path . '/' . $id);

        return $response->getStatusCode() == 204;
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
