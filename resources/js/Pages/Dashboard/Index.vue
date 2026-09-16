<template>
    <Head title="Dashboard" />
    
    <DashboardLayout>
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Spare Part</h1>
                <h2 class="text-xl text-[#312e81] font-medium mt-1">IT DAOP 5 PWT</h2>
                <p class="text-gray-500 text-sm mt-1">Metrik inventaris real-time dan peringatan stok</p>
            </div>
            
            <div class="flex items-center gap-3">
                <Link href="/inventory?action=add" class="px-5 py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-sm font-semibold rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Barang
                </Link>
                <Link href="/stock-movement?action=add" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-[#1e1b4b] text-sm font-semibold rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    Pergerakan Stok
                </Link>
                <button class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-[#1e1b4b] text-sm font-semibold rounded-xl shadow-sm transition-colors flex items-center gap-2 hidden md:flex">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Ekspor Laporan
                </button>
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
                                <div class="text-2xl font-black text-gray-900 leading-none">130</div>
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
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-900 text-base">Aktivitas Terkini</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                    </button>
                </div>
                
                <div class="relative border-l-2 border-gray-100 ml-3 space-y-8 pb-4">
                    <!-- Item 1 -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-orange-500 border-4 border-white"></div>
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">BARU SAJA</div>
                                <div class="text-sm text-gray-800"><span class="font-bold text-gray-900">PO-5591</span> diterima di Zona A.</div>
                                <div class="text-sm text-gray-500 mt-0.5">+250 unit ditambahkan</div>
                            </div>
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded">RESTOK</span>
                        </div>
                    </div>
                    
                    <!-- Item 2 -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-[#312e81] border-4 border-white"></div>
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">2 JAM LALU</div>
                                <div class="text-sm text-gray-800"><span class="font-bold text-gray-900">ORD-9924</span> diambil dan dikemas.</div>
                                <div class="text-sm text-gray-500 mt-0.5">Diproses oleh John D.</div>
                            </div>
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded">PEMENUHAN</span>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-emerald-500 border-4 border-white"></div>
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">KEMARIN</div>
                                <div class="text-sm text-gray-800">Penghitungan siklus selesai untuk <span class="font-bold text-gray-900">Zona C</span>.</div>
                                <div class="text-sm text-emerald-600 mt-0.5 font-medium">100% Cocok</div>
                            </div>
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded">AUDIT</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Required -->
            <div class="bg-white rounded-2xl shadow-sm border border-orange-200 overflow-hidden flex flex-col">
                <div class="bg-orange-50/50 p-4 border-b border-orange-100 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-orange-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <h3 class="font-bold text-sm">Tindakan Diperlukan</h3>
                    </div>
                    <span class="px-2 py-1 bg-white border border-orange-200 text-orange-600 text-xs font-bold rounded shadow-sm">3 PERINGATAN</span>
                </div>
                
                <div class="divide-y divide-gray-100 flex-1">
                    <!-- Alert 1 -->
                    <div class="p-4 hover:bg-gray-50 transition-colors flex flex-col gap-2">
                        <div class="flex items-start justify-between">
                            <div class="font-bold text-gray-900 text-sm">SKU-8921</div>
                            <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[10px] font-bold rounded">HABIS</span>
                        </div>
                        <div class="text-xs text-gray-500">Kursi Kantor Ergonomis - Jaring</div>
                        <div class="flex items-center justify-between mt-1">
                            <div class="text-xs font-medium text-gray-600">Stok: <span class="text-red-600">0</span></div>
                            <button class="text-orange-600 text-xs font-bold hover:underline">Pesan Ulang</button>
                        </div>
                    </div>

                    <!-- Alert 2 -->
                    <div class="p-4 hover:bg-gray-50 transition-colors flex flex-col gap-2">
                        <div class="flex items-start justify-between">
                            <div class="font-bold text-gray-900 text-sm">SKU-4402</div>
                            <span class="px-2 py-0.5 bg-yellow-50 text-yellow-600 text-[10px] font-bold rounded">MENIPIS</span>
                        </div>
                        <div class="text-xs text-gray-500">Dudukan Monitor 4K 27"</div>
                        <div class="flex items-center justify-between mt-1">
                            <div class="text-xs font-medium text-gray-600">Stok: <span class="text-yellow-600">12</span></div>
                            <button class="text-orange-600 text-xs font-bold hover:underline">Pesan Ulang</button>
                        </div>
                    </div>

                    <!-- Alert 3 -->
                    <div class="p-4 hover:bg-gray-50 transition-colors flex flex-col gap-2">
                        <div class="flex items-start justify-between">
                            <div class="font-bold text-gray-900 text-sm">SKU-1198</div>
                            <span class="px-2 py-0.5 bg-yellow-50 text-yellow-600 text-[10px] font-bold rounded">MENIPIS</span>
                        </div>
                        <div class="text-xs text-gray-500">Switch Keyboard Mekanikal (Cokelat)</div>
                        <div class="flex items-center justify-between mt-1">
                            <div class="text-xs font-medium text-gray-600">Stok: <span class="text-yellow-600">45</span></div>
                            <button class="text-orange-600 text-xs font-bold hover:underline">Pesan Ulang</button>
                        </div>
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
import { ref, computed } from 'vue';

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
    }
});

const selectedPeriod = ref(props.chartData?.period || 'minggu_ini');

const fetchChartData = () => {
    router.get('/', { period: selectedPeriod.value }, {
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
</script>
