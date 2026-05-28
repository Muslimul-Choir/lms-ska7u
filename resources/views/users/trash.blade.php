{{-- resources/views/users/trash.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('users.index') }}"
                    class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Trash — Manajemen Akun</h2>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $users->total() }} data terhapus</p>
                </div>
            </div>

            @if ($users->total() > 0)
                <div class="flex gap-2 flex-shrink-0">
                    <form action="{{ route('users.restoreAll') }}" method="POST" id="restoreAllForm">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="confirmRestoreAll(event)"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Restore Semua
                        </button>
                    </form>

                    <form action="{{ route('users.forceDeleteAll') }}" method="POST" id="forceDeleteAllForm">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmForceDeleteAll(event)"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Permanen Semua
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="space-y-5">


        {{-- Search & Filter --}}
        <div
            class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/60 shadow-sm">
            <form method="GET" action="{{ route('users.trash') }}" class="p-4 sm:p-5">
                <div class="flex flex-col gap-4 xl:gap-16 xl:flex-row xl:items-end xl:justify-between">

                    {{-- Left: Filters --}}
                    <div class="grid flex-1 gap-4 grid-cols-2 md:grid-cols-3">

                        {{-- Search --}}
                        <div class="flex flex-col gap-1.5 md:col-span-2">
                            <label
                                class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                                Cari
                            </label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama / email..."
                                class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none
                                       focus:ring-2 focus:ring-red-600/20 focus:border-red-600 dark:focus:border-red-400">
                        </div>

                        {{-- Role --}}
                        <div class="flex flex-col gap-1.5">
                            <label
                                class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                                Role
                            </label>
                            <select name="role"
                                class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                       focus:ring-2 focus:ring-red-600/20 focus:border-red-600 dark:focus:border-red-400">
                                <option value="">Semua Role</option>
                                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>
                                    Super Admin
                                </option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                            </select>
                        </div>

                    </div>

                    {{-- Right: Actions --}}
                    <div class="flex items-center justify-end gap-2 shrink-0">
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-xl
                                   bg-blue-600 hover:bg-blue-700 text-white transition-all duration-200 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Filter
                        </button>

                        @if (request()->hasAny(['search', 'role']))
                            <a href="{{ route('users.trash') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-xl
                                       bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-300
                                       transition-all duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>

                </div>
            </form>
        </div>

        {{-- Data Table --}}
        <div
            class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/60 shadow-sm overflow-hidden">

            {{-- Table Top Bar --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <span class="block w-1 h-5 rounded-full bg-red-600"></span>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100 tracking-tight">Data
                        Terhapus</span>
                </div>
                <span class="text-xs text-slate-400 dark:text-slate-500 tabular-nums">
                    Total &nbsp;<span
                        class="font-bold text-slate-700 dark:text-slate-200">{{ $users->total() }}</span>
                    &nbsp;user
                </span>
            </div>

            {{-- Scrollable Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr
                            class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/30">
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400">
                                No</th>
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400">
                                Nama</th>
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400">
                                Email</th>
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400">
                                Role</th>
                            <th
                                class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400">
                                Dihapus Pada</th>
                            <th
                                class="px-5 py-3 text-center text-[11px] font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800/70">
                        @forelse($users as $index => $user)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors duration-150">
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-500 dark:text-slate-400">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td
                                    class="px-5 py-3.5 text-sm font-medium text-slate-400 dark:text-slate-500 line-through">
                                    {{ $user->name }}
                                </td>
                                <td class="px-5 py-3.5 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $user->email }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @php
                                        $badge =
                                            [
                                                'super_admin' =>
                                                    'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                                'admin' =>
                                                    'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            ][$user->role] ??
                                            'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-semibold {{ $badge }} opacity-60">
                                        {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-xs">
                                    <div class="text-slate-600 dark:text-slate-400">
                                        {{ $user->deleted_at->diffForHumans() }}</div>
                                    <div class="text-slate-400 dark:text-slate-500 text-[10px]">
                                        {{ $user->deleted_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex justify-center gap-1.5">

                                        <form action="{{ route('users.restore', $user->id) }}" method="POST"
                                            class="restoreForm">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button"
                                                onclick="confirmRestore(event, '{{ $user->name }}')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-medium transition-all duration-200">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Restore
                                            </button>
                                        </form>

                                        <form action="{{ route('users.forceDelete', $user->id) }}" method="POST"
                                            class="forceDeleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmForceDelete(event, '{{ $user->name }}')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-medium transition-all duration-200">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus Permanen
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-14 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-600">
                                        <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <p class="text-sm font-medium">
                                            {{ request()->hasAny(['search', 'role']) ? 'Tidak ada data yang sesuai filter.' : 'Trash kosong.' }}
                                        </p>
                                        @if (request()->hasAny(['search', 'role']))
                                            <a href="{{ route('users.trash') }}"
                                                class="text-xs text-indigo-500 hover:text-indigo-600 transition">
                                                Reset filter
                                            </a>
                                        @else
                                            <a href="{{ route('users.index') }}"
                                                class="text-xs text-indigo-500 hover:text-indigo-600 transition">
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

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="px-5 py-3.5 border-t border-slate-100 dark:border-slate-800">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>

    @include('components.alerts.confirm-update')
    @include('components.alerts.confirm-delete')

    @push('scripts')
        <script>
            /* ════════════════════════════════════════════
                       CONFIRM RESTORE SINGLE
                    ════════════════════════════════════════════ */
            function confirmRestore(event, userName) {
                event.preventDefault();
                const form = event.target.closest('form');

                Swal.fire({
                    title: 'Kembalikan User?',
                    text: `Kembalikan "${userName}" dari trash?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, kembalikan',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }

            /* ════════════════════════════════════════════
               CONFIRM RESTORE ALL
            ════════════════════════════════════════════ */
            function confirmRestoreAll(event) {
                event.preventDefault();
                const form = event.target.closest('form');

                Swal.fire({
                    title: 'Kembalikan Semua User?',
                    text: 'Kembalikan SEMUA user yang ada di trash?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, kembalikan semua',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }

            /* ════════════════════════════════════════════
               CONFIRM FORCE DELETE SINGLE
            ════════════════════════════════════════════ */
            function confirmForceDelete(event, userName) {
                event.preventDefault();
                const form = event.target.closest('form');

                Swal.fire({
                    title: 'Hapus Permanen?',
                    html: `Hapus PERMANEN user <strong>"${userName}"</strong>?<br><small class="text-red-600">Tindakan ini TIDAK BISA dibatalkan!</small>`,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus permanen',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }

            /* ════════════════════════════════════════════
               CONFIRM FORCE DELETE ALL
            ════════════════════════════════════════════ */
            function confirmForceDeleteAll(event) {
                event.preventDefault();
                const form = event.target.closest('form');

                Swal.fire({
                    title: 'Hapus Permanen Semua?',
                    html: 'Hapus PERMANEN <strong>SEMUA user</strong> di trash?<br><small class="text-red-600">Tindakan ini TIDAK BISA dibatalkan!</small>',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus semua permanen',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        </script>
    @endpush

</x-app-layout>
