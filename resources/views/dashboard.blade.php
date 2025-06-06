<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold">Finance Summary</h3>
                    @if(isset($totalIncome))
                        <p><strong>Total Income:</strong> {{ number_format($income, 2) }}</p>
                    @else
                        <p>Total Income variable is not set!</p>
                    @endif
                    @if(isset($totalExpense))
                        <p><strong>Total Expense:</strong> {{ number_format($expense, 2) }}</p>
                    @else
                        <p>Total Expense variable is not set!</p>
                    @endif
                    @if(isset($balance))
                        <p><strong>Balance:</strong> {{ number_format($balance, 2) }}</p>
                    @else
                        <p>Balance variable is not set!</p>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@extends('layouts.app')



