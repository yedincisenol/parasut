<?php

namespace yedincisenol\Parasut\Models;

use GuzzleHttp\Exception\GuzzleException;
use yedincisenol\Parasut\Exceptions\NotFoundException;
use yedincisenol\Parasut\Exceptions\ParasutException;
use yedincisenol\Parasut\Exceptions\UnproccessableEntityException;
use yedincisenol\Parasut\RequestModel;
use yedincisenol\Parasut\Response;

class SaleInvoice extends Model
{
    protected $path = 'sales_invoices';

    /**
     * Create new payment
     * @param Request|RequestModel $request
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
            $this->path . '/' . $request->getId() . '/payments',
            $query,
            $request->toArray()
        );

        return new Response($model->getBody());
    }

    /**
     * @param string $id
     * @return Response
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function cancelInvoice(string $id)
    {
        $model = $this->parasut->request(
            'DELETE',
            $this->path . '/' . $id . '/cancel',
            [],
            (new RequestModel($id, $this->path))->toArray()
        );

        return new Response($model->getBody());
    }

    public function details($id, $query = [])
    {
        $response = $this->parasut->request('GET', $this->path . '/' . $id . '/details', $query);

        return new Response($response->getBody());
    }
}
