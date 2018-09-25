<?php

namespace yedincisenol\Parasut\Models;

use yedincisenol\Parasut\Response;

class EInvoice extends Model
{
    protected $path = 'e_invoices';

    /**
     * Get PDF of invoice
     * @param $id
     * @return Response
     */
    public function pdf($id)
    {
        $response = $this->parasut->request('GET', $this->path. '/' . $id . '/pdf');

        return new Response($response->getBody());
    }
}
