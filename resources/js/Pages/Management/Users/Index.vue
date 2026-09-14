<template>
    <Head title="Manajemen Pengguna" />
    
    <DashboardLayout>
        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-medium text-gray-800">Pengguna</h1>
                <p class="text-gray-400 text-sm mt-1">Kelola akun pengguna dan hak akses sistem Anda.</p>
            </div>
            
            <div>
                <button class="px-5 py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Pengguna
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row items-center gap-4">
                <div class="relative w-full md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Cari nama atau lokasi..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#312e81] focus:border-[#312e81] transition-shadow">
                </div>
                
                <div class="relative">
                    <select class="appearance-none block w-40 pl-4 pr-10 py-2 text-sm text-gray-700 font-medium border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-[#312e81] focus:border-[#312e81]">
                        <option>Semua Peran</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                
                <div class="relative">
                    <select class="appearance-none block w-40 pl-4 pr-10 py-2 text-sm text-gray-700 font-medium border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-[#312e81] focus:border-[#312e81]">
                        <option>Semua Status</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#edeef9] text-gray-500 uppercase text-[11px] font-bold tracking-wider">
                            <th class="px-6 py-4 border-b border-gray-100">Nama</th>
                            <th class="px-6 py-4 border-b border-gray-100">Peran</th>
                            <th class="px-6 py-4 border-b border-gray-100">Lokasi</th>
                            <th class="px-6 py-4 border-b border-gray-100 text-center">Status</th>
                            <th class="px-6 py-4 border-b border-gray-100">Aktivitas Terakhir</th>
                            <th class="px-6 py-4 border-b border-gray-100 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                        <tr v-for="(user, index) in dummyUsers" :key="index" class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#f1f5f9] flex items-center justify-center text-gray-700 font-semibold text-sm">
                                        {{ user.initials }}
                                    </div>
                                    <div class="font-semibold text-gray-800">{{ user.name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 rounded-md text-xs font-semibold bg-[#edeef9] text-[#312e81]">
                                    {{ user.role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <div class="whitespace-pre-line">{{ user.location }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span v-if="user.status === 'Aktif'" class="inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-[#dcfce7] text-[#166534]">
                                    Aktif
                                </span>
                                <span v-else class="inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-[#fee2e2] text-[#991b1b]">
                                    Nonaktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-[13px]">
                                {{ user.lastActivate }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <!-- Action Button -->
                                    <button v-if="user.status === 'Aktif'" class="px-3 py-1 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition-colors">
                                        Nonaktifkan
                                    </button>
                                    <button v-else class="px-3 py-1 text-xs font-semibold text-green-600 bg-green-50 hover:bg-green-100 rounded-md transition-colors">
                                        Aktifkan
                                    </button>
                                    
                                    <!-- Edit Icon -->
                                    <button class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    
                                    <!-- Delete Icon -->
                                    <button class="text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Static mockup) -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Menampilkan 3 dari 3 pengguna
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const dummyUsers = [
    {
        initials: 'BP',
        name: 'Bagas Prakoso',
        role: 'Super Admin',
        location: 'GUDANG IT\nPURWOKERTO',
        status: 'Aktif',
        lastActivate: 'Baru saja'
    },
    {
        initials: 'DP',
        name: 'Dian Puspitasari',
        role: 'Admin',
        location: 'GUDANG IT\nPURWOKERTO',
        status: 'Aktif',
        lastActivate: '1 jam yang lalu'
    },
    {
        initials: 'SS',
        name: 'Siti Sumarningsih',
        role: 'Admin',
        location: 'RUANG SERVER\nSTASIUN PWT',
        status: 'Nonaktif',
        lastActivate: '1 minggu yang lalu'
    }
];
</script>
