<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $income = Transaction::whereHas('category', fn($q) => $q->where('type', 'income'))->sum('amount');
        $expense = Transaction::whereHas('category', fn($q) => $q->where('type', 'expense'))->sum('amount');
        $balance = $income - $expense;

        return view('dashboard', compact('income', 'expense', 'balance'));
    }
}
