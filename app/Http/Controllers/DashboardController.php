<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Date filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaction::with('category')
            ->where('user_id', $userId);

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        $transactions = $query->latest()->take(10)->get();

        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $query)->where('type', 'expense')->sum('amount');

        // Category based sum
        $categorySummary = (clone $query)
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get();


        $min = (clone $query)->min('amount');
        $max = (clone $query)->max('amount');
        $avg = (clone $query)->average('amount');

        $categoryNames = $categorySummary->pluck('category.name');
        $categoryTotals = $categorySummary->pluck('total');


        return view('dashboard', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'categorySummary',
            'min',
            'max',
            'avg',
            'startDate',
            'endDate',
            'categoryNames',
            'categoryTotals'
        ));

    }


    
}
