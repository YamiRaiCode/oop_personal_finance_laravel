@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 max-w-md">
    <h1 class="text-2xl font-bold mb-6">Add New Transaction</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="title" class="block font-semibold mb-1">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div>
            <label for="amount" class="block font-semibold mb-1">Amount</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" step="0.01" min="0" required
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div>
            <label for="type" class="block font-semibold mb-1">Type</label>
            <select name="type" id="type" required class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Select type</option>
                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </div>

        <div>
            <label for="category_id" class="block font-semibold mb-1">Category</label>
            <select name="category_id" id="category_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="transaction_date" class="block font-semibold mb-1">Date</label>
            <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date') ?? date('Y-m-d') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
    </form>
</div>
@endsection
