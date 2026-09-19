<template>
    <div class="h-screen w-full bg-[#f6f6f6] flex overflow-hidden relative">
        <!-- Mobile Sidebar Overlay -->
        <div v-if="isMobileMenuOpen" @click="isMobileMenuOpen = false" class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden backdrop-blur-sm transition-opacity"></div>

        <!-- Sidebar -->
        <aside :class="[
            'w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col z-50 fixed inset-y-0 left-0 transform transition-all duration-300 ease-in-out lg:relative', 
            isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
            isDesktopSidebarOpen ? 'lg:ml-0' : 'lg:-ml-64'
        ]">
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
                <template v-if="$page.props.auth?.user">
                    <Link href="/inventory" :class="['flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors', $page.url.startsWith('/inventory') ? 'bg-[#312e81] text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                        <svg :class="['w-5 h-5', $page.url.startsWith('/inventory') ? 'opacity-90' : 'opacity-70']" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Inventaris
                    </Link>

                    <Link href="/stock-movement" :class="['flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-colors', $page.url.startsWith('/stock-movement') ? 'bg-[#312e81] text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                        <svg :class="['w-5 h-5', $page.url.startsWith('/stock-movement') ? 'opacity-90' : 'opacity-70']" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Pergerakan Stok
                    </Link>
                </template>

                <div v-if="$page.props.auth?.user?.role === 'super_admin'">
                    <button @click="isManagementOpen = !isManagementOpen" :class="['w-full flex items-center justify-between px-4 py-3 rounded-xl font-semibold transition-colors group', $page.url.startsWith('/management') ? 'bg-[#312e81] text-white shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900']">
                        <div class="flex items-center gap-3">
                            <svg :class="['w-5 h-5', $page.url.startsWith('/management') ? 'opacity-90' : 'opacity-70 group-hover:opacity-100']" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002 2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Manajemen
                        </div>
                        <svg :class="['w-4 h-4 transition-transform opacity-70', isManagementOpen ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Manajemen submenu -->
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

            </nav>

            <!-- Sidebar Footer: Logout Button -->
            <div class="border-t border-gray-100" v-if="$page.props.auth?.user">
                <!-- Mobile User Info -->
                <div class="p-4 lg:hidden border-b border-gray-50 flex items-center gap-3">
                    <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth.user.name)}&background=random`" class="h-10 w-10 rounded-full bg-gray-200 object-cover flex-shrink-0">
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-gray-900 truncate">{{ $page.props.auth.user.name }}</div>
                        <div class="text-[10px] text-gray-500 capitalize">{{ $page.props.auth.user.role.replace('_', ' ') }}</div>
                    </div>
                </div>
                <div class="p-4">
                    <Link href="/logout" method="post" as="button" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="truncate">Keluar (Logout)</span>
                    </Link>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar -->
            <header class="h-20 bg-white/50 backdrop-blur-md border-b border-gray-200/50 flex-shrink-0 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 relative">
                <!-- Mobile Search Overlay -->
                <div v-if="isMobileSearchOpen" class="absolute inset-0 bg-white z-[60] flex items-center px-4 gap-3 md:hidden">
                    <button @click="isMobileSearchOpen = false" class="p-2 -ml-2 text-gray-500 hover:bg-gray-100 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input v-model="globalSearchQuery" @keyup.enter="handleGlobalSearch" type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-[#312e81]" placeholder="Ketik lalu Enter..." autofocus>
                    </div>
                </div>

                <div class="flex items-center flex-1 max-w-xl gap-4">
                    <!-- Hamburger Menu Button -->
                    <button @click="toggleSidebar" class="p-2 -ml-2 rounded-xl text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#312e81] transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <div class="relative w-full z-50 hidden md:block" v-if="$page.props.auth?.user">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input v-model="globalSearchQuery" @keyup.enter="handleGlobalSearch" @focus="isSearchFocused = true" @blur="handleSearchBlur" type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl bg-gray-50 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#312e81] focus:bg-white transition-all" placeholder="Cari menu, barang, atau TRX...">
                        
                        <!-- Search Dropdown / Spotlight (Menu Only) -->
                        <div v-if="isSearchFocused && globalSearchQuery && filteredMenus.length > 0" 
                             class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                                
                            <div class="px-4 py-2 text-xs font-bold text-gray-400 bg-gray-50 uppercase tracking-wider">Halaman</div>
                            <Link v-for="menu in filteredMenus" :key="menu.url" :href="menu.url" class="block px-4 py-2.5 hover:bg-gray-50 transition-colors flex items-center gap-3">
                                <div class="p-1.5 bg-indigo-50 text-[#312e81] rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></div>
                                <span class="text-sm font-semibold text-gray-700">{{ menu.title }}</span>
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-6 ml-4">
                    <!-- Date/Time Display -->
                    <div class="flex items-center gap-2 md:gap-3 bg-white px-2 sm:px-4 py-1.5 sm:py-2 rounded-xl shadow-sm border border-gray-100">
                        <div class="hidden sm:flex p-1.5 bg-[#eef2ff] text-[#312e81] rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-[11px] sm:text-sm font-bold text-gray-900 leading-tight whitespace-nowrap" v-text="currentTime"></div>
                            <div class="text-[9px] sm:text-xs text-gray-500 whitespace-nowrap" v-text="currentDate"></div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="hidden md:flex items-center gap-3 border-l pl-6 border-gray-200 relative" v-if="$page.props.auth?.user">
                        <div class="text-right">
                            <div class="text-sm font-bold text-gray-900">{{ $page.props.auth.user.name }}</div>
                            <div class="text-xs text-gray-500 capitalize">{{ $page.props.auth.user.role.replace('_', ' ') }}</div>
                        </div>
                        <button @click="isProfileMenuOpen = !isProfileMenuOpen" class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden border-2 border-transparent hover:border-[#312e81] transition-colors focus:outline-none">
                            <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth.user.name)}&background=random`" alt="Avatar" class="h-full w-full object-cover">
                        </button>
                        
                        <!-- Profile Dropdown -->
                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <div v-show="isProfileMenuOpen" class="absolute top-14 right-0 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-[100]">
                                <div class="px-4 py-2.5 text-sm font-medium text-gray-500 border-b border-gray-50 mb-1">
                                    Masuk sebagai:
                                    <div class="font-bold text-gray-900 mt-0.5 truncate">{{ $page.props.auth.user.name }}</div>
                                </div>
                                <div class="px-4 py-2 text-xs text-gray-400">
                                    Silakan gunakan menu logout di bagian bawah sidebar untuk keluar dari sistem.
                                </div>
                            </div>
                        </transition>
                    </div>
                    <div class="flex items-center gap-3 md:border-l md:pl-6 border-gray-200" v-else>
                        <Link href="/login" class="px-3 sm:px-5 py-1.5 sm:py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition-colors whitespace-nowrap">
                            Masuk
                        </Link>
                    </div>

                    <!-- Icons -->
                    <div class="flex items-center gap-2" v-if="$page.props.auth?.user">
                        <!-- Mobile Search Toggle -->
                        <button @click="isMobileSearchOpen = true" class="md:hidden p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                        
                        <button @click="isHelpModalOpen = true" class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors hidden sm:block">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                        
                        <!-- Notification Bell -->
                        <div ref="notificationContainer" class="relative" :class="{'z-[9999]': showNotifications}">
                            <button @click="toggleNotification" class="relative p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors">
                                <span v-if="unreadCount > 0" class="absolute top-1 right-1 min-w-[18px] h-[18px] px-1 flex items-center justify-center rounded-full bg-red-500 ring-2 ring-white text-[9px] font-bold text-white">{{ unreadCount > 99 ? '99+' : unreadCount }}</span>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </button>

                            <!-- Notification Dropdown -->
                            <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                                <div v-if="showNotifications" class="absolute right-0 mt-3 w-96 max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-[9999]">
                                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                                        <div>
                                            <h3 class="font-bold text-gray-900">Notifikasi</h3>
                                            <p v-if="unreadCount > 0" class="text-xs text-gray-500">{{ unreadCount }} belum dibaca</p>
                                        </div>
                                        <button v-if="unreadCount > 0" @click="markAllRead" class="text-xs text-[#312e81] font-semibold hover:underline">Tandai semua dibaca</button>
                                    </div>

                                    <div class="max-h-[400px] overflow-y-auto">
                                        <template v-if="notificationList.length > 0">
                                            <button
                                                v-for="notif in notificationList"
                                                :key="notif.id"
                                                @click="handleNotificationClick(notif)"
                                                :class="['w-full flex items-start gap-3 px-5 py-3.5 text-left transition-colors border-b border-gray-50', notif.is_read ? 'hover:bg-gray-50' : 'bg-[#f5f6ff] hover:bg-[#eceef9]']"
                                            >
                                                <div :class="['mt-0.5 flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center',
                                                    notif.type === 'stock' ? 'bg-red-50 text-red-500' : notif.type === 'system' ? 'bg-indigo-50 text-indigo-500' : 'bg-emerald-50 text-emerald-500']">
                                                    <svg v-if="notif.type === 'stock'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                    <svg v-else-if="notif.type === 'system'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                                                    <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between gap-2">
                                                        <span class="font-bold text-gray-900 text-sm truncate">{{ notif.title }}</span>
                                                        <span v-if="!notif.is_read" class="flex-shrink-0 w-2 h-2 rounded-full bg-[#312e81] mt-1.5"></span>
                                                    </div>
                                                    <p class="text-xs text-gray-600 mt-0.5 line-clamp-2">{{ notif.message }}</p>
                                                    <p class="text-[10px] text-gray-400 mt-1">{{ relativeTime(notif.created_at) }}</p>
                                                </div>
                                            </button>
                                        </template>
                                        <div v-else class="py-16 flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                            <p class="text-sm font-medium">Tidak ada notifikasi</p>
                                        </div>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-8">
                <slot />
            </div>
        </main>

        <!-- Help Modal -->
        <div v-if="isHelpModalOpen" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 sm:p-0">
            <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" @click="isHelpModalOpen = false"></div>
            
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-w-2xl transform transition-all relative z-10 animate-fade-in-up">
                <!-- Header -->
                <div class="bg-gradient-to-r from-[#1e1b4b] to-[#312e81] px-6 py-5 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white flex items-center gap-3">
                        <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pusat Bantuan & Panduan
                    </h3>
                    <button @click="isHelpModalOpen = false" class="text-indigo-200 hover:text-white transition-colors p-1 bg-white/10 rounded-lg hover:bg-white/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 max-h-[70vh] overflow-y-auto bg-gray-50/50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column: Quick Guide -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#312e81]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                Panduan Singkat
                            </h4>
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 space-y-3">
                                <div class="flex gap-3">
                                    <div class="w-6 h-6 flex-shrink-0 bg-indigo-50 text-[#312e81] rounded-full flex items-center justify-center text-xs font-bold">1</div>
                                    <p class="text-sm text-gray-600"><strong class="text-gray-900">Inventaris:</strong> Gunakan menu ini untuk melihat, menambah, atau mengedit daftar suku cadang yang tersedia di DAOP 5.</p>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-6 h-6 flex-shrink-0 bg-indigo-50 text-[#312e81] rounded-full flex items-center justify-center text-xs font-bold">2</div>
                                    <p class="text-sm text-gray-600"><strong class="text-gray-900">Pergerakan Stok:</strong> Catat barang masuk (restock) atau barang keluar (digunakan/dipinjam) di menu ini.</p>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-6 h-6 flex-shrink-0 bg-indigo-50 text-[#312e81] rounded-full flex items-center justify-center text-xs font-bold">3</div>
                                    <p class="text-sm text-gray-600"><strong class="text-gray-900">Laporan Ekspor:</strong> Anda bisa mengekspor data ke PDF, Excel, atau CSV melalui tombol Ekspor Laporan di Beranda.</p>
                                </div>
                                <div v-if="$page.props.auth?.user?.role === 'super_admin'" class="flex gap-3 pt-2 border-t border-gray-100">
                                    <div class="w-6 h-6 flex-shrink-0 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xs font-bold">4</div>
                                    <p class="text-sm text-gray-600"><strong class="text-gray-900">Manajemen:</strong> Kelola data Kategori, Lokasi, dan Pengguna sistem melalui menu khusus ini.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Support & Roles -->
                        <div class="space-y-6">
                            <!-- IT Support Contact -->
                            <div class="space-y-4">
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    Kontak Tim IT DAOP 5
                                </h4>
                                <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 p-4 rounded-xl shadow-sm text-white">
                                    <p class="text-sm text-emerald-50 mb-3">Jika Anda menemukan kendala sistem atau butuh bantuan teknis, silakan hubungi:</p>
                                    <div class="space-y-3">
                                        <a href="mailto:it.daop5@kai.id" class="flex items-center gap-2 text-sm font-medium hover:text-emerald-200 transition-colors bg-white/10 px-3 py-2 rounded-lg w-fit">
                                            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            it.daop5@kai.id
                                        </a>
                                        <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center gap-2 text-sm font-medium hover:text-emerald-200 transition-colors bg-white/10 px-3 py-2 rounded-lg w-fit">
                                            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            +62 812-3456-7890 (WA)
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Roles Explanation -->
                            <div class="space-y-3">
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider border-b border-gray-200 pb-2">Hak Akses Anda</h4>
                                <div class="bg-white px-4 py-3 rounded-xl border border-gray-100 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#eef2ff] flex items-center justify-center text-[#312e81]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 capitalize">{{ $page.props.auth?.user?.role?.replace('_', ' ') || 'Guest' }}</div>
                                        <div class="text-xs text-gray-500">
                                            <template v-if="$page.props.auth?.user?.role === 'super_admin'">Anda memiliki akses penuh ke seluruh fitur dan manajemen sistem.</template>
                                            <template v-else-if="$page.props.auth?.user?.role === 'admin'">Anda dapat mengelola inventaris dan pergerakan stok.</template>
                                            <template v-else>Anda hanya dapat melihat dashboard dan laporan.</template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage();
const isManagementOpen = ref(page.url.startsWith('/management'));
const isMobileMenuOpen = ref(false);
const isDesktopSidebarOpen = ref(true);
const isProfileMenuOpen = ref(false);
const globalSearchQuery = ref('');
const isSearchFocused = ref(false);
const isHelpModalOpen = ref(false);
const isMobileSearchOpen = ref(false);

const allMenus = [
    { title: 'Beranda', url: '/' },
    { title: 'Inventaris Barang', url: '/inventory' },
    { title: 'Pergerakan Stok', url: '/stock-movement' },
    { title: 'Kategori (Manajemen)', url: '/management/category' },
    { title: 'Pengguna (Manajemen)', url: '/management/users' },
    { title: 'Lokasi (Manajemen)', url: '/management/locations' },
];

const filteredMenus = computed(() => {
    if (!globalSearchQuery.value) return [];
    const query = globalSearchQuery.value.toLowerCase();
    return allMenus.filter(menu => menu.title.toLowerCase().includes(query)).slice(0, 5);
});

const toggleSidebar = () => {
    if (window.innerWidth >= 1024) {
        isDesktopSidebarOpen.value = !isDesktopSidebarOpen.value;
    } else {
        isMobileMenuOpen.value = !isMobileMenuOpen.value;
    }
};

const handleSearchBlur = () => {
    setTimeout(() => {
        isSearchFocused.value = false;
    }, 200);
};

const handleGlobalSearch = () => {
    if (!globalSearchQuery.value.trim()) return;

    const query = globalSearchQuery.value.trim();
    if (query.toUpperCase().startsWith('TRX')) {
        router.visit(`/stock-movement?search=${encodeURIComponent(query)}`);
    } else {
        router.visit(`/inventory?search=${encodeURIComponent(query)}`);
    }
};

watch(() => page.url, (newUrl) => {
    if (newUrl.startsWith('/management')) {
        isManagementOpen.value = true;
    }
});

const currentTime = ref('');
const currentDate = ref('');
let timer;
const notificationContainer = ref(null);

const updateClock = () => {
    const now = new Date();
    // Gunakan zona waktu WIB secara explisit
    const optionsTime = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
    const optionsDate = { timeZone: 'Asia/Jakarta', weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };

    currentTime.value = new Intl.DateTimeFormat('id-ID', optionsTime).format(now).replace(/\./g, ':') + ' WIB';
    currentDate.value = new Intl.DateTimeFormat('id-ID', optionsDate).format(now);
};

const closeSidebar = () => {
    isDesktopSidebarOpen.value = false;
    isMobileMenuOpen.value = false;
};

onMounted(() => {
    updateClock();
    timer = setInterval(updateClock, 1000);
    fetchNotifications();
    document.addEventListener('click', handleClickOutside);
    window.addEventListener('close-sidebar', closeSidebar);
});

onUnmounted(() => {
    clearInterval(timer);
    document.removeEventListener('click', handleClickOutside);
    window.removeEventListener('close-sidebar', closeSidebar);
});

// Close mobile menu on page navigation
router.on('navigate', () => {
    isMobileMenuOpen.value = false;
    showNotifications.value = false;
});

// ===== NOTIFICATIONS =====
const showNotifications = ref(false);
const notificationList = ref([]);
const unreadCount = ref(page.props?.unreadNotificationCount || 0);

const toggleNotification = () => {
    showNotifications.value = !showNotifications.value;
    if (showNotifications.value) {
        fetchNotifications();
    }
};

const fetchNotifications = async () => {
    try {
        const res = await fetch('/api/notifications');
        const data = await res.json();
        notificationList.value = data.notifications || [];
        unreadCount.value = data.unread_count || 0;
    } catch (e) {
        notificationList.value = [];
    }
};

const markAllRead = async () => {
    try {
        await fetch('/api/notifications/read-all', { method: 'PUT' });
        notificationList.value = notificationList.value.map(n => ({ ...n, is_read: true }));
        unreadCount.value = 0;
    } catch (e) {
        // silent
    }
};

const markAsRead = async (id) => {
    try {
        await fetch(`/api/notifications/${id}/read`, { method: 'PUT' });
        const idx = notificationList.value.findIndex(n => n.id === id);
        if (idx !== -1) {
            notificationList.value[idx].is_read = true;
        }
        unreadCount.value = notificationList.value.filter(n => !n.is_read).length;
    } catch (e) {
        // silent
    }
};

const handleNotificationClick = async (notif) => {
    if (!notif.is_read) {
        await markAsRead(notif.id);
    }
    if (notif.link) {
        router.visit(notif.link);
    }
    showNotifications.value = false;
};

const relativeTime = (timestamp) => {
    const date = new Date(timestamp);
    const now = new Date();
    const diffMs = now - date;
    const diffMin = Math.floor(diffMs / 60000);
    const diffHour = Math.floor(diffMin / 60);
    const diffDay = Math.floor(diffHour / 24);

    if (diffMin < 1) return 'Baru saja';
    if (diffMin < 60) return `${diffMin} menit lalu`;
    if (diffHour < 24) return `${diffHour} jam lalu`;
    if (diffDay < 7) return `${diffDay} hari lalu`;

    return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
};

// Close notification dropdown on click outside
const handleClickOutside = (event) => {
    if (showNotifications.value && notificationContainer.value && !notificationContainer.value.contains(event.target)) {
        showNotifications.value = false;
    }
};
</script>
