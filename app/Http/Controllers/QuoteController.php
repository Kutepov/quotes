<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Services\QuotesService;
use App\Services\ShareQuoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('owner:quote', ['only' => ['edit', 'update', 'destroy']]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('quotes.create');
    }

    /**
     * @param Request $request
     * @param QuotesService $quotesService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, QuotesService $quotesService)
    {
        $formFields = $request->only(['source', 'text']);
        $formFields['user_id'] = auth()->id();
        $quotesService->create($formFields);

        $this->addFlash('Цитата успешно добавлена.', 'success');
        return redirect()->route('home');
    }

    /**
     * @param Quote $quote
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Quote $quote)
    {
        return view('quotes.edit', ['quote' => $quote]);
    }

    /**
     * @param Request $request
     * @param Quote $quote
     * @param QuotesService $quotesService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Quote $quote, QuotesService $quotesService)
    {
        $fields = $request->only(['source', 'text']);
        $fields['user_id'] = auth()->id();

        $quotesService->update($fields, $quote);
        return redirect()->route('home')->with('success', 'Цитата успешно добавлена.');
    }

    /**
     * @param Quote $quote
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy(Quote $quote, QuotesService $quotesService)
    {
        $quotesService->delete($quote);
        return redirect()->route('home')->with('success', 'Цитата успешно удалена.');
    }

    public function share(Request $request, ShareQuoteService $shareService)
    {
        $shareService->share($request->only('quote_id', 'recipient', 'type'));
        return true;
    }

    private function addFlash(string $message, string $alertClass = '')
    {
        Session::flash('message', $message);
        if ($alertClass) {
            Session::flash('alert-class', $alertClass);
        }
    }
}
