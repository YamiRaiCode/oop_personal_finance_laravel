@extends('layouts.app')

@section('content')
<div class=" min-h-screen mx-auto mt-10 bg-white p-6 rounded-xl shadow-sm flex flex-col">
    <h2 class="text-xl font-bold mb-4">Edit Transaction</h2>

    <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block font-medium mb-1">Title</label>
            <input type="text" name="title" id="title" value="{{ $transaction->title }}" class="w-full border border-gray-300 rounded-lg p-2" required>           
        </div>

        {{-- Type --}}
        <div class="mb-4">
            <label for="type" class="block font-medium mb-1">Type</label>
            <select name="type" id="type" class="w-full border border-gray-300 rounded-lg p-2">
                <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label for="category_id" class="block font-medium mb-1">Category</label>
            <select name="category_id" id="category_id" class="w-full border border-gray-300 rounded-lg p-2">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $transaction->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Amount --}}
        <div class="mb-4">
            <label for="amount" class="block font-medium mb-1">Amount</label>
            <input type="number" name="amount" id="amount" step="0.01" value="{{ $transaction->amount }}" class="w-full border border-gray-300 rounded-lg p-2">
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label for="description" class="block font-medium mb-1">Description (optional)</label>
            <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-lg p-2">{{ $transaction->description }}</textarea>
        </div>

        {{-- Date --}}
        <div class="mb-4">
            <label for="date" class="block font-medium mb-1">Date</label>
            <input type="date" name="transaction_date" id="transaction_date" value="{{ $transaction->transaction_date }}" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue text-gray px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
