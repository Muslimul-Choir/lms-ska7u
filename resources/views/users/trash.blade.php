{{-- resources/views/users/trash.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('users.index') }}"
                    class="p-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Trash — Manajemen Akun</h2>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $users->total() }} data terhapus</p>
                </div>
            </div>

            @if($users->total() > 0)
            <div class="flex gap-2">
                <form action="{{ route('users.restoreAll') }}" method="POST"
                    onsubmit="return confirm('Kembalikan SEMUA user yang ada di trash?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Restore Semua
                    </button>
                </form>

                <form action="{{ route('users.forceDeleteAll') }}" method="POST"
                    onsubmit="return confirm('HAPUS PERMANEN semua user di trash?\nTindakan ini TIDAK BISA dibatalkan!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Permanen Semua
                    </button>
                </form>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="p-6">

        {{-- Alert --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('users.trash') }}" class="mb-5">
            <div class="flex flex-wrap gap-3 items-center">

                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama / email..."
                    class="border rounded-lg px-3 py-2 text-sm w-64 focus:ring focus:ring-red-200 focus:outline-none">

                <select name="role"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-red-200 focus:outline-none">
                    <option value="">Semua Role</option>
                    <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>
                        Super Admin
                    </option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg text-sm font-medium transition">
                    Filter
                </button>

                @if(request()->hasAny(['search', 'role']))
                    <a href="{{ route('users.trash') }}"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg text-sm font-medium transition">
                        Reset
                    </a>
                @endif

            </div>
        </form>

        {{-- Tabel --}}
        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs border-b">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Dihapus Pada</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr class="border-t hover:bg-red-50/40 transition">
                            <td class="px-4 py-3 text-gray-400">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-400 line-through">
                                {{ $user->name }}
                            </td>
                            <td class="px-4 py-3 text-gray-400">
                                {{ $user->email }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $badge = [
                                        'super_admin' => 'bg-purple-100 text-purple-700',
                                        'admin'       => 'bg-blue-100 text-blue-700',
                                    ][$user->role] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badge }} opacity-60">
                                    {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-400">
                                {{ $user->deleted_at->diffForHumans() }}<br>
                                <span class="text-gray-300">{{ $user->deleted_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">

                                    <form action="{{ route('users.restore', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Kembalikan user {{ addslashes($user->name) }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-medium transition">
                                            Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('users.forceDelete', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus PERMANEN user {{ addslashes($user->name) }}?\nTidak bisa dibatalkan!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium transition">
                                            Hapus Permanen
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-14 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-300">
                                    <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <p class="text-sm font-medium">
                                        {{ request()->hasAny(['search','role']) ? 'Tidak ada data yang sesuai filter.' : 'Trash kosong.' }}
                                    </p>
                                    @if(request()->hasAny(['search','role']))
                                        <a href="{{ route('users.trash') }}" class="text-xs text-indigo-400 hover:underline">
                                            Reset filter
                                        </a>
                                    @else
                                        <a href="{{ route('users.index') }}" class="text-xs text-indigo-400 hover:underline">
                                            Kembali ke Manajemen User
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif

    </div>

</x-app-layout>