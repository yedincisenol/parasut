<?php

namespace yedincisenol\Parasut\Models;

use GuzzleHttp\Exception\GuzzleException;
use yedincisenol\Parasut\Exceptions\NotFoundException;
use yedincisenol\Parasut\Exceptions\ParasutException;
use yedincisenol\Parasut\Exceptions\UnproccessableEntityException;
use yedincisenol\Parasut\Response;

class EArchive extends Model
{
    protected $path = 'e_archives';

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
        $response = $this->parasut->request('GET', $this->path. '/' . $id . '/pdf');

        return new Response($response->getBody());
    }
}
