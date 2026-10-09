<template>
    <Head title="Dashboard" />
    
    <DashboardLayout>
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Spare Part</h1>
                <h2 class="text-xl text-[#312e81] font-medium mt-1">IT DAOP 5 PWT</h2>
                <p class="text-gray-500 text-sm mt-1">Metrik inventaris real-time dan peringatan stok</p>
            </div>
            
            <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-hide w-full md:w-auto" v-if="$page.props.auth?.user">
                <Link href="/inventory?action=add" class="flex-shrink-0 px-5 py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-sm font-semibold rounded-xl shadow-sm transition-colors flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Barang
                </Link>
                <Link href="/stock-movement?action=add" class="flex-shrink-0 px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-[#1e1b4b] text-sm font-semibold rounded-xl shadow-sm transition-colors flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    Pergerakan Stok
                </Link>

                <button @click="toggleFocusMode" class="flex-shrink-0 px-5 py-2.5 bg-indigo-50 border border-indigo-100 hover:bg-indigo-100 text-[#312e81] text-sm font-semibold rounded-xl shadow-sm transition-colors flex items-center gap-2 whitespace-nowrap hidden sm:flex">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l5-5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                    Fokus Mode
                </button>
                
                <!-- Export Button Trigger -->
                <button @click="openExportModal" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-[#1e1b4b] text-sm font-semibold rounded-xl shadow-sm transition-colors flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Ekspor Laporan
                </button>
            </div>
        </div>

        <!-- MODAL EKSPOR LAPORAN (LUAS & KOMPREHENSIF) -->
        <div v-if="exportModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm overflow-y-auto animate-in fade-in duration-200">
            <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden border border-gray-100 my-8 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="px-6 py-5 bg-[#1e1b4b] text-white flex justify-between items-center flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-white/10 rounded-xl text-indigo-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-white">Ekspor Laporan Sistem Inventaris</h3>
                            <p class="text-xs text-indigo-200">PT Kereta Api Indonesia (Persero) DAOP 5 Purwokerto</p>
                        </div>
                    </div>
                    <button @click="closeExportModal" class="p-1.5 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto flex-1 space-y-6">
                    <!-- Ringkasan Isi Laporan -->
                    <div class="bg-indigo-50/60 border border-indigo-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-indigo-100 text-indigo-700 rounded-lg shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="text-xs text-gray-600 leading-relaxed">
                                <span class="font-bold text-gray-800 text-sm block mb-1">Cakupan Data Dokumen:</span>
                                Laporan ini berisi rekapan gabungan resmi: <strong class="text-gray-900">Data Master Inventaris Spare Part</strong>, <strong class="text-gray-900">Riwayat Pergerakan Stok (Masuk & Keluar)</strong>, serta <strong class="text-gray-900">Rekapitulasi Kategori dan Lokasi</strong>.
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Format Ekspor -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Pilih Format Laporan</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- Opsi PDF -->
                            <div
                                @click="selectedFormat = 'pdf'"
                                :class="[
                                    'cursor-pointer rounded-xl p-4 border-2 transition-all flex flex-col justify-between relative',
                                    selectedFormat === 'pdf'
                                        ? 'border-red-500 bg-red-50/40 shadow-sm'
                                        : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'
                                ]"
                            >
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9.5 8.5c0 .83-.67 1.5-1.5 1.5H7v2H5.5V9H8c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V9H13c.83 0 1.5.67 1.5 1.5v3zm4-3H17v1h1.5V13H17v2h-1.5V9h3v1.5zm-10-1H7v1.5h1V10.5zm4.5 0h-1v2.5h1c.28 0 .5-.22.5-.5v-1.5c0-.28-.22-.5-.5-.5z"/></svg>
                                    </div>
                                    <span v-if="selectedFormat === 'pdf'" class="w-5 h-5 rounded-full bg-red-500 text-white flex items-center justify-center text-xs">
                                        ✓
                                    </span>
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-gray-900">Dokumen PDF</div>
                                    <div class="text-[11px] text-gray-500 mt-1 leading-snug">Siap cetak & tanda tangan dengan kop surat resmi.</div>
                                </div>
                            </div>

                            <!-- Opsi Excel -->
                            <div
                                @click="selectedFormat = 'xlsx'"
                                :class="[
                                    'cursor-pointer rounded-xl p-4 border-2 transition-all flex flex-col justify-between relative',
                                    selectedFormat === 'xlsx'
                                        ? 'border-emerald-600 bg-emerald-50/40 shadow-sm'
                                        : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'
                                ]"
                            >
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9.5 16.5l-1.5-3.5-1.5 3.5H5l2.5-5L5 6.5h1.5l1.5 3.5 1.5-3.5H11l-2.5 5 2.5 5h-1.5zm8.5 0h-5V6.5h1.5V15H18v1.5z"/></svg>
                                    </div>
                                    <span v-if="selectedFormat === 'xlsx'" class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs">
                                        ✓
                                    </span>
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-gray-900">Excel (.xlsx)</div>
                                    <div class="text-[11px] text-gray-500 mt-1 leading-snug">Format spreadsheet lengkap untuk analisis data.</div>
                                </div>
                            </div>

                            <!-- Opsi CSV -->
                            <div
                                @click="selectedFormat = 'csv'"
                                :class="[
                                    'cursor-pointer rounded-xl p-4 border-2 transition-all flex flex-col justify-between relative',
                                    selectedFormat === 'csv'
                                        ? 'border-blue-600 bg-blue-50/40 shadow-sm'
                                        : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'
                                ]"
                            >
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </div>
                                    <span v-if="selectedFormat === 'csv'" class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs">
                                        ✓
                                    </span>
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-gray-900">File CSV (.csv)</div>
                                    <div class="text-[11px] text-gray-500 mt-1 leading-snug">Data mentah tabular terpisah koma.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metadata Laporan -->
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 text-xs text-gray-600 grid grid-cols-2 gap-3">
                        <div>
                            <span class="text-gray-400 block text-[10px] uppercase font-bold">Total Unit Barang</span>
                            <span class="font-bold text-gray-900 text-sm">{{ totalSpareParts }} Unit</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px] uppercase font-bold">Pengunduh</span>
                            <span class="font-medium text-gray-900">{{ $page.props.auth?.user?.name || 'Administrator' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between flex-shrink-0">
                    <button
                        @click="closeExportModal"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-200 rounded-xl transition-colors"
                    >
                        Tutup
                    </button>
                    <button
                        @click="downloadExport(selectedFormat)"
                        class="px-6 py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-sm font-semibold rounded-xl shadow transition-colors flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh Laporan ({{ selectedFormat.toUpperCase() }})
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Summary Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-50 text-[#312e81] rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Spare Part</div>
                            <div class="text-xs text-gray-400">Total Unit Terdaftar</div>
                        </div>
                    </div>
                    <div class="px-2.5 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        {{ growthPercentage }}%
                    </div>
                </div>

                <div class="mt-6 mb-8">
                    <div class="text-5xl font-black text-gray-900 tracking-tight">{{ totalSpareParts }} <span class="text-xl font-bold text-gray-500">Unit</span></div>
                </div>

                <div>
                    <div class="text-xs font-semibold text-gray-600 mb-2">Kesiapan Operasional</div>
                    <div class="w-full bg-gray-100 rounded-full h-2 mb-3 flex overflow-hidden">
                        <div class="bg-emerald-500 h-2" :style="{ width: normalPercentage + '%' }"></div>
                        <div class="bg-yellow-400 h-2" :style="{ width: repairPercentage + '%' }"></div>
                        <div class="bg-red-500 h-2" :style="{ width: brokenPercentage + '%' }"></div>
                    </div>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs">
                        <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span><span class="font-bold text-gray-700">{{ normalPercentage }}%</span><span class="text-emerald-600 font-medium">Normal</span></div>
                        <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-yellow-400"></span><span class="font-bold text-gray-700">{{ repairPercentage }}%</span><span class="text-yellow-600 font-medium">Perbaikan</span></div>
                        <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-500"></span><span class="font-bold text-gray-700">{{ brokenPercentage }}%</span><span class="text-red-600 font-medium">Rusak</span></div>
                    </div>
                </div>
            </div>

            <!-- Conditions & Alerts Column -->
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Condition Cards -->
                <div class="flex flex-col gap-4">
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-start justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex flex-col items-center gap-1 flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center">
                                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                </div>
                                <span class="text-emerald-600 font-bold text-[11px]">{{ normalPercentage }}%</span>
                            </div>
                            <div class="mt-1">
                                <div class="font-black text-gray-900 text-lg leading-tight uppercase max-w-[100px]">KONDISI NORMAL</div>
                                <div class="text-sm text-gray-500 mt-1">Berfungsi Normal</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 mt-1">
                            <div class="text-left">
                                <div class="text-2xl font-black text-gray-900 leading-none">{{ normalCount }}</div>
                                <div class="text-sm font-bold text-gray-500 mt-1.5">Unit</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-start justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex flex-col items-center gap-1 flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center">
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                </div>
                                <span class="text-yellow-600 font-bold text-[11px]">{{ repairPercentage }}%</span>
                            </div>
                            <div class="mt-1">
                                <div class="font-black text-gray-900 text-lg leading-tight uppercase max-w-[120px]">BUTUH PERBAIKAN</div>
                                <div class="text-sm text-gray-500 mt-1">Dalam Pemeliharaan</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 mt-1">
                            <div class="text-left">
                                <div class="text-2xl font-black text-gray-900 leading-none">{{ repairCount }}</div>
                                <div class="text-sm font-bold text-gray-500 mt-1.5">Unit</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-start justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex flex-col items-center gap-1 flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                </div>
                                <span class="text-red-600 font-bold text-[11px]">{{ brokenPercentage }}%</span>
                            </div>
                            <div class="mt-1">
                                <div class="font-black text-gray-900 text-lg leading-tight uppercase">KONDISI RUSAK</div>
                                <div class="text-sm text-gray-500 mt-1">Perlu Penggantian / Buang</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 mt-1">
                            <div class="text-left">
                                <div class="text-2xl font-black text-gray-900 leading-none">{{ brokenCount }}</div>
                                <div class="text-sm font-bold text-gray-500 mt-1.5">Unit</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Cards -->
                <div class="flex flex-col gap-4">
                    <div class="bg-orange-50/50 rounded-2xl p-6 shadow-sm border border-orange-100 flex-1 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-100 rounded-full opacity-50 blur-xl"></div>
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span class="font-bold text-gray-900 text-sm">STOK MENIPIS</span>
                            </div>
                            <span class="px-2 py-1 bg-orange-100 text-orange-700 text-[10px] font-bold rounded">PERINGATAN</span>
                        </div>
                        <div class="text-3xl font-black text-gray-900 relative z-10">{{ menipisCount }} <span class="text-sm font-semibold text-gray-500">Merek/Tipe Barang</span></div>
                        <div class="text-xs text-orange-600 font-medium mt-1 relative z-10">Mendekati batas minimum buffer</div>
                    </div>

                    <div class="bg-red-50/50 rounded-2xl p-6 shadow-sm border border-red-100 flex-1 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-100 rounded-full opacity-50 blur-xl"></div>
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-bold text-gray-900 text-sm">STOK HABIS</span>
                            </div>
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded">KRITIS</span>
                        </div>
                        <div class="text-3xl font-black text-gray-900 relative z-10">{{ habisCount }} <span class="text-sm font-semibold text-gray-500">Merek/Tipe Barang</span></div>
                        <div class="text-xs text-red-600 font-medium mt-1 relative z-10">Stok habis, segera lakukan PO</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle Row: Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <!-- Line Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-900 text-base">Pergerakan Stok</h3>
                    <div class="flex items-center gap-4">
                        <select v-model="selectedPeriod" @change="fetchChartData" class="text-xs border-gray-200 rounded-lg text-gray-600 px-3 py-1.5 focus:ring-[#312e81] focus:border-[#312e81]">
                            <option value="minggu_ini">Minggu Ini</option>
                            <option value="minggu_lalu">Minggu Lalu</option>
                            <option value="bulan_ini">Bulan Ini</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-6 mb-2 mr-4 text-xs font-semibold">
                    <div class="flex items-center gap-2 text-[#312e81]">
                        <span class="w-3 h-3 rounded-full bg-[#312e81]"></span>
                        Stok Masuk
                    </div>
                    <div class="flex items-center gap-2 text-orange-500">
                        <span class="w-3 h-3 rounded-full border-2 border-orange-500"></span>
                        Stok Keluar
                    </div>
                </div>
                <div class="flex-1 mt-2">
                    <StockChart :chartData="chartData" />
                </div>
            </div>

            <!-- Donut Chart -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-900 text-base">Inventaris per Kategori</h3>
                    <span class="text-xs text-gray-500">Total {{ totalSpareParts }} pcs</span>
                </div>
                
                <div class="flex-1 flex flex-col justify-center gap-8">
                    <CategoryChart :categoriesData="categoriesData" />
                    
                    <div class="flex flex-col gap-3 max-h-[220px] overflow-y-auto pr-1 scrollbar-thin">
                        <div v-for="(cat, i) in categoriesData" :key="cat.name" class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full flex-shrink-0" :style="{ backgroundColor: getCategoryColor(i) }"></span>
                                <span class="text-gray-600 truncate max-w-[120px]" :title="cat.name">{{ cat.name }}</span>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <div class="font-bold text-gray-900">{{ cat.count }} <span class="font-normal text-gray-500 text-xs">pcs</span></div>
                                <div class="text-gray-400 text-xs">{{ cat.percentage }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row: Activity & Alerts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <h3 class="font-bold text-gray-900 text-base">Aktivitas Terkini</h3>
                    <div class="relative" v-if="['admin', 'super_admin'].includes($page.props.auth?.user?.role)">
                        <button @click="isActivityMenuOpen = !isActivityMenuOpen" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-md hover:bg-gray-50 focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                        
                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <div v-show="isActivityMenuOpen" class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-[100]">
                                <button @click="filterActivityByPeriod('')" class="w-full text-left px-4 py-2 text-sm" :class="activityPeriod === '' ? 'text-[#312e81] font-bold bg-[#eceef9]' : 'text-gray-700 hover:bg-gray-50'">Semua Waktu</button>
                                <button @click="filterActivityByPeriod('hari_ini')" class="w-full text-left px-4 py-2 text-sm" :class="activityPeriod === 'hari_ini' ? 'text-[#312e81] font-bold bg-[#eceef9]' : 'text-gray-700 hover:bg-gray-50'">Hari Ini</button>
                                <button @click="filterActivityByPeriod('minggu_ini')" class="w-full text-left px-4 py-2 text-sm" :class="activityPeriod === 'minggu_ini' ? 'text-[#312e81] font-bold bg-[#eceef9]' : 'text-gray-700 hover:bg-gray-50'">Minggu Ini</button>
                                <button @click="filterActivityByPeriod('bulan_ini')" class="w-full text-left px-4 py-2 text-sm" :class="activityPeriod === 'bulan_ini' ? 'text-[#312e81] font-bold bg-[#eceef9]' : 'text-gray-700 hover:bg-gray-50'">Bulan Ini</button>
                            </div>
                        </transition>
                    </div>
                </div>
                
                <div v-if="!['admin', 'super_admin'].includes($page.props.auth?.user?.role)" class="py-12 flex flex-col items-center justify-center text-gray-400 w-full min-h-[200px]">
                    <svg class="w-10 h-10 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <p class="text-sm font-medium">Aktivitas disembunyikan</p>
                    <p class="text-xs mt-1 text-center max-w-[200px]">Anda tidak memiliki hak akses untuk melihat data ini.</p>
                </div>
                <div v-else-if="activities.length > 0" class="max-h-[400px] overflow-y-auto scrollbar-thin pr-4 pl-2 pt-2 pb-2">
                    <div class="relative border-l-2 border-gray-100 ml-2 space-y-8 pb-4">
                        <!-- Activity Item -->
                        <div v-for="activity in activities" :key="activity.id" class="relative pl-6">
                            <div :class="['absolute -left-[9px] top-1 w-4 h-4 rounded-full border-4 border-white', dotColorClass(activity.action)]"></div>
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">{{ relativeActivityTime(activity.created_at) }}</div>
                                    <div class="text-sm text-gray-800 leading-relaxed">{{ activity.description }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">
                                        {{ activity.category?.name || 'Tanpa kategori' }} · oleh {{ activity.user_name }}
                                    </div>
                                </div>
                                <span :class="['px-2 py-1 text-[10px] font-bold rounded flex-shrink-0', badgeClass(activity.action)]">{{ actionLabel(activity.action) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="py-12 flex flex-col items-center justify-center text-gray-400 w-full min-h-[200px]">
                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-medium">Belum ada aktivitas</p>
                </div>
            </div>

            <!-- Action Required -->
            <div class="bg-white rounded-2xl shadow-sm border border-orange-200 overflow-hidden flex flex-col">
                <div class="bg-orange-50/50 p-4 border-b border-orange-100 flex items-center justify-between">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="flex items-center gap-2 text-orange-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <h3 class="font-bold text-sm">Tindakan Diperlukan</h3>
                        </div>
                        <div class="relative flex-1 max-w-[200px] hidden sm:block">
                            <input v-model="searchAction" type="text" placeholder="Cari peringatan..." class="w-full bg-white/70 border border-orange-200/60 focus:border-orange-400 focus:ring-1 focus:ring-orange-400 rounded-lg px-3 py-1.5 text-xs text-gray-700 outline-none transition-all placeholder-gray-400">
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-white border border-orange-200 text-orange-600 text-xs font-bold rounded shadow-sm">{{ actionRequiredItems.length }} PERINGATAN</span>
                </div>
                
                <div class="divide-y divide-gray-100 flex-1 max-h-[400px] overflow-y-auto scrollbar-thin">
                    <div class="p-3 bg-gray-50 border-b border-gray-100 sm:hidden">
                        <input v-model="searchAction" type="text" placeholder="Cari peringatan..." class="w-full bg-white border border-gray-200 focus:border-orange-400 focus:ring-1 focus:ring-orange-400 rounded-lg px-3 py-1.5 text-xs text-gray-700 outline-none transition-all placeholder-gray-400">
                    </div>
                    
                    <div v-for="(item, idx) in filteredActionRequiredItems" :key="idx" class="p-4 hover:bg-gray-50 transition-colors flex items-start justify-between">
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-gray-600 uppercase tracking-wide mb-0.5">{{ item.category }}</div>
                            <div class="font-bold text-gray-900 text-sm truncate">{{ item.name }}</div>
                            <div class="text-xs font-medium text-gray-600 mt-1.5">
                                Stok: <span :class="item.status === 'Habis' ? 'text-red-600' : (item.status === 'Menipis' ? 'text-orange-600' : 'text-yellow-600')">{{ item.qty }}</span> unit
                            </div>
                        </div>
                        <span :class="['px-2 py-0.5 text-[10px] font-bold rounded flex-shrink-0', item.status === 'Habis' ? 'bg-red-50 text-red-600' : (item.status === 'Menipis' ? 'bg-orange-50 text-orange-600' : 'bg-yellow-50 text-yellow-600')]">{{ item.status }}</span>
                    </div>

                    <div v-if="filteredActionRequiredItems.length === 0" class="p-8 flex flex-col items-center text-gray-400">
                        <svg v-if="searchAction" class="w-10 h-10 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <svg v-else class="w-10 h-10 mb-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm font-medium">{{ searchAction ? 'Peringatan tidak ditemukan' : 'Tidak ada peringatan' }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ searchAction ? 'Coba ubah kata kunci pencarian' : 'Semua stok dalam kondisi baik' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </DashboardLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import StockChart from '@/Components/StockChart.vue';
import CategoryChart from '@/Components/CategoryChart.vue';
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    totalSpareParts: {
        type: Number,
        default: 0
    },
    normalCount: {
        type: Number,
        default: 0
    },
    repairCount: {
        type: Number,
        default: 0
    },
    brokenCount: {
        type: Number,
        default: 0
    },
    menipisCount: {
        type: Number,
        default: 0
    },
    habisCount: {
        type: Number,
        default: 0
    },
    categoriesData: {
        type: Array,
        default: () => []
    },
    growthPercentage: {
        type: Number,
        default: 0
    },
    chartData: {
        type: Object,
        default: () => ({})
    },
    activities: {
        type: Array,
        default: () => []
    },
    allCategories: {
        type: Array,
        default: () => []
    },
    selectedActivityPeriod: {
        type: String,
        default: ''
    },
    actionRequiredItems: {
        type: Array,
        default: () => []
    },
    unreadNotificationCount: {
        type: Number,
        default: 0
    }
});

const selectedPeriod = ref(new URLSearchParams(window.location.search).get('period') || 'minggu_ini');

const fetchChartData = () => {
    const params = { period: selectedPeriod.value };
    if (activityPeriod.value) {
        params.activity_period = activityPeriod.value;
    }
    router.get('/', params, {
        preserveState: true,
        preserveScroll: true
    });
};

const searchAction = ref('');

const filteredActionRequiredItems = computed(() => {
    if (!props.actionRequiredItems) return [];
    if (!searchAction.value) return props.actionRequiredItems;
    
    const query = searchAction.value.toLowerCase();
    return props.actionRequiredItems.filter(item => {
        const text = `${item.name} ${item.category} ${item.status}`.toLowerCase();
        return text.includes(query);
    });
});

const activityPeriod = ref(new URLSearchParams(window.location.search).get('activity_period') || '');
const isActivityMenuOpen = ref(false);

const filterActivityByPeriod = (period) => {
    activityPeriod.value = period;
    isActivityMenuOpen.value = false;
    const params = { period: selectedPeriod.value };
    if (activityPeriod.value) {
        params.activity_period = activityPeriod.value;
    }
    router.get('/', params, {
        preserveState: true,
        preserveScroll: true
    });
};

const colors = ['#2e3192', '#5b5fc7', '#9499df', '#cfd2f1', '#e0e7ff', '#c7d2fe', '#818cf8', '#4f46e5'];
const getCategoryColor = (index) => {
    return colors[index % colors.length];
};

const getPercentage = (count) => {
    if (props.totalSpareParts === 0) return 0;
    return ((count / props.totalSpareParts) * 100).toFixed(1);
};

const normalPercentage = computed(() => getPercentage(props.normalCount));
const repairPercentage = computed(() => getPercentage(props.repairCount));
const brokenPercentage = computed(() => getPercentage(props.brokenCount));

// ===== EXPORT =====
const exportModalOpen = ref(false);
const selectedFormat = ref('pdf');

const openExportModal = () => {
    exportModalOpen.value = true;
};

const closeExportModal = () => {
    exportModalOpen.value = false;
};

const toggleFocusMode = () => {
    window.dispatchEvent(new Event('close-sidebar'));
    
    // Toggle full screen if supported
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(err => {
            console.log(`Error attempting to enable fullscreen: ${err.message}`);
        });
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        }
    }
};

const downloadExport = (format) => {
    window.location.href = `/export/${format}`;
    exportModalOpen.value = false;
};

// ===== ACTIVITY HELPERS =====
const dotColorClass = (action) => {
    const map = {
        created: 'bg-emerald-500',
        updated: 'bg-[#312e81]',
        deleted: 'bg-red-500',
        stock_in: 'bg-emerald-500',
        stock_out: 'bg-orange-500'
    };
    return map[action] || 'bg-gray-400';
};

const badgeClass = (action) => {
    const map = {
        created: 'bg-emerald-50 text-emerald-700',
        updated: 'bg-indigo-50 text-indigo-700',
        deleted: 'bg-red-50 text-red-700',
        stock_in: 'bg-emerald-50 text-emerald-700',
        stock_out: 'bg-orange-50 text-orange-700'
    };
    return map[action] || 'bg-gray-50 text-gray-600';
};

const actionLabel = (action) => {
    const map = {
        created: 'BARU',
        updated: 'PERBARUI',
        deleted: 'HAPUS',
        stock_in: 'MASUK',
        stock_out: 'KELUAR'
    };
    return map[action] || action;
};

const relativeActivityTime = (timestamp) => {
    const date = new Date(timestamp);
    const now = new Date();
    const diffMs = now - date;
    const diffMin = Math.floor(diffMs / 60000);
    const diffHour = Math.floor(diffMin / 60);
    const diffDay = Math.floor(diffHour / 24);

    if (diffMin < 1) return 'BARU SAJA';
    if (diffMin < 60) return `${diffMin} MENIT LALU`;
    if (diffHour < 24) return `${diffHour} JAM LALU`;
    if (diffDay === 1) return 'KEMARIN';
    if (diffDay < 7) return `${diffDay} HARI LALU`;
    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
};
</script>
