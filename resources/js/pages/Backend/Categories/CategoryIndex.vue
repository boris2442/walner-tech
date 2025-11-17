<script setup lang="ts">
import BackButton from '@/components/frontend/BackButton.vue';
import FlashMessageFrontend from '@/components/frontend/flash/FlashMessageFrontend.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import categoriesRoutes from '@/routes/categories';
import { type BreadcrumbItem } from '@/types';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import { Pencil, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';
interface Category {
    id: number;
    name: string;
    description: string;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    stats: {
        total: number;
    };
    categories: Category[];
}>();

// Breadcrumb
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'dashboard',
        href: dashboard().url,
    },

    {
        title: 'Categories List',
        href: categoriesRoutes.index().url,
    },
];

// Recherche côté client
const search = ref('');

const filteredCategories = computed(() => {
    if (!search.value) return props.categories;
    return props.categories.filter((c) => c.name.toLowerCase().includes(search.value.toLowerCase()));
});

// Formatage date
function formatDate(date: string) {
    return dayjs(date).format('DD/MM/YYYY HH:mm');
}
const deleteCategory = (id: number) => {
    if (confirm('Voulez-vous vraiment supprimer cette catégorie ?')) {
        Inertia.delete(`/admin/categories/${id}`, {
            onSuccess: () => {
                // Optionnel : afficher message ou rafraîchir
                // console.log('Supprimé avec succès')
            },
            preserveScroll: true,
        });
    }
};
const showActions = ref(false);

// Fermer le menu si clic à l'extérieur
function handleClickOutside(event: MouseEvent) {
    const target = event.target as HTMLElement;
    if (!target.closest('.relative')) {
        showActions.value = false;
    }
}
document.addEventListener('click', handleClickOutside);
</script>

<template>
    <FlashMessageFrontend v-if="$page.props.flash?.message" :message="$page.props.flash.message" :link="$page.props.flash.link" />

    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 overflow-x-auto p-4">
            <BackButton class="m-4" />
            <!-- KPI Cards -->

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3 class="text-2xl">Total Catégories</h3>
                        <p>{{ stats.total }}</p>
                    </div>
                </div>
            </div>
            <h1 class="my-2 mb-4 text-xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Categories List</h1>
            <!-- Recherche + Tableau -->
            <div class="relative min-h-[50vh] rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <div class="mb-4 flex flex-col gap-2 p-2 md:flex-row md:gap-4">
                    <!-- <input type="text" v-model="search" placeholder="Rechercher par nom"
                        class="border p-2 rounded flex-1 text-xs sm:text-sm md:text-base" /> -->
                    <div class="relative w-full">
                        <input v-model="search" type="text" placeholder="Search..." class="custom-input" />
                        <font-awesome-icon icon="magnifying-glass" class="custom-icon" />
                        <!-- Croix pour vider l'input, seulement si search n'est pas vide -->
                        <button v-if="search" @click="search = ''" type="button" class="clear-btn">✕</button>
                    </div>

                    <!-- Menu Actions -->
                    <div class="relative">
                        <button @click="showActions = !showActions" class="rounded border p-2 hover:bg-gray-100 dark:hover:bg-gray-700">⋮</button>

                        <div v-if="showActions" class="absolute right-0 z-50 mt-2 w-48 rounded border bg-white shadow-lg dark:bg-gray-800">
                            <ul>
                                <li>
                                    <Link
                                        :href="categoriesRoutes.create().url"
                                        prefetch
                                        class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                    >
                                        Créer une catégorie
                                    </Link>
                                </li>
                                <!-- Ajouter d'autres actions si besoin -->
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left text-[0.75rem] sm:text-[0.75rem] md:text-[0.875rem] lg:text-[0.875rem]">
                        <thead>
                            <tr class="border-b">
                                <th class="p-2">Nom</th>
                                <th class="p-2">Description</th>
                                <th class="p-2">Créé le</th>
                                <th class="p-2">Mis à jour</th>
                                <th class="p-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cat in filteredCategories" :key="cat.id" class="border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="max-w-[150px] truncate p-2">{{ cat.name }}</td>
                                <td class="max-w-[250px] truncate p-2">{{ cat.description }}</td>
                                <td class="p-2">
                                    <i class="text-xs">{{ formatDate(cat.created_at) }}</i>
                                </td>
                                <td class="p-2">
                                    <i class="text-xs">{{ formatDate(cat.updated_at) }}</i>
                                </td>
                                <td class="flex gap-2 p-2">
                                    <Link
                                        prefetch
                                        :href="`/admin/categories/${cat.id}/edit`"
                                        class="text-blue-500 hover:text-blue-700"
                                        title="Éditer"
                                    >
                                        <Pencil class="h-4 w-4 md:h-5 md:w-5" />
                                    </Link>
                                    <button class="text-red-500 hover:text-red-700" title="Supprimer" @click="deleteCategory(cat.id)">
                                        <Trash2 class="h-4 w-4 md:h-5 md:w-5" />
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="filteredCategories.length === 0">
                                <td colspan="5" class="p-4 text-center text-gray-500">Aucune catégorie trouvée</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
