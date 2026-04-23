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
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Detail Statistik</h3>
                    <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['bagian'] }}</div>
                            <div class="text-sm text-gray-600">Bagian</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['jurusan'] }}</div>
                            <div class="text-sm text-gray-600">Jurusan</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['semester'] }}</div>
                            <div class="text-sm text-gray-600">Semester</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['tahun_ajaran'] }}</div>
                            <div class="text-sm text-gray-600">Tahun Ajaran</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['tingkatan'] }}</div>
                            <div class="text-sm text-gray-600">Tingkatan</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['jam_belajar'] }}</div>
                            <div class="text-sm text-gray-600">Jam Belajar</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['pertemuan'] }}</div>
                            <div class="text-sm text-gray-600">Pertemuan</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['guru'] }}</div>
                            <div class="text-sm text-gray-600">Guru</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['kelas'] }}</div>
                            <div class="text-sm text-gray-600">Kelas</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['siswa'] }}</div>
                            <div class="text-sm text-gray-600">Siswa</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $counts['mapel'] }}</div>
                            <div class="text-sm text-gray-600">Mapel</div>
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
