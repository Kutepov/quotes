<?php

namespace App\Services;

use App\Jobs\ProcessShareQuote;
use App\Models\SharedQuote;
use Illuminate\Validation\ValidationException;

class ShareQuoteService
{
    private const VALIDATE_RULES = [
        'quote_id' => 'required|integer',
        'type' => 'required',
        'recipient' => 'required',
    ];

    private $modelManager;

    public function __construct(ManageModelService $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    public function share(array $data)
    {
        $this->modelManager->validate($data, self::VALIDATE_RULES);

        $shareQuote = new SharedQuote($data);
        $this->modelManager->validate(['recipient' => $shareQuote->recipient], $shareQuote->getShare()::VALIDATE_RULES);

        if (!$shareQuote->canShare()) {
            throw ValidationException::withMessages(['recipient' => 'Недоступный способ поделиться']);
        }

        ProcessShareQuote::dispatch($shareQuote);
        return true;
    }
}
