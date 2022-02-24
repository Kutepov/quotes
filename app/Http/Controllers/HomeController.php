<?php

namespace App\Http\Controllers;

use App\Models\Quote;

class HomeController extends Controller
{
    private const PAGINATION_PER_PAGE = 20;

    public function index()
    {
        $quotes = Quote::paginate(self::PAGINATION_PER_PAGE);
        return view('index', ['quotes' => $quotes]);
    }
}
