<x-app-layout>
    <x-slot name="header">
        <h2>Add New Category</h2>
    </x-slot>

    <form method="POST" action="{{ route('categories.store') }}" class="max-w-md mx-auto p-4 bg-white rounded shadow">
        @csrf

        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Category Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full border px-3 py-2 rounded" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="type" class="block font-semibold mb-1">Type</label>
            <select id="type" name="type" class="w-full border px-3 py-2 rounded" required>
                <option value="">Select</option>
                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
            @error('type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</x-app-layout>
