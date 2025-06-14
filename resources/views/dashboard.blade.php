@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 text-gray-800 p-6">

    {{-- buttons --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <a href="{{ route('transactions.create') }}" class="bg-blue text-gray px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Add Transaction
        </a>
    </div>

    <div class="mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-center">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="p-2 border rounded-md">

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="p-2 border rounded-md">

            <button type="submit" class="bg-blue-600 text-gray px-4 py-2 rounded-md">Filter</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm mb-6 flex flex-wrap items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold mb-4">Category Summary</h2>
            @if($categorySummary->isEmpty())
                <p class="text-gray-500">No data for selected period.</p>
            @else
                <ul>
                    @foreach($categorySummary as $summary)
                        <li class="mb-2">
                            <span class="font-semibold">{{ $summary->category->name }}:</span>                            
                            <span class="font-semibold @if($summary->category->type == 'income') text-green-600 @else text-red-600 @endif">@if($summary->category->type == 'expense') - @endif{{ number_format($summary->total, 2) }} €</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        {{-- Category Chart --}}
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h2 class="text-xl font-semibold mb-4">Category Chart</h2>
            <canvas id="categoryChart" class="w-full max-h-64"></canvas>
        </div>
        
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm mb-6 flex flex-wrap items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold mb-4">Statistics</h2>
            <ul class="list-disc pl-6 text-gray-700">
                <li><strong>Minimum Transaction:</strong>{{ number_format($min, 2) }} €</li>
                <li><strong>Maximum Transaction:</strong>{{ number_format($max, 2) }} €</li>
                <li><strong>Average Transaction:</strong>{{ number_format($avg, 2) }} €</li>
            </ul>
        </div>
        {{-- Statistics Chart --}}
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h2 class="text-xl font-semibold mb-4">Transaction Statistics</h2>
            <canvas id="statsChart" class="w-full max-h-64"></canvas>
        </div>
    </div>




    {{-- cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm">
            <h2 class="text-sm text-gray-500">Total Income</h2>
            <p class="text-xl font-semibold text-green-600">{{ $totalIncome }} €</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm">
            <h2 class="text-sm text-gray-500">Total Expense</h2>
            <p class="text-xl font-semibold text-red-600">{{ $totalExpense }} €</p>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm">
            <h2 class="text-sm text-gray-500">Balance</h2>
            <p class="text-xl font-semibold text-blue-600">{{ $totalIncome - $totalExpense }} €</p>
        </div>
    </div>

    {{-- Transactions List --}}
    <div class="bg-white p-6 rounded-xl shadow-sm">
        <h2 class="text-xl font-semibold mb-4">Recent Transactions</h2>

        @if($transactions->isEmpty())
            <p class="text-gray-500">You have no transactions yet.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="text-left p-2">Date</th>
                        <th class="text-left p-2">Category</th>
                        <th class="text-left p-2">Amount</th>
                        <th class="text-left p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2">{{ $tx->transaction_date }}</td>
                            <td class="p-2">{{ $tx->category->name }}</td>
                            <td class="p-2 @if($tx->type == 'income') text-green-600 @else text-red-600 @endif">
                                {{ $tx->amount }} €
                            </td>
                            <td class="p-2 space-x-2">
                                <div class="flex flex-wrap gap-4 justify-center items-end">
                                <a href="{{ route('transactions.edit', $tx) }}"
                                   class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('transactions.destroy', $tx) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete this transaction?')"
                                            class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                                <!-- <a href="{{ route('transactions.edit', $tx->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('transactions.destroy', $tx->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</button>
                                </form> -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'pie',
        data: {
            labels: @json($categoryNames),
            datasets: [{
                label: 'Amount',
                data: @json($categoryTotals),
                backgroundColor: [
                    '#60a5fa', '#f87171', '#34d399', '#fbbf24', '#a78bfa',
                    '#f472b6', '#38bdf8', '#fb923c'
                ],
                borderWidth: 1
            }]
        }
    });

    const statsCtx = document.getElementById('statsChart').getContext('2d');
    new Chart(statsCtx, {
        type: 'bar',
        data: {
            labels: ['Min', 'Avg', 'Max'],
            datasets: [{
                label: 'Transaction €',
                data: [{{ $min }}, {{ $avg }}, {{ $max }}],
                backgroundColor: ['#f87171', '#fbbf24', '#34d399'],
                borderWidth: 1
            }]
        }
    });
</script>

@endsection
