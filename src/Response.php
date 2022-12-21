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

        return $this->array['data'] ?? [];
    }

    /**
     * Get meta of response
     * @return mixed
     */
    public function getMeta()
    {
        return $this->array['meta'] ?? [];
    }

    /**
     * Get includes
     * @param null $type
     * @return mixed
     */
    public function getIncluded($type = null)
    {
        if (!isset($this->array['included'])) {
            $this->array['included'] = [];
        }
        if ($type) {
            return array_filter($this->array['included'], function ($array) use ($type) {
                return $array['type'] == $type;
            });
        }

        return $this->array['included'];
    }
}