<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class ManageModelService
{
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @param Model $model
     * @param array $rules
     * @return Model
     * @throws ValidationException
     */
    public function save(array $data, Model $model, array $rules): Model
    {
        $this->validate($data, $rules);
        $model->fill($data);
        if (!$model->save()) {
            throw new \Exception('Error save model');
        }

        return $model;
    }

    /**
     * @param $data
     * @param $rules
     * @return bool
     * @throws ValidationException
     */
    public function validate($data, $rules): bool
    {
        $validator = $this->validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
