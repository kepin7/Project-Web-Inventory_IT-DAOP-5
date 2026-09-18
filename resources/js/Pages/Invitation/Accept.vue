<template>
    <Head title="Terima Undangan — Sistem Inventaris IT DAOP 5" />
    <div class="min-h-screen bg-gradient-to-br from-[#1e1b4b] to-[#312e81] flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center">
            <div class="w-16 h-16 bg-[#eef2ff] rounded-2xl flex items-center justify-center mx-auto mb-6">
                <img src="/logo.svg" alt="KAI Logo" class="h-10 w-auto object-contain">
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang, {{ invitation.name }}!</h1>
            <p class="text-gray-500 text-sm mb-2">Anda diundang sebagai <strong>Admin</strong> di</p>
            <p class="text-[#312e81] font-bold text-base mb-8">Sistem Inventaris IT DAOP 5</p>

            <div class="bg-gray-50 rounded-xl p-4 text-left mb-8">
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-400">Nama</span>
                    <span class="font-semibold text-gray-800">{{ invitation.name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Email</span>
                    <span class="font-semibold text-gray-800">{{ invitation.email }}</span>
                </div>
            </div>

            <p class="text-xs text-gray-400 mb-6">Dengan menekan tombol di bawah, Anda menyetujui akses ke sistem dan akun Anda akan langsung aktif tanpa password.</p>

            <form @submit.prevent="accept">
                <button type="submit" :disabled="loading"
                    class="w-full py-3.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white font-semibold rounded-xl transition-colors disabled:opacity-60 flex items-center justify-center gap-2">
                    <svg v-if="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    {{ loading ? 'Memproses...' : 'Terima Undangan & Masuk' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    invitation: Object,
});

const loading = ref(false);

const accept = () => {
    loading.value = true;
    router.post(`/invite/${props.invitation.token}`, {}, {
        onFinish: () => { loading.value = false; },
    });
};
</script>
