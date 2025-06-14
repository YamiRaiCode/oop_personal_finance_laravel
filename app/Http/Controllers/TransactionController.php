<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id(); // Current user id

        $query = Transaction::with('category')
                    ->where('user_id', $userId); //User's own transactions

        if ($request->filled('start_date')) {
            $query->where('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('transaction_date', '<=', $request->end_date);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('type')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();
        $categories = Category::all();

        return view('transactions.index', compact('transactions', 'categories'));
    }





    public function create()
    {
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'transaction_date' => 'required|date',
        ]);


        Transaction::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
        ]);


        return redirect()->route('transactions.index')->with('success', 'Transaction saved!');
        
    }




    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403); // forbidden access
        }

        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }


    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaction updated!');
    }


    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted!');
    }

}
