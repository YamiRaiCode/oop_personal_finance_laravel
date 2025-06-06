@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Transactions</h2>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf
        <input type="text" name="title" placeholder="Title" required>
        <input type="number" name="amount" step="0.01" placeholder="Amount" required>
        <select name="category_id" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->type }})</option>
            @endforeach
        </select>
        <input type="date" name="date" required>
        <button type="submit">Add Transaction</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->title }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->category->name }} ({{ $transaction->category->type }})</td>
                <td>{{ $transaction->date }}</td>
                <td>
                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this transaction?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
