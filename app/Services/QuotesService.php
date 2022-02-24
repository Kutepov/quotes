<?php

namespace App\Services;

use App\Models\Quote;

class QuotesService
{
    private const CREATE_QUOTE_RULES = [
        'user_id' => 'required|integer',
        'source' => 'required|max:255|unique:quotes',
        'text' => 'required',
    ];

    private $modelManager;

    public function __construct(ManageModelService $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $data)
    {
        return $this->modelManager->save($data, new Quote(), self::CREATE_QUOTE_RULES);
    }

    public function update(array $data, Quote $quote)
    {
        $rules = self::CREATE_QUOTE_RULES;
        $rules['source'] .= ',source,'.$quote->id;
        return $this->modelManager->save($data, $quote, $rules);
    }

    /**
     * @param Quote $quote
     * @return bool|null
     */
    public function delete(Quote $quote)
    {
        return $quote->delete();
    }
}
