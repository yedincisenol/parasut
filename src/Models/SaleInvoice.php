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
}
