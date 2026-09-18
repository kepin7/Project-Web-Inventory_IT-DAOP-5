<template>
    <Head title="Manajemen Pengguna" />
    <DashboardLayout>
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-[28px] font-medium text-gray-800">Manajemen Pengguna</h1>
                <p class="text-gray-400 text-sm mt-1">Kelola akun dan undangan akses sistem</p>
            </div>
            <button @click="isInviteModalOpen = true"
                class="px-5 py-2.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white text-sm font-medium rounded-lg shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Undang Admin
            </button>
        </div>

        <!-- Flash Messages -->
        <div v-if="$page.props.flash?.success" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash?.error" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $page.props.flash.error }}
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-900">Daftar Pengguna</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 text-xs font-semibold uppercase">
                            <th class="px-6 py-4 text-left">Nama</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Role</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Login Terakhir</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-[#eef2ff] text-[#312e81] flex items-center justify-center font-bold text-sm">
                                        {{ user.name.charAt(0).toUpperCase() }}
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ user.name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ user.email }}</td>
                            <td class="px-6 py-4">
                                <span :class="user.role === 'super_admin'
                                    ? 'bg-[#1e1b4b] text-white'
                                    : 'bg-blue-100 text-blue-700'"
                                    class="px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wide">
                                    {{ user.role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span :class="user.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500'"
                                    class="px-2.5 py-1 rounded-md text-[11px] font-semibold">
                                    {{ user.is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs">
                                {{ user.last_login_at ? formatDate(user.last_login_at) : 'Belum pernah login' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="openEditModal(user)"
                                        class="p-1.5 text-gray-400 hover:text-[#312e81] hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>

                                    <button v-if="user.role !== 'super_admin'"
                                        @click="toggleActive(user)"
                                        :title="user.is_active ? 'Nonaktifkan' : 'Aktifkan'"
                                        :class="user.is_active ? 'text-orange-400 hover:text-orange-600 hover:bg-orange-50' : 'text-emerald-500 hover:text-emerald-700 hover:bg-emerald-50'"
                                        class="p-1.5 rounded-lg transition-colors">
                                        <svg v-if="user.is_active" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </button>
                                    <span v-else class="p-1.5 text-gray-300 w-7 flex justify-center">—</span>

                                    <button @click="deleteUser(user)"
                                        class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pending Invitations -->
        <div v-if="invitations.length > 0" class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-900">Undangan Tertunda</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 text-xs font-semibold uppercase">
                            <th class="px-6 py-4 text-left">Nama</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-left">Kadaluarsa</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="inv in invitations" :key="inv.id" class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ inv.name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ inv.email }}</td>
                            <td class="px-6 py-4">
                                <span :class="{
                                    'bg-yellow-100 text-yellow-700': inv.status === 'menunggu',
                                    'bg-red-100 text-red-600': inv.status === 'kadaluarsa',
                                }" class="px-2.5 py-1 rounded-md text-[11px] font-semibold capitalize">
                                    {{ inv.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs">{{ formatDate(inv.expires_at) }}</td>
                            <td class="px-6 py-4 text-right">
                                <button @click="cancelInvitation(inv.id)"
                                    class="text-xs font-semibold text-red-500 hover:text-red-700 transition-colors">
                                    Batalkan
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Invite Modal -->
        <Teleport to="body">
            <div v-if="isInviteModalOpen" class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center p-4" @click.self="isInviteModalOpen = false">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Undang Admin Baru</h3>
                    <p class="text-sm text-gray-400 mb-6">Link undangan akan dikirim ke email yang dituju</p>

                    <form @submit.prevent="submitInvite" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Lengkap</label>
                            <input v-model="inviteForm.name" type="text" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#312e81] focus:border-transparent outline-none"
                                placeholder="Nama Admin">
                            <p v-if="inviteForm.errors.name" class="mt-1 text-xs text-red-500">{{ inviteForm.errors.name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email</label>
                            <input v-model="inviteForm.email" type="email" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#312e81] focus:border-transparent outline-none"
                                placeholder="admin@daop5.co.id">
                            <p v-if="inviteForm.errors.email" class="mt-1 text-xs text-red-500">{{ inviteForm.errors.email }}</p>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="isInviteModalOpen = false"
                                class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit" :disabled="inviteForm.processing"
                                class="flex-1 px-4 py-2.5 bg-[#1e1b4b] text-white text-sm font-medium rounded-xl hover:bg-[#312e81] transition-colors disabled:opacity-60">
                                {{ inviteForm.processing ? 'Mengirim...' : 'Kirim Undangan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
        <!-- Edit Modal -->
        <Teleport to="body">
            <div v-if="isEditModalOpen" class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center p-4" @click.self="isEditModalOpen = false">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Edit Pengguna</h3>
                    <p class="text-sm text-gray-400 mb-6">Perbarui data atau role pengguna ini.</p>

                    <form @submit.prevent="submitEdit" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Lengkap</label>
                            <input v-model="editForm.name" type="text" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#312e81] focus:border-transparent outline-none">
                            <p v-if="editForm.errors.name" class="mt-1 text-xs text-red-500">{{ editForm.errors.name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Email</label>
                            <input v-model="editForm.email" type="email" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#312e81] focus:border-transparent outline-none">
                            <p v-if="editForm.errors.email" class="mt-1 text-xs text-red-500">{{ editForm.errors.email }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Role</label>
                            <select v-model="editForm.role" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#312e81] focus:border-transparent outline-none appearance-none">
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                            <p v-if="editForm.errors.role" class="mt-1 text-xs text-red-500">{{ editForm.errors.role }}</p>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="isEditModalOpen = false"
                                class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit" :disabled="editForm.processing"
                                class="flex-1 px-4 py-2.5 bg-[#312e81] text-white text-sm font-medium rounded-xl hover:bg-[#1e1b4b] transition-colors disabled:opacity-60">
                                {{ editForm.processing ? 'Menyimpan...' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
    </DashboardLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

const props = defineProps({
    users: Array,
    invitations: Array,
});

const isInviteModalOpen = ref(false);

const inviteForm = useForm({
    name: '',
    email: '',
});

const submitInvite = () => {
    inviteForm.post('/management/users/invite', {
        onSuccess: () => {
            isInviteModalOpen.value = false;
            inviteForm.reset();
        },
    });
};

const toggleActive = (user) => {
    router.patch(`/management/users/${user.id}/toggle-active`, {}, { preserveScroll: true });
};

const cancelInvitation = (id) => {
    router.delete(`/management/users/invitations/${id}`, { preserveScroll: true });
};

const formatDate = (dateString) => {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit',
    });
};

const isEditModalOpen = ref(false);
const editingUser = ref(null);

const editForm = useForm({
    name: '',
    email: '',
    role: '',
});

const openEditModal = (user) => {
    editingUser.value = user;
    editForm.name = user.name;
    editForm.email = user.email;
    editForm.role = user.role;
    editForm.clearErrors();
    isEditModalOpen.value = true;
};

const submitEdit = () => {
    editForm.put(`/management/users/${editingUser.value.id}`, {
        onSuccess: () => {
            isEditModalOpen.value = false;
        },
    });
};

const deleteUser = (user) => {
    if (window.Swal) {
        window.Swal.fire({
            title: 'Hapus Pengguna?',
            text: `Anda yakin ingin menghapus akun ${user.name}? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-5 py-2.5 text-sm font-bold',
                cancelButton: 'rounded-xl px-5 py-2.5 text-sm font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(`/management/users/${user.id}`, { preserveScroll: true });
            }
        });
    } else {
        if (confirm(`Hapus pengguna ${user.name}?`)) {
            router.delete(`/management/users/${user.id}`, { preserveScroll: true });
        }
    }
};
</script>
