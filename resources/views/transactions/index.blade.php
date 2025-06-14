@extends('layouts.app')

@section('content')
<div class=" min-h-screen bg-gray-100 max-w-fit mx-auto mt-10 p-6 rounded-xl shadow-sm">

    <h2 class="text-[32px] font-bold mb-6 text-center">Transactions</h2>

    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

        {{-- 🔍 Filter Form --}}
    <form method="GET" action="{{ route('transactions.index') }}" class="bg-white p-6 mb-6 shadow-md rounded-lg flex flex-wrap gap-4 justify-between items-center mb-8">

        {{-- Start Date --}}
        <div class="flex flex-col">
            <label for="start_date" class="text-sm font-medium text-gray-700 mb-1">Start Date</label>
            <input type="date" name="start_date" id="start_date"
                value="{{ request('start_date') }}"
                class="border border-gray-300 rounded-lg p-2 w-40">
        </div>

        {{-- End Date --}}
        <div class="flex flex-col">
            <label for="end_date" class="text-sm font-medium text-gray-700 mb-1">End Date</label>
            <input type="date" name="end_date" id="end_date"
                value="{{ request('end_date') }}"
                class="border border-gray-300 rounded-lg p-2 w-40">
        </div>

        {{-- Category --}}
        <div class="flex flex-col">
            <label for="category_id" class="text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category_id" id="category_id"
                    class="border border-gray-300 rounded-lg p-2 w-48">
                <option value="">All</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }} ({{ $category->type }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Type --}}
        <div class="flex flex-col">
            <label for="type" class="text-sm font-medium text-gray-700 mb-1">Type</label>
            <select name="type" id="type"
                    class="border border-gray-300 rounded-lg p-2 w-36">
                <option value="">All</option>
                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
        </div>

        {{-- Filter Button --}}
        <div class="flex flex-col">
            <label class="invisible mb-1">Filter</label>
            <button type="submit"
                    class="bg-blue-600 text-gray px-4 py-2 rounded-lg hover:bg-blue-700 transition w-24">
                Filter
            </button>
        </div>
    </form>

    {{-- 🧾 Transactions Table --}}
    <div class="shadow-md rounded-lg">
        <table class="bg-white mt-12 w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 p-2 text-left">Title</th>
                    <th class="border border-gray-300 p-2 text-left">Amount</th>
                    <th class="border border-gray-300 p-2 text-left">Category</th>
                    <th class="border border-gray-300 p-2 text-left">Date</th>
                    <th class="border border-gray-300 p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 p-2">{{ $transaction->title }}</td>
                        <td class="border border-gray-300 p-2 @if($transaction->type == 'income') text-green-600 @else text-red-600 @endif">
                                {{ $transaction->amount }} €
                            </td>
                        <td class="border border-gray-300 p-2">
                            {{ $transaction->category->name }} ({{ $transaction->category->type }})
                        </td>
                        <td class="border border-gray-300 p-2">{{ $transaction->transaction_date }}</td>
                        <td class="border border-gray-300 p-2">
                            <div class="flex flex-wrap gap-4 justify-center items-end">
                                <a href="{{ route('transactions.edit', $transaction) }}"
                                   class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete this transaction?')"
                                            class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-500">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
