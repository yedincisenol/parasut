<?php

namespace yedincisenol\Parasut\Models;

use yedincisenol\Parasut\Response;

class EArchive extends Model
{
    protected $path = 'e_archives';

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
