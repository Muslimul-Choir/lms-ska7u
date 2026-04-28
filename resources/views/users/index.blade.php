<x-app-layout>
    {{-- Include Modal --}}
    @include('users.modal-create')
    @include('users.modal-edit')

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Manajemen Akun Super Admin & Admin
            </h2>

            <div class="flex gap-2">
                {{-- Trash --}}
                <a href="{{ route('users.trash') }}"
                    class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium">
                    🗑 Trash
                    @if ($trashCount > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ $trashCount }}
                        </span>
                    @endif
                </a>

                {{-- Tambah --}}
                <button onclick="openCreateUserModal()"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm">
                    + Tambah User
                </button>
            </div>
        </div>
    </x-slot>

    <div class="p-6">

        {{-- Alert --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        {{-- FILTER --}}
        <form method="GET" action="{{ route('users.index') }}" class="mb-4">
            <div class="flex flex-wrap gap-3 items-center">

                {{-- Search --}}
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                    class="border rounded-lg px-3 py-2 text-sm w-64">

                {{-- Role --}}
                <select name="role" class="border rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Role</option>
                    <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>
                        Super Admin
                    </option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>

                {{-- Submit --}}
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                    Filter
                </button>

                {{-- Reset --}}
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg text-sm">
                    Reset
                </a>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ ucwords(str_replace('_', ' ', $user->role)) }}</td>

                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">

                                    {{-- Edit --}}
                                    <button onclick="openEditUserModal(this)" data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}"
                                        class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">
                                        Edit
                                    </button>

                                    {{-- Delete --}}
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                Data tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>

    </div>

    {{-- Ganti bagian @push('scripts') di resources/views/users/index.blade.php --}}

    @push('scripts')
        <script>
            function openCreateUserModal() {
                document.getElementById('modalCreateUser').classList.remove('hidden');
            }

            function closeCreateUserModal() {
                document.getElementById('modalCreateUser').classList.add('hidden');
            }

            function openEditUserModal(button) {
                const modal = document.getElementById('modalEditUser');
                const u = button.dataset;

                document.getElementById('edit_user_id').value = u.id;
                document.getElementById('edit_name').value = u.name;
                document.getElementById('edit_email').value = u.email;
                document.getElementById('edit_role').value = u.role;

                document.getElementById('editUserForm').action = `/users/${u.id}`;

                modal.classList.remove('hidden');
            }

            function closeEditUserModal() {
                document.getElementById('modalEditUser').classList.add('hidden');
            }

            function openEditUserModalFromOld() {
                const modal = document.getElementById('modalEditUser');
                const form = document.getElementById('editUserForm');
                const id = "{{ old('edit_id') }}";

                document.getElementById('edit_user_id').value = id;
                document.getElementById('edit_name').value = "{{ old('name') }}";
                document.getElementById('edit_email').value = "{{ old('email') }}";
                document.getElementById('edit_role').value = "{{ old('role') }}";

                form.action = `/users/${id}`;

                modal.classList.remove('hidden');
            }

            document.addEventListener('DOMContentLoaded', function() {
                @if ($errors->any())
                    const modalType = @json(old('_modal'));

                    const handlers = {
                        create: () => openCreateUserModal(),
                        edit: () => openEditUserModalFromOld(),
                    };

                    if (handlers[modalType]) {
                        handlers[modalType]();
                    }
                @endif
            });
        </script>
    @endpush

</x-app-layout>
