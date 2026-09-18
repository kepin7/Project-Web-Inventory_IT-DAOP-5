<template>
    <Head title="Manajemen Inventaris" />
    
    <DashboardLayout>
        <!-- Header Section -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-medium text-gray-800">Manajemen Inventaris</h1>
                <p class="text-gray-400 text-sm mt-1">Kelola tingkat stok, lokasi, dan kondisi di seluruh gudang.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Tambah Barang Trigger Modal -->
                <button @click="openAddModal" class="px-5 py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Barang
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <!-- Search and Actions Bar -->
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between mb-6">
                <div class="relative flex-1 max-w-md w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input v-model="params.search" type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-100 rounded-lg leading-5 bg-gray-50/50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-[#312e81] focus:border-[#312e81] sm:text-sm transition-colors" placeholder="Cari nama barang, SN, atau lokasi...">
                </div>
                
                <div class="flex gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                    <div class="flex items-center bg-gray-50/50 border border-gray-100 rounded-lg px-1 shrink-0 focus-within:ring-1 focus-within:ring-[#312e81] focus-within:border-[#312e81]">
                        <input v-model="params.date_start" type="date" class="border-0 bg-transparent py-1.5 px-2 text-sm focus:ring-0 text-gray-600 outline-none w-[135px]" title="Dari Tanggal">
                        <span class="text-gray-300 mx-1">-</span>
                        <input v-model="params.date_end" type="date" class="border-0 bg-transparent py-1.5 px-2 text-sm focus:ring-0 text-gray-600 outline-none w-[135px]" title="Sampai Tanggal">
                    </div>
                    <select v-model="params.category" class="border border-gray-100 rounded-lg px-3 py-2 text-sm bg-gray-50/50 focus:ring-[#312e81] focus:border-[#312e81] text-gray-600 min-w-[120px]">
                        <option value="">Semua Kategori</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                    </select>
                    <select v-model="params.location" class="border border-gray-100 rounded-lg px-3 py-2 text-sm bg-gray-50/50 focus:ring-[#312e81] focus:border-[#312e81] text-gray-600 min-w-[120px]">
                        <option value="">Semua Lokasi</option>
                        <option v-for="loc in locations" :key="loc.id" :value="loc.id">{{ loc.name }}</option>
                    </select>
                    <select v-model="params.status" class="border border-gray-100 rounded-lg px-3 py-2 text-sm bg-gray-50/50 focus:ring-[#312e81] focus:border-[#312e81] text-gray-600 min-w-[120px]">
                        <option value="">Semua Status</option>
                        <option value="aman">Aman</option>
                        <option value="menipis">Menipis</option>
                        <option value="habis">Habis</option>
                    </select>
                    <select v-model="params.condition" class="border border-gray-100 rounded-lg px-3 py-2 text-sm bg-gray-50/50 focus:ring-[#312e81] focus:border-[#312e81] text-gray-600 min-w-[120px]">
                        <option value="">Semua Kondisi</option>
                        <option value="Normal">Normal</option>
                        <option value="Perbaikan">Perbaikan</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>
            </div>

            <!-- Inventory Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#edeef9] text-gray-500">
                            <th class="px-4 py-3 w-10 text-center text-xs font-medium border-b border-gray-100 rounded-tl-lg">No</th>
                            <th @click="toggleSort('created_at')" class="px-3 py-3 text-sm font-semibold text-gray-700 border-b border-gray-100 whitespace-nowrap cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors group select-none">
                                <div class="flex items-center justify-start gap-2">
                                    Tanggal
                                    <span class="inline-flex flex-col items-center justify-center">
                                        <svg v-if="params.sort_by !== 'created_at' || params.sort_dir === 'asc'" :class="params.sort_by === 'created_at' && params.sort_dir === 'asc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5 -mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
                                        <svg v-if="params.sort_by !== 'created_at' || params.sort_dir === 'desc'" :class="params.sort_by === 'created_at' && params.sort_dir === 'desc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                    </span>
                                </div>
                            </th>
                            <th @click="toggleSort('brand')" class="px-3 py-3 text-sm font-semibold text-gray-700 border-b border-gray-100 cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors group select-none">
                                <div class="flex items-center justify-start gap-2">
                                    Nama Barang
                                    <span class="inline-flex flex-col items-center justify-center">
                                        <svg v-if="params.sort_by !== 'brand' || params.sort_dir === 'asc'" :class="params.sort_by === 'brand' && params.sort_dir === 'asc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5 -mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
                                        <svg v-if="params.sort_by !== 'brand' || params.sort_dir === 'desc'" :class="params.sort_by === 'brand' && params.sort_dir === 'desc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                    </span>
                                </div>
                            </th>
                            <th @click="toggleSort('serial_number')" class="px-3 py-3 text-sm font-semibold text-gray-700 border-b border-gray-100 cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors group select-none">
                                <div class="flex items-center justify-start gap-2">
                                    SKU/SN
                                    <span class="inline-flex flex-col items-center justify-center">
                                        <svg v-if="params.sort_by !== 'serial_number' || params.sort_dir === 'asc'" :class="params.sort_by === 'serial_number' && params.sort_dir === 'asc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5 -mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
                                        <svg v-if="params.sort_by !== 'serial_number' || params.sort_dir === 'desc'" :class="params.sort_by === 'serial_number' && params.sort_dir === 'desc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                    </span>
                                </div>
                            </th>
                            <th @click="toggleSort('category')" class="px-3 py-3 text-sm font-semibold text-gray-700 border-b border-gray-100 cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors group select-none">
                                <div class="flex items-center justify-start gap-2">
                                    Kategori
                                    <span class="inline-flex flex-col items-center justify-center">
                                        <svg v-if="params.sort_by !== 'category' || params.sort_dir === 'asc'" :class="params.sort_by === 'category' && params.sort_dir === 'asc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5 -mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
                                        <svg v-if="params.sort_by !== 'category' || params.sort_dir === 'desc'" :class="params.sort_by === 'category' && params.sort_dir === 'desc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                    </span>
                                </div>
                            </th>
                            <th @click="toggleSort('location')" class="px-3 py-3 text-sm font-semibold text-gray-700 border-b border-gray-100 cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors group select-none">
                                <div class="flex items-center justify-start gap-2">
                                    Lokasi
                                    <span class="inline-flex flex-col items-center justify-center">
                                        <svg v-if="params.sort_by !== 'location' || params.sort_dir === 'asc'" :class="params.sort_by === 'location' && params.sort_dir === 'asc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5 -mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
                                        <svg v-if="params.sort_by !== 'location' || params.sort_dir === 'desc'" :class="params.sort_by === 'location' && params.sort_dir === 'desc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                    </span>
                                </div>
                            </th>
                            <th class="px-3 py-3 text-sm font-semibold text-gray-700 border-b border-gray-100 text-center">Status</th>
                            <th @click="toggleSort('condition')" class="px-3 py-3 text-sm font-semibold text-gray-700 border-b border-gray-100 text-center cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors group select-none">
                                <div class="flex items-center justify-center gap-2">
                                    Kondisi
                                    <span class="inline-flex flex-col items-center justify-center">
                                        <svg v-if="params.sort_by !== 'condition' || params.sort_dir === 'asc'" :class="params.sort_by === 'condition' && params.sort_dir === 'asc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5 -mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
                                        <svg v-if="params.sort_by !== 'condition' || params.sort_dir === 'desc'" :class="params.sort_by === 'condition' && params.sort_dir === 'desc' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-gray-400'" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                    </span>
                                </div>
                            </th>
                            <th class="px-3 py-3 w-32 text-sm font-semibold text-gray-700 border-b border-gray-100 text-center rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                        <tr v-for="(item, index) in spareParts.data" :key="item.id" class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-4 text-center">{{ (spareParts.current_page - 1) * spareParts.per_page + index + 1 }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-[13px]">{{ formatDate(item.created_at) }}</td>
                            <td class="px-3 py-4 font-medium text-gray-800">{{ item.brand }} ({{ item.type }})</td>
                            <td class="px-3 py-4 text-[13px] font-mono text-gray-500">{{ item.serial_number || '-' }}</td>
                            <td class="px-3 py-4 text-[13px]">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ item.category ? item.category.name : '-' }}
                                </span>
                            </td>
                            <td class="px-3 py-4 text-[13px]">{{ item.location ? item.location.name : '-' }}</td>
                            <td class="px-3 py-4 text-center">
                                <span :class="getStatusBadgeClass(item).class">{{ getStatusBadgeClass(item).text }}</span>
                            </td>
                            <td class="px-3 py-4 text-center">
                                <span :class="getConditionBadgeClass(item.condition)">{{ item.condition }}</span>
                            </td>
                            <td class="px-3 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="openDetailModal(item)" title="Lihat Detail" class="text-[#312e81] font-semibold text-xs hover:bg-indigo-50 p-2 rounded-lg transition-colors border border-[#312e81]/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button @click="openEditModal(item)" title="Edit Barang" class="text-gray-600 font-semibold text-xs hover:bg-gray-100 p-2 rounded-lg transition-colors border border-gray-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button @click="deleteItem(item)" title="Hapus Barang" class="text-red-500 font-semibold text-xs hover:bg-red-50 p-2 rounded-lg transition-colors border border-red-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!spareParts.data || spareParts.data.length === 0">
                            <td colspan="9" class="px-3 py-8 text-center text-gray-400">Tidak ada data ditemukan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 border-t border-gray-100 pt-4 gap-4">
                <span>Menampilkan data {{ spareParts.from || 0 }} sampai {{ spareParts.to || 0 }} dari {{ spareParts.total || 0 }} total data</span>
                
                <!-- Pagination -->
                <div class="flex gap-1" v-if="spareParts.links && spareParts.links.length > 3">
                    <component 
                        v-for="(link, i) in spareParts.links" 
                        :key="i"
                        :is="link.url ? Link : 'span'"
                        :href="link.url"
                        v-html="link.label"
                        class="px-3 py-1.5 rounded-md border text-sm transition-colors"
                        :class="[
                            link.active ? 'bg-[#312e81] text-white border-[#312e81]' : 'border-gray-200 text-gray-600 hover:bg-gray-50',
                            !link.url ? 'opacity-50 cursor-not-allowed bg-gray-50' : ''
                        ]"
                    />
                </div>
            </div>
        </div>

        <!-- MODAL DETAIL -->
        <div v-if="isDetailModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200 my-8">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-900">Detail Spare Part</h3>
                    <button @click="closeDetailModal" class="text-gray-400 hover:text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-0" v-if="selectedItem">
                    <!-- Gambar -->
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center border-b border-gray-200 overflow-hidden">
                        <img v-if="selectedItem.image" :src="`/storage/${selectedItem.image}`" alt="Gambar Barang" class="w-full h-full object-cover">
                        <div v-else class="text-gray-400 flex flex-col items-center">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-sm font-medium">Belum ada gambar</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6">
                            <div>
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">No</span>
                                <span class="font-semibold text-gray-900">{{ selectedItem.id }}</span>
                            </div>
                            <div>
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">Tanggal</span>
                                <span class="font-semibold text-gray-900">{{ formatDate(selectedItem.created_at) }}</span>
                            </div>
                            
                            <div class="col-span-1 sm:col-span-2">
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">No Inventaris</span>
                                <div class="bg-gray-50 border border-gray-100 px-3 py-2 rounded-lg font-mono text-sm text-gray-800">
                                    {{ selectedItem.inventory_number || 'Belum ada nomor inventaris' }}
                                </div>
                            </div>
                            
                            <div>
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">Category</span>
                                <span class="text-sm font-medium px-2.5 py-0.5 bg-indigo-50 text-indigo-700 rounded-full">{{ selectedItem.category ? selectedItem.category.name : '-' }}</span>
                            </div>
                            <div>
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">Merek</span>
                                <span class="font-semibold text-gray-900">{{ selectedItem.brand }}</span>
                            </div>
                            
                            <div>
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">Model / Type</span>
                                <span class="font-semibold text-gray-900">{{ selectedItem.type }}</span>
                            </div>
                            <div>
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">SKU / SN</span>
                                <span class="font-mono text-sm text-gray-800">{{ selectedItem.serial_number || '-' }}</span>
                            </div>
                            
                            <div>
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">Quantity</span>
                                <span class="text-sm font-bold text-gray-900">{{ selectedItem.quantity || 1 }} <span class="font-normal text-gray-500">Unit</span></span>
                            </div>
                            <div>
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">Kondisi</span>
                                <span :class="getConditionBadgeClass(selectedItem.condition)">{{ selectedItem.condition }}</span>
                            </div>

                            <div class="col-span-1 sm:col-span-2">
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">Lokasi</span>
                                <div class="flex items-center gap-2 text-sm font-medium text-gray-800">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ selectedItem.location ? selectedItem.location.name : '-' }}
                                </div>
                            </div>
                            
                            <div class="col-span-1 sm:col-span-2">
                                <span class="text-[11px] uppercase tracking-wider text-gray-500 font-semibold block mb-1">Keterangan</span>
                                <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100 leading-relaxed">{{ selectedItem.description || 'Tidak ada keterangan tambahan.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL TAMBAH BARANG -->
        <div v-if="isAddModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto">
            <div class="bg-white rounded-2xl w-full max-w-2xl shadow-xl animate-in fade-in zoom-in duration-200 my-8 max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-[#1e1b4b] text-white sticky top-0 z-10">
                    <h3 class="font-bold text-lg">{{ isEditing ? 'Edit Spare Part' : 'Tambah Spare Part Baru' }}</h3>
                    <button @click="closeAddModal" class="text-gray-300 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <!-- Fitur AI Upload -->
                    <div class="mb-6 p-5 bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100 rounded-xl">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-white shadow-sm rounded-lg text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-indigo-900 mb-1">Isi Otomatis dengan AI</h4>
                                <p class="text-xs text-indigo-700 mb-3">Punya foto label merk atau barcode inventaris? Upload disini biar AI yang mengetikkannya untuk Anda.</p>
                                    <div class="flex items-center gap-3">
                                        <div class="relative overflow-hidden inline-block">
                                            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-full transition-colors flex items-center gap-2" :disabled="isAiLoading">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                Upload File / Foto
                                            </button>
                                            <input type="file" @change="handleFileUpload" accept="image/*" capture="environment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" :disabled="isAiLoading" />
                                        </div>
                                    <span v-if="isAiLoading" class="text-xs text-indigo-600 font-bold flex items-center gap-1 animate-pulse">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        AI sedang membaca gambar...
                                    </span>
                                </div>
                                <div v-if="aiErrorMessage" class="mt-2 text-xs text-red-600 font-medium bg-red-50 p-2 rounded border border-red-100">
                                    {{ aiErrorMessage }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr v-if="!isEditing" class="border-gray-100 my-6">

                    <!-- Manual Form -->
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori Barang <span class="text-red-500">*</span></label>
                                <select v-model="form.category_id" :class="{'border-red-300': form.errors.category_id}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" required>
                                    <option value="" disabled>Pilih Kategori</option>
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                                </select>
                                <div v-if="form.errors.category_id" class="text-red-500 text-xs mt-1">{{ form.errors.category_id }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Lokasi Penyimpanan <span class="text-red-500">*</span></label>
                                <select v-model="form.location_id" :class="{'border-red-300': form.errors.location_id}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]" required>
                                    <option value="" disabled>Pilih Lokasi</option>
                                    <option v-for="loc in locations" :key="loc.id" :value="loc.id">{{ loc.name }}</option>
                                </select>
                                <div v-if="form.errors.location_id" class="text-red-500 text-xs mt-1">{{ form.errors.location_id }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Merk <span class="text-gray-400 font-normal ml-1">(opsional)</span></label>
                                <input v-model="form.brand" type="text" :class="{'border-red-300': form.errors.brand}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]">
                                <div v-if="form.errors.brand" class="text-red-500 text-xs mt-1">{{ form.errors.brand }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Tipe <span class="text-gray-400 font-normal ml-1">(opsional)</span></label>
                                <input v-model="form.type" type="text" :class="{'border-red-300': form.errors.type}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]">
                                <div v-if="form.errors.type" class="text-red-500 text-xs mt-1">{{ form.errors.type }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Serial Number</label>
                                <input v-model="form.serial_number" type="text" :class="{'border-red-300': form.errors.serial_number}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]">
                                <div v-if="form.errors.serial_number" class="text-red-500 text-xs mt-1">{{ form.errors.serial_number }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor Inventaris</label>
                                <input v-model="form.inventory_number" type="text" :class="{'border-red-300': form.errors.inventory_number}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]">
                                <div v-if="form.errors.inventory_number" class="text-red-500 text-xs mt-1">{{ form.errors.inventory_number }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Kondisi</label>
                                <select v-model="form.condition" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]">
                                    <option value="Normal">Normal</option>
                                    <option value="Perbaikan">Perbaikan</option>
                                    <option value="Rusak">Rusak</option>
                                </select>
                            </div>
                            <div class="col-span-1 sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Foto / Gambar Barang</label>
                                <input type="file" @change="e => form.image = e.target.files[0]" accept="image/*" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81] file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="text-[10px] text-gray-400 mt-1">*Maksimal 5MB. Kosongkan jika tidak ingin mengubah gambar.</p>
                                <div v-if="form.errors.image" class="text-red-500 text-xs mt-1">{{ form.errors.image }}</div>
                            </div>
                            <div class="col-span-1 sm:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Keterangan Tambahan</label>
                                <textarea v-model="form.description" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-[#312e81] focus:border-[#312e81]"></textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="button" @click="closeAddModal" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">Batal</button>
                            <button type="submit" :disabled="form.processing" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#1e1b4b] hover:bg-[#312e81] rounded-lg transition-colors">
                                <span v-if="form.processing" class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin mr-2 inline-block align-middle"></span>
                                {{ isEditing ? 'Simpan Perubahan' : 'Simpan Barang' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { ref, watch, onMounted } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    spareParts: {
        type: Object,
        default: () => ({ data: [] })
    },
    categories: {
        type: Array,
        default: () => []
    },
    locations: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({})
    }
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

const params = ref({
    search: props.filters.search || '',
    category: props.filters.category || '',
    location: props.filters.location || '',
    status: props.filters.status || '',
    condition: props.filters.condition || '',
    date_start: props.filters.date_start || '',
    date_end: props.filters.date_end || '',
    sort_by: props.filters.sort_by || 'created_at',
    sort_dir: props.filters.sort_dir || 'desc',
});

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('action') === 'add') {
        openAddModal();
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});

// Custom simple debounce to avoid lodash dependency
let timeout = null;
const debounce = (fn, delay) => {
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            fn(...args);
        }, delay);
    };
};

// Watch for changes in params and trigger router get
watch(params, debounce(() => {
    // Only send parameters that have values
    const queryParams = {};
    for (const key in params.value) {
        if (params.value[key] !== '' && params.value[key] !== null) {
            queryParams[key] = params.value[key];
        }
    }

    router.get('/inventory', queryParams, {
        preserveState: true,
        replace: true,
        preserveScroll: true
    });
}, 300), { deep: true });

const toggleSort = (column) => {
    if (params.value.sort_by === column) {
        if (params.value.sort_dir === 'asc') {
            params.value.sort_dir = 'desc';
        } else {
            params.value.sort_by = '';
            params.value.sort_dir = '';
        }
    } else {
        params.value.sort_by = column;
        params.value.sort_dir = 'asc';
    }
};

const formatDate = (dateString) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });
};

