<x-app-layout>
    <x-slot name="header">
        <h2>Edit Category</h2>
    </x-slot>

    <form method="POST" action="{{ route('categories.update', $category) }}" class="max-w-md mx-auto p-4 bg-white rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Category Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="w-full border px-3 py-2 rounded" required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="type" class="block font-semibold mb-1">Type</label>
            <select id="type" name="type" class="w-full border px-3 py-2 rounded" required>
                <option value="income" {{ old('type', $category->type) == 'income' ? 'selected' : '' }}>Income</option>
                <option value="expense" {{ old('type', $category->type) == 'expense' ? 'selected' : '' }}>Expense</option>
            </select>
            @error('type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</x-app-layout>
