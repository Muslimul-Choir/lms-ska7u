<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Statistics Cards -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Ringkasan Data</h3>
                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-2xl border border-gray-200 bg-gradient-to-br from-blue-50 to-blue-100 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-600">Total Pengguna</div>
                                    <div class="mt-2 text-3xl font-bold text-blue-900">{{ $counts['users'] }}</div>
                                </div>
                                <div class="p-3 bg-blue-200 rounded-full">
                                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gradient-to-br from-green-50 to-green-100 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-600">Total Guru & Siswa</div>
                                    <div class="mt-2 text-3xl font-bold text-green-900">{{ $counts['guru'] + $counts['siswa'] }}</div>
                                </div>
                                <div class="p-3 bg-green-200 rounded-full">
                                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gradient-to-br from-purple-50 to-purple-100 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-600">Total Kelas & Mapel</div>
                                    <div class="mt-2 text-3xl font-bold text-purple-900">{{ $counts['kelas'] + $counts['mapel'] }}</div>
                                </div>
                                <div class="p-3 bg-purple-200 rounded-full">
                                    <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gradient-to-br from-orange-50 to-orange-100 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-600">Aktivitas Belajar</div>
                                    <div class="mt-2 text-3xl font-bold text-orange-900">{{ $counts['materi'] + $counts['tugas'] }}</div>
                                </div>
                                <div class="p-3 bg-orange-200 rounded-full">
                                    <svg class="w-6 h-6 text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid gap-8 md:grid-cols-2">
                <!-- Pie Chart - Distribusi Data Utama -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Distribusi Data Utama</h3>
                        <div class="h-80">
                            <canvas id="mainDataChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart - Perbandingan Akademik -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Data Akademik</h3>
                        <div class="h-80">
                            <canvas id="academicChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bars Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Progress & Aktivitas</h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Pengumpulan Tugas</span>
                                    <span class="text-gray-900 font-medium">{{ $counts['pengumpulan_tugas'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full" style="width: {{ $counts['tugas'] > 0 ? min(($counts['pengumpulan_tugas'] / $counts['tugas']) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Penilaian Selesai</span>
                                    <span class="text-gray-900 font-medium">{{ $counts['penilaian'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full" style="width: {{ $counts['pengumpulan_tugas'] > 0 ? min(($counts['penilaian'] / $counts['pengumpulan_tugas']) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Kehadiran Siswa</span>
                                    <span class="text-gray-900 font-medium">{{ $counts['absensi'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-3 rounded-full" style="width: {{ $counts['siswa'] > 0 ? min(($counts['absensi'] / ($counts['siswa'] * 10)) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Guru Mapel</span>
                                    <span class="text-gray-900 font-medium">{{ $counts['guru_mapel'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-3 rounded-full" style="width: {{ $counts['guru'] > 0 ? min(($counts['guru_mapel'] / $counts['guru']) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Jadwal Belajar</span>
                                    <span class="text-gray-900 font-medium">{{ $counts['jadwal_belajar'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-red-500 to-red-600 h-3 rounded-full" style="width: {{ $counts['kelas'] > 0 ? min(($counts['jadwal_belajar'] / $counts['kelas']) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Materi Pembelajaran</span>
                                    <span class="text-gray-900 font-medium">{{ $counts['materi'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-3 rounded-full" style="width: {{ $counts['mapel'] > 0 ? min(($counts['materi'] / $counts['mapel']) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Statistics Grid -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Detail Statistik Lengkap
                    </h3>

                    <!-- Main Statistics Row -->
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-8">
                        <!-- Academic Structure -->
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-indigo-200 rounded-full">
                                    <svg class="w-6 h-6 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full">Struktur Akademik</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Jurusan</span>
                                    <span class="font-bold text-indigo-900">{{ $counts['jurusan'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Tingkatan</span>
                                    <span class="font-bold text-indigo-900">{{ $counts['tingkatan'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Kelas</span>
                                    <span class="font-bold text-indigo-900">{{ $counts['kelas'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Teaching Staff -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-green-200 rounded-full">
                                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">Tenaga Pengajar</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Guru</span>
                                    <span class="font-bold text-green-900">{{ $counts['guru'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Guru Mapel</span>
                                    <span class="font-bold text-green-900">{{ $counts['guru_mapel'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Mapel</span>
                                    <span class="font-bold text-green-900">{{ $counts['mapel'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Students -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-blue-200 rounded-full">
                                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">Peserta Didik</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Siswa</span>
                                    <span class="font-bold text-blue-900">{{ $counts['siswa'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Absensi</span>
                                    <span class="font-bold text-blue-900">{{ $counts['absensi'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Rasio Kelas</span>
                                    <span class="font-bold text-blue-900">{{ $counts['kelas'] > 0 ? round($counts['siswa'] / $counts['kelas']) : 0 }}:1</span>
                                </div>
                            </div>
                        </div>

                        <!-- Learning Activities -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-3 bg-purple-200 rounded-full">
                                    <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2 py-1 rounded-full">Aktivitas Belajar</span>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Materi</span>
                                    <span class="font-bold text-purple-900">{{ $counts['materi'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Tugas</span>
                                    <span class="font-bold text-purple-900">{{ $counts['tugas'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Pengumpulan</span>
                                    <span class="font-bold text-purple-900">{{ $counts['pengumpulan_tugas'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Statistics -->
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                        <!-- Time Management -->
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 border border-yellow-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="p-2 bg-yellow-200 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-yellow-700">Manajemen Waktu</div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Jam Belajar</span>
                                    <span class="font-semibold text-yellow-900">{{ $counts['jam_belajar'] }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Pertemuan</span>
                                    <span class="font-semibold text-yellow-900">{{ $counts['pertemuan'] }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Jadwal Belajar</span>
                                    <span class="font-semibold text-yellow-900">{{ $counts['jadwal_belajar'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Periods -->
                        <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-lg p-4 border border-cyan-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="p-2 bg-cyan-200 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-cyan-700">Periode Akademik</div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Semester</span>
                                    <span class="font-semibold text-cyan-900">{{ $counts['semester'] }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tahun Ajaran</span>
                                    <span class="font-semibold text-cyan-900">{{ $counts['tahun_ajaran'] }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Bagian</span>
                                    <span class="font-semibold text-cyan-900">{{ $counts['bagian'] }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Assessment & Evaluation -->
                        <div class="bg-gradient-to-br from-rose-50 to-rose-100 rounded-lg p-4 border border-rose-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="p-2 bg-rose-200 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-rose-700">Penilaian</div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Penilaian</span>
                                    <span class="font-semibold text-rose-900">{{ $counts['penilaian'] }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tugas Selesai</span>
                                    <span class="font-semibold text-rose-900">{{ $counts['pengumpulan_tugas'] }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Rasio Penilaian</span>
                                    <span class="font-semibold text-rose-900">{{ $counts['pengumpulan_tugas'] > 0 ? round(($counts['penilaian'] / $counts['pengumpulan_tugas']) * 100) : 0 }}%</span>
                                </div>
                            </div>
                        </div>

                        <!-- System Overview -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="p-2 bg-gray-200 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-gray-700">Ringkasan Sistem</div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Total Data</span>
                                    <span class="font-semibold text-gray-900">{{ array_sum($counts) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Kategori</span>
                                    <span class="font-semibold text-gray-900">{{ count($counts) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Aktif</span>
                                    <span class="font-semibold text-green-600">Online</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pie Chart - Distribusi Data Utama
            const mainDataCtx = document.getElementById('mainDataChart').getContext('2d');
            new Chart(mainDataCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pengguna', 'Guru', 'Siswa', 'Kelas', 'Mapel', 'Materi'],
                    datasets: [{
                        data: [
                            {{ $counts['users'] }},
                            {{ $counts['guru'] }},
                            {{ $counts['siswa'] }},
                            {{ $counts['kelas'] }},
                            {{ $counts['mapel'] }},
                            {{ $counts['materi'] }}
                        ],
                        backgroundColor: [
                            '#3B82F6', // blue
                            '#10B981', // green
                            '#F59E0B', // yellow
                            '#EF4444', // red
                            '#8B5CF6', // purple
                            '#06B6D4'  // cyan
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Bar Chart - Perbandingan Akademik
            const academicCtx = document.getElementById('academicChart').getContext('2d');
            new Chart(academicCtx, {
                type: 'bar',
                data: {
                    labels: ['Tugas', 'Pengumpulan', 'Penilaian', 'Absensi', 'Pertemuan'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [
                            {{ $counts['tugas'] }},
                            {{ $counts['pengumpulan_tugas'] }},
                            {{ $counts['penilaian'] }},
                            {{ $counts['absensi'] }},
                            {{ $counts['pertemuan'] }}
                        ],
                        backgroundColor: [
                            '#3B82F6',
                            '#10B981',
                            '#F59E0B',
                            '#EF4444',
                            '#8B5CF6'
                        ],
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
