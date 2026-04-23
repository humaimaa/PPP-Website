@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-2xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.roles.index') }}"
           class="text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Create Role</h1>
            <p class="text-sm text-gray-500 mt-0.5">Define a new role and assign permissions</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            {{-- Role Name --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Role Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="e.g. content-admin, order-manager"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-400 @enderror">
                <p class="mt-1.5 text-xs text-gray-400">Use lowercase letters and hyphens only.</p>
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Permissions --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <label class="block text-sm font-medium text-gray-700">Assign Permissions</label>
                    @if($permissions->isNotEmpty())
                    <div class="flex gap-2">
                        <button type="button" id="selectAll"
                            class="text-xs text-indigo-600 hover:text-indigo-800 font-medium transition">
                            Select all
                        </button>
                        <span class="text-gray-300">|</span>
                        <button type="button" id="clearAll"
                            class="text-xs text-gray-500 hover:text-gray-700 font-medium transition">
                            Clear all
                        </button>
                    </div>
                    @endif
                </div>

                @if($permissions->isEmpty())
                    <div class="bg-amber-50 border border-amber-200 text-amber-700 text-sm px-4 py-3 rounded-lg">
                        No permissions available.
                        <a href="{{ route('admin.permissions.create') }}" class="underline font-medium">
                            Create some first →
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($permissions as $permission)
                        <label for="perm_{{ $permission->id }}"
                               class="flex items-center gap-3 border border-gray-200 rounded-lg px-3 py-2.5 cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-400">
                            <input type="checkbox"
                                   id="perm_{{ $permission->id }}"
                                   name="permissions[]"
                                   value="{{ $permission->id }}"
                                   class="perm-checkbox w-4 h-4 rounded text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                   {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                            <code class="text-xs text-gray-700 font-mono">{{ $permission->name }}</code>
                        </label>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                    Create Role
                </button>
                <a href="{{ route('admin.roles.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('selectAll')?.addEventListener('click', () => {
        document.querySelectorAll('.perm-checkbox').forEach(c => c.checked = true);
    });
    document.getElementById('clearAll')?.addEventListener('click', () => {
        document.querySelectorAll('.perm-checkbox').forEach(c => c.checked = false);
    });
</script>
@endsection