const getConditionBadgeClass = (condition) => {
    if (!condition) return 'inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-gray-200 text-gray-700';
    switch(condition.toLowerCase()) {
        case 'normal': return 'inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-[#bbf7d0] text-[#166534]';
        case 'perbaikan': return 'inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-[#fef08a] text-[#854d0e]';
        case 'rusak': return 'inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-[#fecaca] text-[#991b1b]';
        default: return 'inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-gray-200 text-gray-700';
    }
};

const getStatusBadgeClass = (item) => {
    // Prioritas: jika barang sudah keluar (stock out), tampilkan Habis
    if (item.is_available === false || item.is_available === 0) {
        return { text: 'Habis', class: 'inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-[#fecaca] text-[#991b1b]' };
    }
    
    const qty = item.quantity || 0;
    if (qty <= 3) {
        return { text: 'Menipis', class: 'inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-[#fef08a] text-[#854d0e]' };
    } else {
        return { text: 'Aman', class: 'inline-flex px-3 py-1 rounded-md text-[11px] font-semibold bg-[#dcfce7] text-[#166534]' };
    }
};

// Modal Detail Logic
const isDetailModalOpen = ref(false);
const selectedItem = ref(null);

const openDetailModal = (item) => {
    selectedItem.value = item;
    isDetailModalOpen.value = true;
};

