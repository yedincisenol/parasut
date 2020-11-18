<?php

namespace yedincisenol\Parasut\Models;

use GuzzleHttp\Exception\GuzzleException;
use yedincisenol\Parasut\Client;
use yedincisenol\Parasut\Exceptions\NotFoundException;
use yedincisenol\Parasut\Exceptions\ParasutException;
use yedincisenol\Parasut\Exceptions\UnproccessableEntityException;
use yedincisenol\Parasut\Response;

class EInvoiceInbox
{
    protected $path = 'e_invoice_inboxes';

    protected $parasut;

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
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    public function all($parameters = [])
    {
        $models = $this->parasut->request('GET', $this->path, $parameters);

        return new Response($models->getBody());
    }
}