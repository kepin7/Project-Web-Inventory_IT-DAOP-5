<template>
    <Head title="Manajemen Lokasi" />
    
    <DashboardLayout>
        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-medium text-gray-800">Lokasi Gudang</h1>
                <p class="text-gray-400 text-sm mt-1">Kelola dan pantau semua titik penyimpanan inventaris wilayah DAOP 5 Purwokerto.</p>
            </div>
            
            <div>
                <button @click="openAddModal" class="px-5 py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Lokasi Baru
                </button>
            </div>
        </div>

        <!-- Locations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <div v-for="location in locations" :key="location.id" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group flex flex-col justify-between">
                
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span v-if="location.status === 'aktif'" class="inline-flex px-2 py-1 rounded bg-[#dcfce7] text-[#166534] text-[10px] font-bold tracking-wide uppercase">
                            AKTIF
                        </span>
                        <span v-else class="inline-flex px-2 py-1 rounded bg-gray-100 text-gray-500 text-[10px] font-bold tracking-wide uppercase">
                            NON-AKTIF
                        </span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ location.name }}</h3>
                    <p class="text-xs text-gray-400 mb-6 line-clamp-2 min-h-[32px]">
                        {{ location.description || 'Tidak ada deskripsi' }}
                    </p>
                </div>
                
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between items-end pt-4 border-t border-gray-50">
                        <div>
                            <div class="text-[11px] font-medium text-gray-400 mb-1">Total Item</div>
                            <div class="text-sm font-bold text-gray-900">{{ location.spare_parts_count }} <span class="text-xs font-normal text-gray-400">Unit</span></div>
                        </div>
                        <div class="text-right">
                            <div class="text-[11px] font-medium text-gray-400 mb-1">Kapasitas Terpakai</div>
                            <div class="text-sm font-bold text-gray-900">
                                {{ location.capacity ? Math.round((location.spare_parts_count / location.capacity) * 100) : 0 }}%
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-2 pt-2">
                        <button @click="openEditModal(location)" class="px-3 py-1.5 text-xs font-semibold text-[#312e81] bg-indigo-50 hover:bg-indigo-100 rounded-md transition-colors">
                            Edit
                        </button>
                        <button @click="deleteLocation(location)" class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition-colors">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="!locations || locations.length === 0" class="col-span-full py-12 text-center text-gray-400">
                Tidak ada lokasi gudang ditemukan.
            </div>
        </div>

        <!-- MODAL FORM LOKASI -->
        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200 my-8">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-900">{{ isEditing ? 'Edit Lokasi' : 'Tambah Lokasi Baru' }}</h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form @submit.prevent="submitForm" class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lokasi <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" placeholder="Misal: Gudang IT Utama" required>
                            <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Status Lokasi</label>
                            <select v-model="form.status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]">
                                <option value="aktif">Aktif</option>
                                <option value="non-aktif">Non-Aktif</option>
                            </select>
                            <div v-if="form.errors.status" class="text-red-500 text-xs mt-1">{{ form.errors.status }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Kapasitas Maksimal (Opsional)</label>
                            <input v-model="form.capacity" type="number" min="0" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" placeholder="Kosongkan jika tidak terbatas">
                            <div v-if="form.errors.capacity" class="text-red-500 text-xs mt-1">{{ form.errors.capacity }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi</label>
                            <textarea v-model="form.description" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" placeholder="Tambahkan deskripsi detail lokasi..."></textarea>
                            <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" @click="closeModal" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#1e1b4b] hover:bg-[#312e81] rounded-lg transition-colors flex items-center justify-center min-w-[120px]">
                            <span v-if="form.processing" class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin mr-2"></span>
                            {{ isEditing ? 'Simpan Perubahan' : 'Tambah Lokasi' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </DashboardLayout>
</template>

<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { ref } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    locations: Array
});

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

// Modal Logic
const isModalOpen = ref(false);
const isEditing = ref(false);
const editId = ref(null);

const form = useForm({
    name: '',
    description: '',
    status: 'aktif',
    capacity: null
});

const openAddModal = () => {
    isEditing.value = false;
    editId.value = null;
    form.reset();
    form.clearErrors();
    isModalOpen.value = true;
};

const openEditModal = (loc) => {
    isEditing.value = true;
    editId.value = loc.id;
    form.name = loc.name;
    form.description = loc.description || '';
    form.status = loc.status || 'aktif';
    form.capacity = loc.capacity;
    form.clearErrors();
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => form.reset(), 200);
};

const submitForm = () => {
    if (isEditing.value) {
        form.put('/management/locations/' + editId.value, {
            onSuccess: () => {
                closeModal();
                Toast.fire({
                    icon: 'success',
                    title: 'Lokasi berhasil diperbarui'
                });
            },
            preserveScroll: true
        });
    } else {
        form.post('/management/locations', {
            onSuccess: () => {
                closeModal();
                Toast.fire({
                    icon: 'success',
                    title: 'Lokasi berhasil ditambahkan'
                });
            },
            preserveScroll: true
        });
    }
};

const deleteLocation = (loc) => {
    if (loc.spare_parts_count > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Lokasi ini tidak dapat dihapus karena masih memiliki barang terdaftar.',
            confirmButtonColor: '#312e81'
        });
        return;
    }
    
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Lokasi "${loc.name}" akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete('/management/locations/' + loc.id, {
                preserveScroll: true,
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Lokasi berhasil dihapus'
                    });
                }
            });
        }
    });
};
</script>
