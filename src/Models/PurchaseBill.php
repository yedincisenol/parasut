<?php

namespace yedincisenol\Parasut\Models;

use GuzzleHttp\Exception\GuzzleException;
use yedincisenol\Parasut\Exceptions\NotFoundException;
use yedincisenol\Parasut\Exceptions\ParasutException;
use yedincisenol\Parasut\Exceptions\UnproccessableEntityException;
use yedincisenol\Parasut\RequestModel;
use yedincisenol\Parasut\Response;

class PurchaseBill extends Model
{
    protected $path = 'purchase_bills#detailed';

    /**
     * Create new payment
     * @param RequestModel $request
     * @param array $query
     * @return Response
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function payment(RequestModel $request, $query = [])
    {
        $model = $this->parasut->request(
            'POST',
            'purchase_bills/' . $request->getId() . '/payments',
            $query,
            $request->toArray()
        );

        return new Response($model->getBody());
    }

    /**
     * @param $id
     * @param $query
     * @return Response
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function details($id, $query = [])
    {
        $response = $this->parasut->request('GET', 'purchase_bills/' . $id . '/details', $query);

        return new Response($response->getBody());
    }
}
