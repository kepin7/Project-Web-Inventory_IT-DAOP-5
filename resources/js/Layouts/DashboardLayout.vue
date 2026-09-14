<template>
    <div class="h-screen w-full bg-[#f6f6f6] flex overflow-hidden relative">
        <!-- Mobile Sidebar Overlay -->
        <div v-if="isMobileMenuOpen" @click="isMobileMenuOpen = false" class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden backdrop-blur-sm transition-opacity"></div>

        <!-- Sidebar -->
        <aside :class="['w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col z-50 fixed inset-y-0 left-0 transform transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0', isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full']">
            <div class="h-20 flex items-center px-6 border-b border-gray-100">
                <!-- KAI Logo -->
                <div class="flex items-center cursor-pointer">
                    <img src="/logo.svg" alt="KAI Logo" class="h-10 w-auto object-contain">
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <Link href="/" :class="['flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors', $page.url === '/' ? 'bg-[#312e81] text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                    <svg :class="['w-5 h-5', $page.url === '/' ? 'opacity-90' : 'opacity-70']" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Beranda
                </Link>
                
                <Link href="/inventory" :class="['flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors', $page.url.startsWith('/inventory') ? 'bg-[#312e81] text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                    <svg :class="['w-5 h-5', $page.url.startsWith('/inventory') ? 'opacity-90' : 'opacity-70']" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Inventaris
                </Link>

                <div>
                    <button @click="isManagementOpen = !isManagementOpen" :class="['w-full flex items-center justify-between px-4 py-3 rounded-xl font-semibold transition-colors group', $page.url.startsWith('/management') ? 'bg-[#312e81] text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                        <div class="flex items-center gap-3">
                            <svg :class="['w-5 h-5', $page.url.startsWith('/management') ? 'opacity-90' : 'opacity-70 group-hover:opacity-100']" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Manajemen
                        </div>
                        <svg :class="['w-4 h-4 transition-transform opacity-70', isManagementOpen ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Submenu -->
                    <div v-show="isManagementOpen" class="mt-2 space-y-1">
                        <Link href="/management/category" :class="['block pl-12 pr-4 py-2.5 rounded-xl text-sm font-semibold transition-colors', $page.url.startsWith('/management/category') ? 'bg-[#eceef9] text-[#312e81]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                            Kategori
                        </Link>
                        <Link href="/management/users" :class="['block pl-12 pr-4 py-2.5 rounded-xl text-sm font-semibold transition-colors', $page.url.startsWith('/management/users') ? 'bg-[#eceef9] text-[#312e81]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                            Pengguna
                        </Link>
                        <Link href="/management/locations" :class="['block pl-12 pr-4 py-2.5 rounded-xl text-sm font-semibold transition-colors', $page.url.startsWith('/management/locations') ? 'bg-[#eceef9] text-[#312e81]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                            Lokasi
                        </Link>
                    </div>
                </div>

                <Link href="/stock-movement" :class="['flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors', $page.url.startsWith('/stock-movement') ? 'bg-[#312e81] text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                    <svg :class="['w-5 h-5', $page.url.startsWith('/stock-movement') ? 'opacity-90' : 'opacity-70']" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    Pergerakan Stok
                </Link>

                <div>
                    <button class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-semibold transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Tambah Pengguna
                        </div>
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
            </nav>

            <div class="p-4 border-t border-gray-200">
                <Link href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan
                </Link>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar -->
            <header class="h-20 bg-white/50 backdrop-blur-md border-b border-gray-200/50 flex-shrink-0 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-10">
                <div class="flex items-center flex-1 max-w-xl gap-4">
                    <!-- Hamburger Menu Button (Mobile Only) -->
                    <button @click="isMobileMenuOpen = true" class="lg:hidden p-2 -ml-2 rounded-xl text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#312e81]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl bg-gray-50 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#312e81] focus:bg-white transition-all" placeholder="Cari...">
                    </div>
                </div>

                <div class="flex items-center gap-6 ml-4">
                    <!-- Date/Time Display -->
                    <div class="hidden md:flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 min-w-[240px]">
                        <div class="p-1.5 bg-[#eef2ff] text-[#312e81] rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900 leading-tight" v-text="currentTime"></div>
                            <div class="text-xs text-gray-500" v-text="currentDate"></div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="flex items-center gap-3 border-l pl-6 border-gray-200">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-bold text-gray-900">Jaelani Nurazizah</div>
                            <div class="text-xs text-gray-500">Super Admin</div>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=Jaelani+Nurazizah&background=random" alt="Avatar" class="h-full w-full object-cover">
                        </div>
                    </div>

                    <!-- Icons -->
                    <div class="flex items-center gap-2">
                        <button class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                        <button class="relative p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors">
                            <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage();
const isManagementOpen = ref(page.url.startsWith('/management'));
const isMobileMenuOpen = ref(false);

watch(() => page.url, (newUrl) => {
    if (newUrl.startsWith('/management')) {
        isManagementOpen.value = true;
    }
});

const currentTime = ref('');
const currentDate = ref('');
let timer;

const updateClock = () => {
    const now = new Date();
    // Gunakan zona waktu WIB secara explisit
    const optionsTime = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
    const optionsDate = { timeZone: 'Asia/Jakarta', weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    
    currentTime.value = new Intl.DateTimeFormat('id-ID', optionsTime).format(now).replace(/\./g, ':') + ' WIB';
    currentDate.value = new Intl.DateTimeFormat('id-ID', optionsDate).format(now);
};

onMounted(() => {
    updateClock();
    timer = setInterval(updateClock, 1000);
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});

// Close mobile menu on page navigation
router.on('navigate', () => {
    isMobileMenuOpen.value = false;
});
</script>
