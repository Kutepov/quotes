<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Services\QuotesService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, QuotesService $quotesService)
    {
        $where = [];
        if ($request->get('source')) {
            $where['source'] = $request->get('source');
        }

        $quotes = $quotesService->getList($where, ['id' => 'desc'])->appends($request->query());

        if ($request->ajax()) {
            return view('quotes.list', ['quotes' => $quotes]);
        }

        $dropdownData = Quote::groupBy('source')->pluck('source', 'source');
        return view('index', ['quotes' => $quotes, 'dropdownData' => $dropdownData]);
    }
}
