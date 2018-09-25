<?php

namespace yedincisenol\Parasut;

class Response
{
    /**
     * Data array
     * @var
     */
    private $response;

    /**
     * Response array
     * @var
     */
    private $array;

    /**
     * Response constructor.
     * @param $response
     */
    public function __construct($response)
    {
        $this->response = $response;
        $this->array = json_decode($this->response, true);
    }

    /**
     * Get data of response
     * @param bool $key
     * @return mixed
     */
    public function getData($key = false)
    {
        if ($key && isset($this->array['data'][$key])) {
            return $this->array['data'][$key];
        }

        return $this->array['data'];
    }

    /**
     * Get meta of response
     * @return mixed
     */
    public function getMeta()
    {
        return $this->array['meta'];
    }

    /**
     * Get includes
     * @return mixed
     */
    public function getIncluded()
    {
        return $this->array['included'];
    }
}