const closeDetailModal = () => {
    isDetailModalOpen.value = false;
    selectedItem.value = null;
};

// Modal Add/Edit Logic
const isAddModalOpen = ref(false);
const isEditing = ref(false);
const editId = ref(null);

const form = useForm({
    category_id: '',
    location_id: '',
    brand: '',
    type: '',
    serial_number: '',
    inventory_number: '',
    condition: 'Normal',
    description: '',
    image: null,
    _method: 'post'
});

const openAddModal = () => {
    isEditing.value = false;
    editId.value = null;
    form.reset();
    isAddModalOpen.value = true;
};

const openEditModal = (item) => {
    isEditing.value = true;
    editId.value = item.id;
    form.category_id = item.category_id || '';
    form.location_id = item.location_id || '';
    form.brand = item.brand;
    form.type = item.type;
    form.serial_number = item.serial_number || '';
    form.inventory_number = item.inventory_number || '';
    form.condition = item.condition || 'Normal';
    form.description = item.description || '';
    form.image = null;
    form._method = 'put';
    isAddModalOpen.value = true;
};

const closeAddModal = () => {
    isAddModalOpen.value = false;
    setTimeout(() => {
        form.reset();
        form._method = 'post';
    }, 200);
    aiErrorMessage.value = '';
};

// AI Upload Logic
const isAiLoading = ref(false);
const aiErrorMessage = ref('');

