<x-app-layout>
    {{-- Include Modal --}}
    @include('users.modal-create')
    @include('users.modal-edit')

    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-3">

            {{-- Left: Icon + Title --}}
            <div class="flex items-center gap-3.5">
                <div class="relative flex-shrink-0">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-md shadow-indigo-200 dark:shadow-indigo-900/40">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-base font-bold tracking-wide text-slate-900 dark:text-white leading-tight">
                        Manajemen Akun Super Admin & Admin
                    </h1>
                    <p
                        class="text-[11px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-0.5">
                        Data Master
                    </p>
                </div>
            </div>

            {{-- Right: Action Button --}}
            <div class="flex gap-2 items-center flex-shrink-0">
                {{-- Trash --}}
                <a href="{{ route('users.trash') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl text-sm font-medium transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Trash</span>
                    @if ($trashCount > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full font-semibold">
                            {{ $trashCount }}
                        </span>
                    @endif
                </a>

                {{-- Tambah --}}
                <button onclick="openCreateUserModal()"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah User</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-5">
        {{-- ═══════════════════════════════════════════
             FILTER TOOLBAR
        ═══════════════════════════════════════════ --}}
        <div
            class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/60 shadow-sm">
            <form method="GET" action="{{ route('users.index') }}" id="filterForm">

                <div class="p-4 sm:p-5">
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
                                           focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 dark:focus:border-indigo-400">
                            </div>

                            {{-- Role --}}
                            <div class="flex flex-col gap-1.5">
                                <label
                                    class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">
                                    Role
                                </label>
                                <select name="role"
                                    class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2.5 text-sm text-slate-700 dark:text-slate-200 transition duration-200 outline-none cursor-pointer
                                           focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 dark:focus:border-indigo-400">
                                    <option value="">Semua Role</option>
                                    <option value="super_admin"
                                        {{ request('role') == 'super_admin' ? 'selected' : '' }}>
                                        Super Admin
                                    </option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
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

                            <a href="{{ route('users.index') }}"
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
                        </div>

                    </div>

                </div>
            </form>
        </div>


        {{-- ═══════════════════════════════════════════
             DATA TABLE
        ═══════════════════════════════════════════ --}}
        <div
            class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-700/60 shadow-sm overflow-hidden">

            {{-- Table Top Bar --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <span class="block w-1 h-5 rounded-full bg-indigo-600"></span>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-100 tracking-tight">Daftar User</span>
                </div>
                <span class="text-xs text-slate-400 dark:text-slate-500 tabular-nums">
                    Total &nbsp;<span class="font-bold text-slate-700 dark:text-slate-200">{{ $users->total() }}</span>
                    &nbsp;user
                </span>
            </div>

            {{-- Scrollable Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/30">
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
                                class="px-5 py-3 text-center text-[11px] font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800/70">
                        @forelse ($users as $index => $user)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors duration-150">
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-900 dark:text-white">
                                    {{ $user->name }}
                                </td>
                                <td class="px-5 py-3.5 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $user->email }}
                                </td>
                                <td class="px-5 py-3.5 text-sm">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-semibold
                                               {{ $user->role === 'super_admin' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                        {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex justify-center gap-1.5">

                                        {{-- Edit --}}
                                        <button onclick="openEditUserModal(this)" data-id="{{ $user->id }}"
                                            data-route="{{ route('users.update', $user->id) }}"
                                            data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs font-medium transition-all duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>

                                        {{-- Delete --}}
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(event)"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-medium transition-all duration-200">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-slate-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-sm">Data tidak ditemukan</p>
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
                       MODAL CREATE
                    ════════════════════════════════════════════ */
            function openCreateUserModal() {
                document.getElementById('modalCreateUser').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeCreateUserModal() {
                document.getElementById('modalCreateUser').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ════════════════════════════════════════════
               MODAL EDIT
            ════════════════════════════════════════════ */
            function openEditUserModal(button) {
                const d = button.dataset;
                const modal = document.getElementById('modalEditUser');
                const form = document.getElementById('editFormAction');
                const btn = document.getElementById('editSubmitBtn');

                form.action = d.route;
                document.getElementById('edit_route').value = d.route;

                document.getElementById('edit_user_id').value = d.id;
                document.getElementById('edit_name').value = d.name;
                document.getElementById('edit_email').value = d.email;
                document.getElementById('edit_role').value = d.role;

                btn.disabled = false;
                btn.innerHTML = `
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Update
                `;

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeEditUserModal() {
                document.getElementById('modalEditUser').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            /* ════════════════════════════════════════════
               CONFIRM DELETE
            ════════════════════════════════════════════ */
            function confirmDelete(event) {
                event.preventDefault();
                const form = event.target.closest('form');

                showConfirmDelete(true).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }

            /* ════════════════════════════════════════════
               FORM HANDLERS & VALIDATION
            ════════════════════════════════════════════ */
            document.addEventListener('DOMContentLoaded', () => {

                /* Anti double-submit create dan edit */
                const createForm = document.getElementById('createFormAction');
                const createBtn = document.getElementById('createSubmitBtn');
                const editForm = document.getElementById('editFormAction');
                const editBtn = document.getElementById('editSubmitBtn');

                if (createForm) {
                    createForm.addEventListener('submit', () => {
                        createBtn.disabled = true;
                        createBtn.innerHTML = `
                            <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Menyimpan...
                        `;
                    });
                }

                if (editForm) {
                    editForm.addEventListener('submit', (e) => {
                        e.preventDefault();

                        showConfirmUpdate().then((result) => {
                            if (result.isConfirmed) {
                                editForm.submit();
                            }
                        });
                    });
                }

                /* Re-open modal on validation error */
                @if ($errors->any())
                    @if (old('_modal') === 'create')
                        openCreateUserModal();
                    @elseif (old('_modal') === 'edit')
                        openEditUserModal(document.querySelector(`[data-id="${ old('edit_id') }"]`) || {
                            dataset: {
                                id: '{{ old('edit_id') }}',
                                name: '{{ old('name') }}',
                                email: '{{ old('email') }}',
                                role: '{{ old('role') }}',
                                route: '/users/{{ old('edit_id') }}'
                            }
                        });
                        document.body.classList.add('overflow-hidden');
                    @endif
                @endif

                /* Close modal on backdrop click */
                ['modalCreateUser', 'modalEditUser'].forEach(id => {
                    const modal = document.getElementById(id);
                    if (modal) {
                        const overlay = modal.querySelector('[onclick*="close"]');
                        if (overlay) {
                            overlay.parentElement.addEventListener('click', (e) => {
                                if (e.target === overlay.parentElement) {
                                    if (id === 'modalCreateUser') closeCreateUserModal();
                                    if (id === 'modalEditUser') closeEditUserModal();
                                }
                            });
                        }
                    }
                });

            });
        </script>
    @endpush

</x-app-layout>
