@php
    $editAction = old('_modal') === 'edit' && old('edit_id')
        ? route('users.update', old('edit_id'))
        : '';
@endphp

<div id="modalEditUser" class="fixed inset-0 z-50 hidden overflow-y-auto">

    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeEditUserModal()"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6 relative">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Edit User</h2>
                <button onclick="closeEditUserModal()" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
            </div>

            <form id="editUserForm" action="{{ $editAction }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="_modal" value="edit">
                {{-- edit_id → dibaca old('edit_id') di JS --}}
                <input type="hidden" name="edit_id" id="edit_user_id" value="{{ old('edit_id') }}">

                <div class="space-y-4">

                    {{-- Nama --}}
                    <div>
                        <label for="edit_name" class="mb-1 block text-sm font-medium text-gray-700">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="edit_name"
                            name="name"
                            value="{{ old('_modal') === 'edit' ? old('name') : '' }}"
                            placeholder="Masukkan nama"
                            autocomplete="off"
                            class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500
                            {{ $errors->has('name') && old('_modal') === 'edit' ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @if ($errors->has('name') && old('_modal') === 'edit')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="edit_email" class="mb-1 block text-sm font-medium text-gray-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                            id="edit_email"
                            name="email"
                            value="{{ old('_modal') === 'edit' ? old('email') : '' }}"
                            placeholder="contoh@sekolah.sch.id"
                            autocomplete="off"
                            class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500
                            {{ $errors->has('email') && old('_modal') === 'edit' ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @if ($errors->has('email') && old('_modal') === 'edit')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="edit_password" class="mb-1 block text-sm font-medium text-gray-700">
                            Password <span class="text-gray-400 text-xs">(opsional)</span>
                        </label>
                        <input type="password"
                            id="edit_password"
                            name="password"
                            placeholder="Kosongkan jika tidak diubah"
                            autocomplete="new-password"
                            class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500
                            {{ $errors->has('password') && old('_modal') === 'edit' ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @if ($errors->has('password') && old('_modal') === 'edit')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="edit_role" class="mb-1 block text-sm font-medium text-gray-700">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="edit_role" name="role"
                            class="w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500
                            {{ $errors->has('role') && old('_modal') === 'edit' ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            <option value="">-- Pilih Role --</option>
                            <option value="super_admin"
                                {{ old('_modal') === 'edit' && old('role') === 'super_admin' ? 'selected' : '' }}>
                                Super Admin
                            </option>
                            <option value="admin"
                                {{ old('_modal') === 'edit' && old('role') === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>
                        @if ($errors->has('role') && old('_modal') === 'edit')
                            <p class="mt-1 text-xs text-red-600">{{ $errors->first('role') }}</p>
                        @endif
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeEditUserModal()"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm shadow">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>