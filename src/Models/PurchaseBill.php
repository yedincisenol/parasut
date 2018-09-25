<?php

namespace yedincisenol\Parasut\Models;

use yedincisenol\Parasut\RequestModel;
use yedincisenol\Parasut\Response;

class PurchaseBill extends Model
{
    protected $path = 'purchase_bills#detailed';

    /**
     * Create new payment
     * @param Request|RequestModel $request
     * @param array $query
     * @return Response
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
}
