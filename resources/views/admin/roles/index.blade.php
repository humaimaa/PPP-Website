@extends('layouts.admin')

@section('content')
<div class="p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Roles</h1>
            <p class="text-sm text-gray-500 mt-1">Create and manage admin roles</p>
        </div>
        <a href="{{ route('admin.roles.create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + Add Role
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-lg">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Role Name</th>
                    <th class="px-6 py-3 text-left">Permissions</th>
                    <th class="px-6 py-3 text-left">Users</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @forelse($roles as $role)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center bg-gray-800 text-white text-xs font-medium px-2.5 py-1 rounded-md">
                            {{ $role->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @forelse($role->permissions as $perm)
                                <span class="bg-indigo-50 text-indigo-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                    {{ $perm->name }}
                                </span>
                            @empty
                                <span class="text-gray-400 text-xs">No permissions</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-600 font-medium">{{ $role->users_count }}</span>
                        <span class="text-gray-400 text-xs ml-1">{{ Str::plural('user', $role->users_count) }}</span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.roles.edit', $role) }}"
                           class="inline-flex items-center text-xs font-medium text-indigo-600 hover:text-indigo-800 border border-indigo-200 hover:border-indigo-400 px-3 py-1.5 rounded-lg transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.roles.destroy', $role) }}"
                              method="POST" class="inline"
                              onsubmit="return confirm('Delete this role? Users with this role will lose its permissions.')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center text-xs font-medium text-red-600 hover:text-red-800 border border-red-200 hover:border-red-400 px-3 py-1.5 rounded-lg transition">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <p class="text-lg mb-1">No roles yet</p>
                        <a href="{{ route('admin.roles.create') }}" class="text-indigo-600 hover:underline text-sm">
                            Create your first role →
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $roles->links() }}</div>
</div>
@endsection