<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Services\QuotesService;
use App\Services\ShareQuoteService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('owner:quote', ['only' => ['update', 'destroy']]);
    }

    public function index(Request $request, QuotesService $quotesService)
    {
        $where = [];
        if ($request->get('source')) {
            $where['source'] = $request->get('source');
        }

        $quotes = $quotesService->getList($where, ['id' => 'desc'])->appends($request->query());

        return response()->json(['quotes' => $quotes]);
    }

    public function store(Request $request, QuotesService $quotesService)
    {
        $formFields = $request->only(['source', 'text']);
        $formFields['user_id'] = auth()->id();
        $quotesService->create($formFields);
        return response()->json(['success' => true]);
    }

    public function update(Request $request, Quote $quote, QuotesService $quotesService)
    {
        $fields = $request->only(['source', 'text']);
        $fields['user_id'] = auth()->id();

        $quotesService->update($fields, $quote);
        return response()->json(['quote' => $quote]);
    }

    public function destroy(Quote $quote, QuotesService $quotesService)
    {
        $quotesService->delete($quote);
        return response()->json(['quote' => $quote]);
    }

    public function share(Request $request, ShareQuoteService $shareService)
    {
        $shareService->share($request->only('quote_id', 'recipient', 'type'));
        return response()->json(['success' => true], 201);
    }
}
