<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>

            <div>
                <h2 class="font-bold text-[15px] text-gray-800 tracking-wide leading-none">
                    Kelola Soal Kuis
                </h2>
                <p class="text-[11px] text-gray-400 mt-0.5 uppercase tracking-widest">
                    Konten & Evaluasi
                </p>
            </div>
        </div>
    </x-slot>

    <x-slot name="breadcrumb">
        <a href="{{ route('dashboard') }}" class="text-amber-600 hover:text-amber-700 transition">Dashboard</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('kuis.index') }}" class="text-amber-600 hover:text-amber-700 transition">Kuis</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('kuis.show', $kuis) }}" class="text-amber-600 hover:text-amber-700 transition">Detail</a>
        <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 font-semibold">Kelola Soal</span>
    </x-slot>

    <div class="py-7 bg-gray-50 min-h-screen" x-data="{ showCreateModal: false, showEditModal: false, editData: {} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                
                @if(session('success'))
                    <div class="flex items-center justify-between px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center justify-between px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Kuis Info -->
                <div class="mb-6 p-4 bg-amber-50 rounded-lg border border-amber-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">{{ $kuis->judul }}</h3>
                            <div class="text-sm text-gray-600 mt-1">
                                {{ $kuis->GuruMapel?->Mapel?->nama_mapel ?? '-' }} • {{ $kuis->durasi }} menit • Nilai Maks: {{ number_format($kuis->nilai_maksimal, 1) }}
                            </div>
                        </div>
                        <div>
                            @if($kuis->status === 'draft')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700">Draft</span>
                            @elseif($kuis->status === 'published')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-emerald-100 text-emerald-700">Published</span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-700">Closed</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($sudahDikerjakan)
                    <div class="flex items-start gap-2 p-4 mb-4 text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-xl">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <strong>Peringatan:</strong> Kuis ini sudah dikerjakan oleh siswa. Soal tidak dapat diubah atau dihapus.
                        </div>
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('kuis.show', $kuis) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-lg inline-flex items-center gap-2 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Detail Kuis
                    </a>
                    @if(!$sudahDikerjakan)
                        <button @click="showCreateModal = true" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 px-4 rounded-lg inline-flex items-center gap-2 shadow-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Soal
                        </button>
                    @endif
                </div>
                
                <div class="space-y-4">
                    @forelse($soalList as $soal)
                    <div class="border border-gray-100 rounded-xl p-5 hover:shadow-md hover:border-amber-200 transition-all bg-white">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center font-bold text-amber-700">
                                {{ $soal->nomor_soal }}
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 mb-3 text-sm">{{ $soal->pertanyaan }}</div>
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <div class="flex items-start gap-2 p-2 bg-gray-50 rounded-lg">
                                        <span class="font-bold text-gray-700 flex-shrink-0">A.</span>
                                        <span class="text-gray-600">{{ $soal->pilihan_a }}</span>
                                    </div>
                                    <div class="flex items-start gap-2 p-2 bg-gray-50 rounded-lg">
                                        <span class="font-bold text-gray-700 flex-shrink-0">B.</span>
                                        <span class="text-gray-600">{{ $soal->pilihan_b }}</span>
                                    </div>
                                    <div class="flex items-start gap-2 p-2 bg-gray-50 rounded-lg">
                                        <span class="font-bold text-gray-700 flex-shrink-0">C.</span>
                                        <span class="text-gray-600">{{ $soal->pilihan_c }}</span>
                                    </div>
                                    <div class="flex items-start gap-2 p-2 bg-gray-50 rounded-lg">
                                        <span class="font-bold text-gray-700 flex-shrink-0">D.</span>
                                        <span class="text-gray-600">{{ $soal->pilihan_d }}</span>
                                    </div>
                                </div>
                                <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-bold">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Kunci Jawaban: {{ $soal->kunci_jawaban }}
                                </div>
                            </div>
                            @if(!$sudahDikerjakan)
                            <div class="flex-shrink-0 flex items-center gap-2">
                                <button 
                                    @click="editData = {{ json_encode($soal) }}; showEditModal = true"
                                    class="w-8 h-8 flex items-center justify-center bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 rounded-lg transition"
                                    title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('soal_kuis.destroy', [$kuis, $soal]) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                        class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 border border-red-200 rounded-lg transition" 
                                        onclick="return confirm('Hapus soal ini? Penomoran akan diperbarui otomatis.')"
                                        title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16 text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <div class="font-semibold text-gray-500 mb-1">Belum ada soal</div>
                        <div class="text-sm">Klik tombol "Tambah Soal" untuk membuat soal pertama</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        @include('soal_kuis.modal-create')
        @include('soal_kuis.modal-edit')
    </div>
</x-app-layout>
