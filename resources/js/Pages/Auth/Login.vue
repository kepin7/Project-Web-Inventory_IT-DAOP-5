<template>
    <Head title="Masuk — Sistem Inventaris IT DAOP 5" />
    <div class="min-h-screen bg-gradient-to-br from-[#1e1b4b] to-[#312e81] flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 text-center">
            <div class="w-16 h-16 bg-[#eef2ff] rounded-2xl flex items-center justify-center mx-auto mb-6">
                <img src="/logo.svg" alt="KAI Logo" class="h-10 w-auto object-contain">
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Masuk ke Sistem</h1>
            <p class="text-gray-500 text-sm mb-6">Masukkan email Anda untuk mendapatkan tautan masuk tanpa password.</p>

            <!-- Pesan Sukses -->
            <div v-if="$page.props.flash?.success" class="mb-6 p-4 bg-emerald-50 rounded-xl text-emerald-700 text-sm text-left border border-emerald-200">
                {{ $page.props.flash.success }}
            </div>

            <!-- Pesan Error -->
            <div v-if="$page.props.flash?.error" class="mb-6 p-4 bg-red-50 rounded-xl text-red-700 text-sm text-left border border-red-200">
                {{ $page.props.flash.error }}
            </div>

            <form @submit.prevent="submit" class="text-left space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                    <input v-model="form.email" type="email" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#312e81] focus:border-transparent outline-none"
                        placeholder="contoh@daop5.co.id">
                    <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</p>
                </div>

                <button type="submit" :disabled="form.processing"
                    class="w-full py-3.5 bg-[#1e1b4b] hover:bg-[#312e81] text-white font-semibold rounded-xl transition-colors disabled:opacity-60 flex items-center justify-center mt-2">
                    {{ form.processing ? 'Mengirim...' : 'Kirim Tautan Masuk' }}
                </button>
            </form>
            
            <div class="mt-8 pt-6 border-t border-gray-100">
                <Link href="/" class="text-sm text-gray-400 hover:text-[#312e81] font-medium transition-colors">
                    &larr; Kembali ke Dashboard Guest
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
});

const submit = () => {
    form.post('/login', {
        onSuccess: () => form.reset('email'),
    });
};
</script>