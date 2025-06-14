@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 mx-auto mt-10 p-6 rounded-xl shadow-sm flex flex-col items-center">
    <h2 class="text-xl font-bold mb-4">Add Transaction</h2>

    <form action="{{ route('transactions.store') }}" method="POST" class="w-full bg-white p-6 rounded-lg">
        @csrf

        <div class="mb-4">
            <label for="title" class="block font-medium mb-1">Title</label>
            <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded-lg p-2" required>           
        </div>

        {{-- Type --}}
        <div class="mb-4">
            <label for="type" class="block font-medium mb-1">Type</label>
            <select name="type" id="type" class="w-full border border-gray-300 rounded-lg p-2" required>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label for="category_id" class="block font-medium mb-1">Category</label>
            <select name="category_id" id="category_id" class="w-full border border-gray-300 rounded-lg p-2" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Amount --}}
        <div class="mb-4">
            <label for="amount" class="block font-medium mb-1">Amount</label>
            <input type="number" name="amount" id="amount" step="0.01" class="w-full border border-gray-300 rounded-lg p-2" required>
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label for="description" class="block font-medium mb-1">Description (optional)</label>
            <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-lg p-2"></textarea>
        </div>

        {{-- Date --}}
        <div class="mb-4">
            <label for="date" class="block font-medium mb-1">Date</label>
            <input type="date" name="transaction_date" id="date" class="w-full border border-gray-300 rounded-lg p-2" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue text-gray px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
