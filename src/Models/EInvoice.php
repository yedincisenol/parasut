<?php

namespace yedincisenol\Parasut\Models;

use GuzzleHttp\Exception\GuzzleException;
use yedincisenol\Parasut\Exceptions\NotFoundException;
use yedincisenol\Parasut\Exceptions\ParasutException;
use yedincisenol\Parasut\Exceptions\UnproccessableEntityException;
use yedincisenol\Parasut\Response;

class EInvoice extends Model
{
    protected $path = 'e_invoices';

    /**
     * Get PDF of invoice
     * @param $id
     * @return Response
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function pdf($id)
    {
        $response = $this->parasut->request('GET', $this->path . '/' . $id . '/pdf');

        return new Response($response->getBody());
    }

    public function convert($id)
    {
        $response = $this->parasut->request('GET', $this->path . '/' . $id . '/convert');

        return new Response($response->getBody());
    }

    public function reject($id, $note)
    {
        $model = $this->parasut->request(
            'POST',
            $this->path . '/' .$id . '/respond',
            [],
            [
                'data' => [
                    'attributes' => [
                        'response_type' => 'reject',
                        'note' => $note
                    ]
                ]
            ]
        );

        return new Response($model->getBody());
    }

    public function accept($id)
    {
        $model = $this->parasut->request(
            'POST',
            $this->path . '/' .$id . '/respond',
            [],
            [
                'data' => [
                    'attributes' => [
                        'response_type' => 'accept',
                    ]
                ]
            ]
        );

        return new Response($model->getBody());
    }
}
