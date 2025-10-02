<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import categoriesRoutes from '@/routes/categories';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Pencil, Trash2 } from 'lucide-vue-next';
import dayjs from 'dayjs';
// import FlashMessage from '@/components/frontend/flash/FlashMessage.vue';
// const flashMessage = ref("");

import { Inertia } from '@inertiajs/inertia';
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
        title: 'Categories',
        href: categoriesRoutes.index().url
    }
];

// Recherche côté client
const search = ref('');

const filteredCategories = computed(() => {
    if (!search.value) return props.categories;
    return props.categories.filter(c =>
        c.name.toLowerCase().includes(search.value.toLowerCase())
    );
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
                console.log('Supprimé avec succès')
            },
            preserveScroll: true
        })
    }
}
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

    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4 overflow-x-auto">
            <!-- <FlashMessage v-if="flashMessage" :message="flashMessage" type="success" /> -->
            <!-- KPI Cards -->

            <div class="grid gap-4 md:grid-cols-5 sm:grid-cols-2 ">
                <div class="kpi-card max-w-[200px] dark:border-sidebar-border ">
                    <div class="kpi-icon">
                        <!-- Exemple d'icône, tu peux mettre Lucide ou FontAwesome -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                    </div>
                    <div class="kpi-text">
                        <h3>Total Catégories</h3>
                        <p>{{ stats.total }}</p>
                    </div>
                </div>
            </div>
            <!-- Recherche + Tableau -->
            <div class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border min-h-[50vh]">
                <div class="flex flex-col md:flex-row gap-2 md:gap-4 mb-4 p-2">
                    <input type="text" v-model="search" placeholder="Rechercher par nom"
                        class="border p-2 rounded flex-1 text-xs sm:text-sm md:text-base" />

                    <!-- Menu Actions -->
                    <div class="relative">
                        <button @click="showActions = !showActions"
                            class="p-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                            ⋮
                        </button>

                        <div v-if="showActions"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border rounded shadow-lg z-50">
                            <ul>
                                <li>
                                    <Link :href="categoriesRoutes.create().url"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Créer une catégorie
                                    </Link>
                                </li>
                                <!-- Ajouter d'autres actions si besoin -->
                            </ul>
                        </div>
                    </div>


                </div>

                <div class="overflow-x-auto">
                    <table
                        class="w-full text-left border-collapse text-[0.75rem] sm:text-[0.75rem] md:text-[0.875rem] lg:text-[0.875rem]">
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
                            <tr v-for="cat in filteredCategories" :key="cat.id"
                                class="border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="p-2 truncate max-w-[150px]">{{ cat.name }}</td>
                                <td class="p-2 truncate max-w-[250px]">{{ cat.description }}</td>
                                <td class="p-2">{{ formatDate(cat.created_at) }}</td>
                                <td class="p-2">{{ formatDate(cat.updated_at) }}</td>
                                <td class="p-2 flex gap-2">
                                    <Link :href="`/admin/categories/${cat.id}/edit`"
                                        class="text-blue-500 hover:text-blue-700" title="Éditer">
                                    <Pencil class="w-4 h-4 md:w-5 md:h-5" />
                                    </Link>
                                    <button class="text-red-500 hover:text-red-700" title="Supprimer"
                                        @click="deleteCategory(cat.id)">
                                        <Trash2 class="w-4 h-4 md:w-5 md:h-5" />
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="filteredCategories.length === 0">
                                <td colspan="5" class="text-center p-4 text-gray-500">Aucune catégorie trouvée</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.kpi-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-radius: 0.75rem;
    border: 1px solid #cbd5e1;
    /* équivalent border-sidebar-border/70 */

    /* clair, mode clair */
    min-height: 80px;
    transition: transform 0.2s;
}

.kpi-card:hover {
    transform: translateY(-2px);
}

.kpi-icon {
    flex-shrink: 0;
}

.kpi-text h3 {
    font-size: 0.875rem;
    font-weight: 600;

    margin-bottom: 0.25rem;
}

.kpi-text p {
    font-size: 1.25rem;
    font-weight: 700;
    /* color: #0f172a; */
}

/* Responsive */
@media (max-width: 768px) {
    .kpi-card {
        justify-content: flex-start;
        width: 100%;
    }
}
</style>