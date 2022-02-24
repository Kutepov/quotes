<?php

namespace App\Services;

use App\Models\Quote;

class QuotesService
{
    private const PAGINATION_PER_PAGE = 20;
    private const CREATE_QUOTE_RULES = [
        'user_id' => 'required|integer',
        'source' => 'required|max:255|url',
        'text' => 'required|max:1000|unique:quotes',
    ];

    private $modelManager;

    public function __construct(ManageModelService $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    public function getList(array $where = [], array $orderBy = [], bool $withPaginate = true, int $pageSize = self::PAGINATION_PER_PAGE)
    {
        $result = Quote::query();
        if ($where) {
            $result->where($where);
        }

        if ($orderBy) {
            foreach ($orderBy as $column => $direction) {
                $result->orderBy($column, $direction);
            }
        }
        return $withPaginate ? $result->paginate($pageSize) : $result->all();
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
        $rules['text'] .= ',text,'.$quote->id;
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
