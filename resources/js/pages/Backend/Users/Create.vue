<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

// Props envoyés depuis UserController@create
const props = defineProps<{
    roles: string[];
}>();

// Breadcrumb
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Users', href: '/admin/users' },
    { title: 'Créer', href: '/admin/users/create' },
];

// Formulaire avec Inertia
const form = useForm({
    name: '',
    email: '',
    phone: '',
    role: props.roles[0] ?? 'user',
    password: '',
    password_confirmation: '',
});

// Fonction pour soumettre le formulaire
const submit = () => {
    form.post('/admin/users', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>

    <Head title="Créer un utilisateur" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-xl mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Créer un utilisateur</h1>

            <form @submit.prevent="submit" class="space-y-4">

                <!-- Nom -->
                <div>
                    <label class="block text-sm font-medium">Nom</label>
                    <input type="text" v-model="form.name" class="mt-1 block w-full border rounded p-2" />
                    <span class="text-red-500 text-xs">{{ form.errors.name }}</span>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" v-model="form.email" class="mt-1 block w-full border rounded p-2" />
                    <span class="text-red-500 text-xs">{{ form.errors.email }}</span>
                </div>

                <!-- Téléphone -->
                <div>
                    <label class="block text-sm font-medium">Téléphone</label>
                    <input type="text" v-model="form.phone" class="mt-1 block w-full border rounded p-2" />
                    <span class="text-red-500 text-xs">{{ form.errors.phone }}</span>
                </div>

                <!-- Rôle -->
                <div>
                    <label class="block text-sm font-medium">Rôle</label>
                    <select v-model="form.role" class="mt-1 block w-full border rounded p-2">
                        <option v-for="role in props.roles" :key="role" :value="role">{{ role }}</option>
                    </select>
                    <span class="text-red-500 text-xs">{{ form.errors.role }}</span>
                </div>

                <!-- Mot de passe -->
                <div>
                    <label class="block text-sm font-medium">Mot de passe</label>
                    <input type="password" v-model="form.password" class="mt-1 block w-full border rounded p-2" />
                    <span class="text-red-500 text-xs">{{ form.errors.password }}</span>
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <label class="block text-sm font-medium">Confirmer le mot de passe</label>
                    <input type="password" v-model="form.password_confirmation"
                        class="mt-1 block w-full border rounded p-2" />
                    <span class="text-red-500 text-xs">{{ form.errors.password_confirmation }}</span>
                </div>

                <!-- Bouton -->
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        :disabled="form.processing">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Styles simples pour formulaire */
</style>
