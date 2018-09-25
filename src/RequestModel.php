<?php

namespace yedincisenol\Parasut;

class RequestModel
{

    /**
     * Object Identifier
     * @var
     */
    private $id;

    /**
     * Object type
     * @var
     */
    private $type;

    /**
     * Attributes
     * @var
     */
    private $attributes;

    /**
     * Relationships array
     * @var
     */
    private $relationships;

    /**
     * Request constructor.
     * @param $id
     * @param $type
     * @param $attributes
     * @param $relationships
     */
    public function __construct($id, $type, $attributes = [], $relationships = [])
    {
        $this->id = $id;
        $this->type = $type;
        $this->attributes = $attributes;
        $this->relationships = $relationships;
    }

    /**
     * Return request model id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Format relationships from array
     * @return array
     */
    private function getRelationshipsArray()
    {
        $relations = [];
        foreach ($this->relationships as $key => $relation) {
            if ($relation instanceof RequestModel) {
                $relations[$key] = $relation->toArray();
            } elseif (is_array($relation)) {
                foreach ($relation as $rel) {
                    $relations[$key]['data'][] = $rel->toArray(false);
                }
            }
        }

        return $relations;
    }

    /**
     * Create request body
     * @param bool $dataKey
     * @return array
     */
    public function toArray($dataKey = true)
    {
        $model =  [
            'id'    =>  $this->id,
            'type'  =>  $this->type,
            'attributes' => $this->attributes,
            'relationships' => $this->getRelationshipsArray()
        ];

        if (!$dataKey) {
            return $model;
        }

        return ['data' => $model];
    }
}