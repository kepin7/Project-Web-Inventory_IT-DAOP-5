<template>
    <Head title="Manajemen Kategori" />
    
    <DashboardLayout>
        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-medium text-gray-800">Kategori</h1>
                <p class="text-gray-400 text-sm mt-1">Kelola dan kelompokkan data spare part beserta aset inventaris Anda.</p>
            </div>
            
            <div>
                <button @click="openAddModal" class="px-5 py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Kategori Baru
                </button>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <div v-for="cat in categories" :key="cat.id" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col justify-between">
                
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                            <component :is="getIconComponent(cat.icon)" class="w-6 h-6" />
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ cat.name }}</h3>
                    <p class="text-xs text-gray-400 mb-6 line-clamp-2 min-h-[32px]">
                        {{ cat.description || 'Tidak ada deskripsi' }}
                    </p>
                </div>
                
                <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                    <div>
                        <div class="text-[11px] font-medium text-gray-400 mb-1">Total Produk</div>
                        <div class="text-sm font-bold text-gray-900">{{ cat.spare_parts_count }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="openEditModal(cat)" class="px-3 py-1.5 text-xs font-semibold text-[#312e81] bg-indigo-50 hover:bg-indigo-100 rounded-md transition-colors">
                            Edit
                        </button>
                        <button @click="deleteCategory(cat)" class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition-colors">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
            
            <div v-if="!categories || categories.length === 0" class="col-span-full py-12 text-center text-gray-400">
                Tidak ada kategori ditemukan.
            </div>
        </div>

        <!-- MODAL FORM KATEGORI -->
        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white rounded-2xl w-full max-w-md shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200 my-8">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-900">{{ isEditing ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form @submit.prevent="submitForm" class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                            <input v-model="form.name" type="text" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" placeholder="Misal: Elektronik" required>
                            <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Pilih Ikon</label>
                            <div class="grid grid-cols-6 sm:grid-cols-8 gap-2 max-h-48 overflow-y-auto p-1 border rounded-lg bg-gray-50/50">
                                <button type="button" v-for="icon in availableIcons" :key="icon.name" 
                                    @click="form.icon = icon.name"
                                    class="p-2 border rounded-xl flex items-center justify-center transition-colors"
                                    :class="form.icon === icon.name ? 'border-[#312e81] bg-indigo-50 text-[#312e81] shadow-sm' : 'border-gray-200 text-gray-500 hover:bg-white bg-white'">
                                    <component :is="icon.component" class="w-5 h-5" />
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi</label>
                            <textarea v-model="form.description" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" placeholder="Tambahkan deskripsi singkat..."></textarea>
                            <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" @click="closeModal" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#1e1b4b] hover:bg-[#312e81] rounded-lg transition-colors flex items-center justify-center min-w-[120px]">
                            <span v-if="form.processing" class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin mr-2"></span>
                            {{ isEditing ? 'Simpan Perubahan' : 'Tambah Kategori' }}
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
import { 
    Cpu, Monitor, Printer, Server, Keyboard, Mouse, HardDrive, Headphones, 
    Speaker, Smartphone, Tablet, Laptop, Watch, Battery, Cable, Usb, Wifi, 
    Bluetooth, Router, Webcam, Tv, Projector, Mic, Camera, Database, Cloud, 
    Network, Plug, Zap, Lightbulb, Box, Archive, FileText, Briefcase 
} from '@lucide/vue';

const props = defineProps({
    categories: Array
});

const availableIcons = [
    { name: 'Cpu', component: Cpu }, { name: 'Monitor', component: Monitor }, { name: 'Printer', component: Printer },
    { name: 'Server', component: Server }, { name: 'Keyboard', component: Keyboard }, { name: 'Mouse', component: Mouse },
    { name: 'HardDrive', component: HardDrive }, { name: 'Headphones', component: Headphones }, { name: 'Speaker', component: Speaker },
    { name: 'Smartphone', component: Smartphone }, { name: 'Tablet', component: Tablet }, { name: 'Laptop', component: Laptop },
    { name: 'Watch', component: Watch }, { name: 'Battery', component: Battery }, { name: 'Cable', component: Cable },
    { name: 'Usb', component: Usb }, { name: 'Wifi', component: Wifi }, { name: 'Bluetooth', component: Bluetooth },
    { name: 'Router', component: Router }, { name: 'Webcam', component: Webcam }, { name: 'Tv', component: Tv },
    { name: 'Projector', component: Projector }, { name: 'Mic', component: Mic }, { name: 'Camera', component: Camera },
    { name: 'Database', component: Database }, { name: 'Cloud', component: Cloud }, { name: 'Network', component: Network },
    { name: 'Plug', component: Plug }, { name: 'Zap', component: Zap }, { name: 'Lightbulb', component: Lightbulb },
    { name: 'Box', component: Box }, { name: 'Archive', component: Archive }, { name: 'FileText', component: FileText },
    { name: 'Briefcase', component: Briefcase }
];

const getIconComponent = (iconName) => {
    if (!iconName) return availableIcons[0].component;
    // Map old string keys like 'cpu' to 'Cpu' for backwards compatibility
    const camelCaseName = iconName.charAt(0).toUpperCase() + iconName.slice(1);
    const found = availableIcons.find(i => i.name === camelCaseName || i.name === iconName);
    return found ? found.component : availableIcons[0].component;
};

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
    icon: 'Cpu'
});

const openAddModal = () => {
    isEditing.value = false;
    editId.value = null;
    form.reset();
    form.clearErrors();
    isModalOpen.value = true;
};

const openEditModal = (cat) => {
    isEditing.value = true;
    editId.value = cat.id;
    form.name = cat.name;
    form.description = cat.description || '';
    form.icon = cat.icon || 'Cpu';
    form.clearErrors();
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => form.reset(), 200);
};

const submitForm = () => {
    if (isEditing.value) {
        form.put('/management/category/' + editId.value, {
            onSuccess: () => {
                closeModal();
                Toast.fire({
                    icon: 'success',
                    title: 'Kategori berhasil diperbarui'
                });
            },
            preserveScroll: true
        });
    } else {
        form.post('/management/category', {
            onSuccess: () => {
                closeModal();
                Toast.fire({
                    icon: 'success',
                    title: 'Kategori berhasil ditambahkan'
                });
            },
            preserveScroll: true
        });
    }
};

const deleteCategory = (cat) => {
    if (cat.spare_parts_count > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Kategori ini tidak dapat dihapus karena masih memiliki barang terdaftar.',
            confirmButtonColor: '#312e81'
        });
        return;
    }
    
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Kategori "${cat.name}" akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete('/management/category/' + cat.id, {
                preserveScroll: true,
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Kategori berhasil dihapus'
                    });
                }
            });
        }
    });
};
</script>
