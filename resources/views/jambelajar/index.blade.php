<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-[#1B3A6B] flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[15px] text-[#0F2145] tracking-wide uppercase leading-none">
                    Master Jam Belajar
                </h2>
                <p class="text-[11px] text-slate-400 mt-0.5 tracking-widest uppercase">Manajemen Data Jam Belajar</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-[#f0f4f8] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-slate-400 font-medium tracking-wide">
                <span class="text-[#1B3A6B]">Dashboard</span>
                <span class="text-slate-300">/</span>
                <span>Master Data</span>
                <span class="text-slate-300">/</span>
                <span class="text-slate-600 font-semibold">Jam Belajar</span>
            </nav>

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Card Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-[#0F2145]">Daftar Jam Belajar</h3>

                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Filter Tingkatan --}}
                        <form method="GET" action="{{ route('jambelajar.index') }}" class="flex items-center gap-2">
                            <div class="relative">
                                <select name="tingkatan"
                                        onchange="this.form.submit()"
                                        class="appearance-none pl-3 pr-8 py-2 text-xs font-medium border rounded-lg
                                               focus:outline-none focus:ring-2 focus:ring-[#1B3A6B]/30 focus:border-[#1B3A6B]
                                               transition cursor-pointer
                                               {{ $filterTingkatan ? 'border-[#1B3A6B] bg-[#1B3A6B]/5 text-[#1B3A6B]' : 'border-slate-200 bg-white text-slate-600' }}">
                                    <option value="">Semua Tingkatan</option>
                                    @foreach($tingkatanList as $tingkatan)
                                        <option value="{{ $tingkatan->id }}"
                                            {{ $filterTingkatan == $tingkatan->id ? 'selected' : '' }}>
                                            {{ $tingkatan->nama_tingkatan }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Reset filter --}}
                            @if($filterTingkatan)
                                <a href="{{ route('jambelajar.index') }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-2 text-xs font-medium
                                          bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg transition"
                                   title="Reset filter">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </form>

                        {{-- Trash --}}
                        <a href="{{ route('jambelajar.trash') }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-medium rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Trash
                        </a>

                        {{-- Tambah --}}
                        <button type="button" id="btnTambahJamBelajar"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#e05a2b] hover:bg-[#c94e22] text-white text-xs font-semibold rounded-lg transition shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Jam Belajar
                        </button>

                    </div>
                </div>

                {{-- Filter badge info --}}
                @if($filterTingkatan)
                    @php $namaTingkatanFilter = $tingkatanList->firstWhere('id', $filterTingkatan)?->nama_tingkatan; @endphp
                    <div class="px-6 py-2.5 bg-[#1B3A6B]/5 border-b border-[#1B3A6B]/10 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-[#1B3A6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                        </svg>
                        <span class="text-xs text-[#1B3A6B] font-medium">
                            Menampilkan tingkatan: <span class="font-bold">{{ $namaTingkatanFilter }}</span>
                        </span>
                    </div>
                @endif

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border-collapse">
                        <thead>
                            <tr class="border-b-2 border-[#e05a2b]">
                                <th class="px-6 py-3 text-left text-[13px] font-bold text-[#e05a2b] w-44 whitespace-nowrap">
                                    Tingkatan
                                </th>
                                @foreach($jamKe as $ke => $label)
                                    <th class="px-4 py-3 text-center text-[13px] font-bold text-[#e05a2b] whitespace-nowrap border-l border-slate-100">
                                        {{ $label }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($groupedJamBelajar as $tingkatanNama => $rowJams)
                                <tr class="border-b border-slate-100 hover:bg-slate-50/60 transition">

                                    {{-- Tingkatan --}}
                                    <td class="px-6 py-4 align-middle">
                                        <div class="text-xs text-slate-400 font-medium leading-none mb-1">({{ $tahunAktif }})</div>
                                        <div class="text-sm font-bold text-[#1e293b]">{{ $tingkatanNama }}</div>
                                    </td>

                                    {{-- Jam Cells --}}
                                    @foreach($jamKe as $ke => $label)
                                        <td class="px-4 py-3 text-center border-l border-slate-100 align-middle">
                                            @if(isset($rowJams[$ke]))
                                                @php $jam = $rowJams[$ke]; @endphp
                                                <div class="text-sm font-medium text-slate-700 mb-2">
                                                    {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}
                                                </div>
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button"
                                                        data-id="{{ $jam->id }}"
                                                        data-id_tingkatan="{{ $jam->id_tingkatan }}"
                                                        data-jam_mulai="{{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }}"
                                                        data-jam_selesai="{{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}"
                                                        class="btn-edit p-1.5 rounded-md hover:bg-green-50 text-green-500 hover:text-green-600 transition">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('jambelajar.destroy', $jam) }}" method="POST"
                                                          onsubmit="return confirm('Yakin ingin menghapus jam belajar ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-1.5 rounded-md hover:bg-red-50 text-red-500 hover:text-red-600 transition">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-slate-300 text-xs">—</span>
                                            @endif
                                        </td>
                                    @endforeach

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($jamKe) + 1 }}" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 text-sm font-medium">
                                                {{ $filterTingkatan ? 'Tidak ada jam belajar untuk tingkatan ini' : 'Belum ada data jam belajar' }}
                                            </p>
                                            <p class="text-slate-300 text-xs">
                                                {{ $filterTingkatan ? 'Coba pilih tingkatan lain atau reset filter' : 'Klik Tambah Jam Belajar untuk mulai menambahkan data' }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>{{-- end card --}}

        </div>
    </div>

    {{-- Modals --}}
    @include('jambelajar.modal-create')
    @include('jambelajar.modal-edit')

    <script>
        const modalCreate = document.getElementById('modalCreate');
        const modalEdit   = document.getElementById('modalEdit');

        document.getElementById('btnTambahJamBelajar').addEventListener('click', () => modalCreate.style.display = 'block');
        document.getElementById('closeCreate').addEventListener('click',   () => modalCreate.style.display = 'none');
        document.getElementById('cancelCreate').addEventListener('click',  () => modalCreate.style.display = 'none');
        document.getElementById('overlayCreate').addEventListener('click', () => modalCreate.style.display = 'none');

        document.getElementById('closeEdit').addEventListener('click',     () => modalEdit.style.display = 'none');
        document.getElementById('cancelEdit').addEventListener('click',    () => modalEdit.style.display = 'none');
        document.getElementById('overlayEdit').addEventListener('click',   () => modalEdit.style.display = 'none');

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('editIdTingkatan').value = this.dataset.id_tingkatan;
                document.getElementById('editJamMulai').value    = this.dataset.jam_mulai;
                document.getElementById('editJamSelesai').value  = this.dataset.jam_selesai;
                document.getElementById('formEdit').action       = `/jambelajar/${this.dataset.id}`;
                modalEdit.style.display = 'block';
            });
        });

        @if ($errors->any())
            modalCreate.style.display = 'block';
        @endif
    </script>

</x-app-layout>