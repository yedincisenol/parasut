<?php

namespace yedincisenol\Parasut\Models;

use GuzzleHttp\Exception\GuzzleException;
use yedincisenol\Parasut\Client;
use yedincisenol\Parasut\Exceptions\NotFoundException;
use yedincisenol\Parasut\Exceptions\ParasutException;
use yedincisenol\Parasut\Exceptions\UnproccessableEntityException;
use yedincisenol\Parasut\RequestModel;
use yedincisenol\Parasut\Response;

class Account extends Model
{
    protected $path = 'accounts';

    protected $parasut;

    /**
     * Model constructor.
     *
     * @param  Client  $parasut
     */
    public function __construct(Client $parasut)
    {
        $this->parasut = $parasut;
    }

    /**
     * Get a model object
     *
     * @param $id
     * @param  array  $query
     *
     * @return Response
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function transactions($id, $query = [])
    {
        $response = $this->parasut->request(
            'GET',
            $this->path.'/'.$id.'/transactions',
            $query
        );

        return new Response($response->getBody());
    }

    /**
     * @param  RequestModel  $request
     * @param  array  $query
     *
     * @return Response
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function debitTransactions(RequestModel $request, $query = [])
    {
        $model = $this->parasut->request(
            'POST',
            $this->path.'/'.$request->getId().'/debit_transactions',
            $query,
            $request->toArray()
        );

        return new Response($model->getBody());
    }

    /**
     * @param  RequestModel  $request
     * @param  array  $query
     *
     * @return Response
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function creditTransactions(RequestModel $request, $query = [])
    {
        $model = $this->parasut->request(
            'POST',
            $this->path.'/'.$request->getId().'/credit_transactions',
            $query,
            $request->toArray()
        );

        return new Response($model->getBody());
    }

}