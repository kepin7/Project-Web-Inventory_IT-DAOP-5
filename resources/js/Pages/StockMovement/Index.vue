<template>
    <Head title="Pergerakan Stok" />
    
    <DashboardLayout>
        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-medium text-gray-800">Pergerakan Stok</h1>
                <p class="text-gray-400 text-sm mt-1">Lacak dan kelola alur keluar masuk barang inventaris</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="flex items-center bg-white border border-gray-200 shadow-sm rounded-lg px-2 shrink-0 focus-within:ring-1 focus-within:ring-[#312e81] focus-within:border-[#312e81]">
                    <input v-model="params.date_start" type="date" class="border-0 bg-transparent py-2.5 px-2 text-sm font-medium focus:ring-0 text-gray-700 outline-none w-[135px]" title="Dari Tanggal">
                    <span class="text-gray-400 font-medium mx-1">-</span>
                    <input v-model="params.date_end" type="date" class="border-0 bg-transparent py-2.5 px-2 text-sm font-medium focus:ring-0 text-gray-700 outline-none w-[135px]" title="Sampai Tanggal">
                </div>
                <button class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-[#1e1b4b] text-sm font-semibold rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export
                </button>
                <button @click="openAddModal" class="px-5 py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Pergerakan Baru
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Stock In -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 5L5 19m0 0V9m0 10h10" /></svg>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-400 mb-1 truncate" :title="periodLabel">Total Stok Masuk ({{ periodLabel }})</div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="text-3xl font-bold text-gray-900">{{ summary.in }} <span class="text-lg font-semibold text-gray-500">Trx</span></div>
                    <template v-if="summary.in + summary.out > 0">
                        <div class="flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-100/50 mt-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" /></svg>
                            {{ getPercentage(summary.in) }}%
                        </div>
                    </template>
                </div>
            </div>

            <!-- Stock Out -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 19L19 5m0 0v10m0-10H9" /></svg>
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-400 mb-1 truncate" :title="periodLabel">Total Stok Keluar ({{ periodLabel }})</div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="text-3xl font-bold text-gray-900">{{ summary.out }} <span class="text-lg font-semibold text-gray-500">Trx</span></div>
                    <template v-if="summary.in + summary.out > 0">
                        <div class="flex items-center gap-1 text-[11px] font-bold text-red-600 bg-red-50 px-2 py-1 rounded-md border border-red-100/50 mt-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5l15 15m0 0h-11.25m11.25 0V8.25" /></svg>
                            {{ getPercentage(summary.out) }}%
                        </div>
                    </template>
                </div>
            </div>

            <!-- Net Movement -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-center">
                <div class="text-sm font-medium text-gray-400 mb-1">Net Movement</div>
                <div class="text-3xl font-bold text-gray-900 mb-6">{{ summary.in + summary.out }} <span class="text-lg font-semibold text-gray-500">Trx</span></div>
                
                <div class="w-full h-3 flex rounded-full overflow-hidden bg-gray-100 mb-2">
                    <div class="bg-[#1e1b4b] h-full" :style="{ width: getPercentage(summary.in) + '%' }"></div>
                    <div class="bg-[#ff8b3d] h-full" :style="{ width: getPercentage(summary.out) + '%' }"></div>
                </div>
                <div class="flex justify-between text-xs font-bold uppercase">
                    <div class="text-[#1e1b4b]">IN ({{ getPercentage(summary.in) }}%)</div>
                    <div class="text-[#ff8b3d]">OUT ({{ getPercentage(summary.out) }}%)</div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse border-t border-indigo-100/50">
                    <thead>
                        <tr class="bg-indigo-50/30 text-gray-500 uppercase text-[11px] font-bold tracking-wider">
                            <th class="px-6 py-4 border-b border-indigo-100/50">TRANSACTION ID</th>
                            <th class="px-6 py-4 border-b border-indigo-100/50">PRODUCT</th>
                            <th class="px-6 py-4 border-b border-indigo-100/50 text-center">TYPE</th>
                            <th class="px-6 py-4 border-b border-indigo-100/50 text-center">QUANTITY</th>
                            <th class="px-6 py-4 border-b border-indigo-100/50">DATE</th>
                            <th class="px-6 py-4 border-b border-indigo-100/50">PIC</th>
                            <th class="px-6 py-4 border-b border-indigo-100/50">NOTES</th>
                            <th class="px-6 py-4 border-b border-indigo-100/50 text-right">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                        <tr v-for="tx in movements.data" :key="tx.transaction_id" class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-[#312e81]">
                                {{ tx.transaction_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                                <div v-if="tx.spare_part">
                                    {{ tx.spare_part.brand }} - {{ tx.spare_part.type }}
                                    <div v-if="tx.quantity > 1" class="text-xs font-normal text-gray-400 mt-0.5">(Multiple Items, View Details)</div>
                                </div>
                                <div v-else>-</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span v-if="tx.type === 'in'" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-[#eceef9] text-[#312e81]">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" style="transform: scale(-1, 1);"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                    Stock In
                                </span>
                                <span v-else class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-[#fff0e5] text-[#d97706]">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    Stock Out
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center font-bold">
                                <span v-if="tx.type === 'in'" class="text-[#312e81]">+{{ tx.quantity }}</span>
                                <span v-else class="text-[#d97706]">-{{ tx.quantity }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-[13px]">
                                {{ formatDate(tx.date) }}
                            </td>
                            <td class="px-6 py-4 text-[13px]">
                                {{ tx.pic_name || '-' }}
                            </td>
                            <td class="px-6 py-4 text-[13px] text-gray-500 max-w-[200px] truncate">
                                {{ tx.notes || '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button @click="viewDetails(tx.transaction_id)" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors" title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="!movements.data || movements.data.length === 0">
                            <td colspan="8" class="px-6 py-8 text-center text-gray-400">Tidak ada data pergerakan stok.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Mockup) -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                Menampilkan {{ movements.data.length }} data dari {{ movements.total }}
            </div>
        </div>

        <!-- MODAL ADD MOVEMENT -->
        <div v-if="isAddModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white rounded-2xl w-full max-w-2xl shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200 my-8">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-900">Buat Pergerakan Stok Baru</h3>
                    <button @click="closeAddModal" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form @submit.prevent="submitForm" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Tipe Pergerakan <span class="text-red-500">*</span></label>
                            <select v-model="form.type" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]">
                                <option value="in">Stock In (Masuk)</option>
                                <option value="out">Stock Out (Keluar)</option>
                            </select>
                            <div v-if="form.errors.type" class="text-red-500 text-xs mt-1">{{ form.errors.type }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Tanggal & Waktu <span class="text-red-500">*</span></label>
                            <input v-model="form.date" type="datetime-local" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" required>
                            <div v-if="form.errors.date" class="text-red-500 text-xs mt-1">{{ form.errors.date }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">PIC (Penanggung Jawab) <span class="text-red-500">*</span></label>
                            <input v-model="form.pic_name" type="text" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" placeholder="Nama PIC..." required>
                            <div v-if="form.errors.pic_name" class="text-red-500 text-xs mt-1">{{ form.errors.pic_name }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Kondisi Barang</label>
                            <select v-model="form.condition" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]">
                                <option value="">(Tidak Ada Perubahan Kondisi)</option>
                                <option value="Normal">Normal</option>
                                <option value="Perbaikan">Perbaikan</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                            Pilih Barang ({{ form.spare_part_ids.length }} Dipilih) <span class="text-red-500">*</span>
                        </label>
                        <input v-model="searchItem" type="text" placeholder="Cari berdasarkan nama atau SN..." class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mb-2 focus:ring-[#312e81] focus:border-[#312e81]">
                        
                        <div class="border border-gray-200 rounded-lg h-48 overflow-y-auto bg-gray-50/50 p-2 space-y-1">
                            <label v-for="item in filteredSpareParts" :key="item.id" class="flex items-start gap-3 p-2 hover:bg-white rounded border border-transparent hover:border-gray-200 cursor-pointer transition-colors">
                                <input type="checkbox" :value="item.id" v-model="form.spare_part_ids" class="mt-1 text-[#312e81] rounded focus:ring-[#312e81]">
                                <div>
                                    <div class="text-sm font-bold text-gray-800">{{ item.brand }} - {{ item.type }}</div>
                                    <div class="text-xs text-gray-500">SN: {{ item.serial_number || 'N/A' }} | INV: {{ item.inventory_number || 'N/A' }}</div>
                                </div>
                            </label>
                            <div v-if="filteredSpareParts.length === 0" class="text-center text-xs text-gray-400 py-4">Barang tidak ditemukan.</div>
                        </div>
                        <div v-if="form.errors.spare_part_ids" class="text-red-500 text-xs mt-1">Harap pilih minimal 1 barang.</div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Catatan</label>
                        <textarea v-model="form.notes" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" placeholder="Tambahkan catatan..."></textarea>
                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" @click="closeAddModal" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">Batal</button>
                        <button type="submit" :disabled="form.processing || form.spare_part_ids.length === 0" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#1e1b4b] hover:bg-[#312e81] disabled:opacity-50 rounded-lg transition-colors flex items-center justify-center min-w-[120px]">
                            <span v-if="form.processing" class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin mr-2"></span>
                            Simpan Pergerakan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL VIEW DETAILS -->
        <div v-if="isDetailsModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white rounded-2xl w-full max-w-3xl shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200 my-8">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">Detail Transaksi</h3>
                        <p class="text-xs text-gray-500">{{ currentTransactionId }}</p>
                    </div>
                    <button @click="isDetailsModalOpen = false" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <div v-if="loadingDetails" class="flex justify-center py-8">
                        <span class="w-8 h-8 border-4 border-[#312e81]/20 border-t-[#312e81] rounded-full animate-spin"></span>
                    </div>
                    
                    <div v-else>
                        <div class="bg-indigo-50/50 rounded-xl p-4 mb-6 flex gap-6 border border-indigo-100">
                            <div>
                                <div class="text-xs font-semibold text-gray-500">TIPE</div>
                                <div class="text-sm font-bold capitalize">{{ transactionDetails[0]?.type === 'in' ? 'Stock In' : 'Stock Out' }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500">PIC</div>
                                <div class="text-sm font-bold">{{ transactionDetails[0]?.pic_name }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500">KONDISI</div>
                                <div class="text-sm font-bold">{{ transactionDetails[0]?.condition || '-' }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gray-500">TANGGAL</div>
                                <div class="text-sm font-bold">{{ formatDate(transactionDetails[0]?.date) }}</div>
                            </div>
                        </div>

                        <h4 class="font-bold text-sm text-gray-800 mb-3">Daftar Barang ({{ transactionDetails.length }} Item)</h4>
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-xs text-gray-500">
                                    <tr>
                                        <th class="px-4 py-3 border-b">BRAND & TYPE</th>
                                        <th class="px-4 py-3 border-b">SERIAL NUMBER</th>
                                        <th class="px-4 py-3 border-b">INV NUMBER</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr v-for="det in transactionDetails" :key="det.id" class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-800">
                                            {{ det.spare_part?.brand }} - {{ det.spare_part?.type }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 font-mono text-xs">
                                            {{ det.spare_part?.serial_number || '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600 font-mono text-xs">
                                            {{ det.spare_part?.inventory_number || '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <button @click="isDetailsModalOpen = false" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#1e1b4b] hover:bg-[#312e81] rounded-lg transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </DashboardLayout>
</template>

<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { ref, watch, computed, onMounted } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    movements: Object,
    summary: Object,
    spare_parts: Array,
    filters: Object
});

const params = ref({
    date_start: props.filters?.date_start || '',
    date_end: props.filters?.date_end || ''
});

const periodLabel = computed(() => {
    if (params.value.date_start && params.value.date_end) {
        return `${formatDate(params.value.date_start)} - ${formatDate(params.value.date_end)}`;
    } else if (params.value.date_start) {
        return `Mulai ${formatDate(params.value.date_start)}`;
    } else if (params.value.date_end) {
        return `Sampai ${formatDate(params.value.date_end)}`;
    }
    return 'Semua Waktu';
});

// Custom simple debounce
let timeout = null;
const debounce = (fn, delay) => {
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            fn(...args);
        }, delay);
    };
};

watch(params, debounce(() => {
    const queryParams = {};
    for (const key in params.value) {
        if (params.value[key] !== '' && params.value[key] !== null) {
            queryParams[key] = params.value[key];
        }
    }

    router.get('/stock-movement', queryParams, {
        preserveState: true,
        replace: true,
        preserveScroll: true
    });
}, 300), { deep: true });

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('action') === 'add') {
        isAddModalOpen.value = true;
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});

const formatDate = (dateString) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute:'2-digit' });
};

const getPercentage = (count) => {
    const total = props.summary.in + props.summary.out;
    if (total === 0) return 0;
    return Math.round((count / total) * 100);
};

// Form Logic
const isAddModalOpen = ref(false);
const searchItem = ref('');

const form = useForm({
    type: 'in',
    date: new Date().toISOString().slice(0, 16),
    pic_name: '',
    condition: '',
    notes: '',
    spare_part_ids: []
});

const filteredSpareParts = computed(() => {
    if (!props.spare_parts) return [];
    const query = searchItem.value.toLowerCase();
    return props.spare_parts.filter(sp => {
        const text = `${sp.brand} ${sp.type} ${sp.serial_number} ${sp.inventory_number}`.toLowerCase();
        return text.includes(query);
    });
});

const openAddModal = () => {
    form.reset();
    form.date = new Date().toISOString().slice(0, 16);
    searchItem.value = '';
    isAddModalOpen.value = true;
};

const closeAddModal = () => {
    isAddModalOpen.value = false;
};

const submitForm = () => {
    form.post('/stock-movement', {
        onSuccess: () => {
            closeAddModal();
            Toast.fire({
                icon: 'success',
                title: 'Pergerakan stok berhasil dicatat'
            });
        },
        preserveScroll: true
    });
};

// View Details Logic
const isDetailsModalOpen = ref(false);
const currentTransactionId = ref('');
const transactionDetails = ref([]);
const loadingDetails = ref(false);

const viewDetails = async (transaction_id) => {
    currentTransactionId.value = transaction_id;
    isDetailsModalOpen.value = true;
    loadingDetails.value = true;
    
    try {
        const response = await fetch('/api/stock-movement/' + transaction_id);
        const data = await response.json();
        transactionDetails.value = data;
    } catch (error) {
        console.error("Error fetching details", error);
        Toast.fire({
            icon: 'error',
            title: 'Gagal memuat detail transaksi'
        });
        isDetailsModalOpen.value = false;
    } finally {
        loadingDetails.value = false;
    }
};

</script>