const processFileWithAI = async (file) => {
    isAiLoading.value = true;
    aiErrorMessage.value = '';

    const formData = new FormData();
    formData.append('image', file);

    try {
        const response = await fetch('/api/ai/extract-item', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        });

        const responseData = await response.json();

        if (!response.ok) {
            throw new Error(responseData.message || 'Gagal menghubungi server AI.');
        }

        if (responseData.success && responseData.data) {
            const data = responseData.data;
            form.brand = data.brand || form.brand;
            form.type = data.type || form.type;
            form.serial_number = data.serial_number || form.serial_number;
            form.inventory_number = data.inventory_number || form.inventory_number;
            
            // Set input file so it can be uploaded to server
            form.image = file;
        }
    } catch (error) {
        console.error(error);
        aiErrorMessage.value = error.message || 'Terjadi kesalahan jaringan.';
    } finally {
        isAiLoading.value = false;
    }
};

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (!file) return;
    
    processFileWithAI(file);
    event.target.value = '';
};

const submitForm = () => {
    if (isEditing.value) {
        form.transform((data) => ({
            ...data,
            _method: 'PUT'
        })).post('/inventory/' + editId.value, {
            onSuccess: () => {
                closeAddModal();
                Toast.fire({
                    icon: 'success',
                    title: 'Barang berhasil diperbarui'
                });
            },
            preserveScroll: true,
        });
    } else {
        form._method = 'post';
        form.post('/inventory', {
            onSuccess: () => {
                closeAddModal();
                Toast.fire({
                    icon: 'success',
                    title: 'Barang berhasil ditambahkan'
                });
            },
            preserveScroll: true,
        });
    }
};

const deleteItem = (item) => {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Barang ${item.brand} ${item.type} akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete('/inventory/' + item.id, {
                preserveScroll: true,
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Barang berhasil dihapus'
                    });
                }
            });
        }
    });
};
</script>
