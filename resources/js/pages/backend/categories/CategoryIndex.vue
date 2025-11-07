<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import categoriesRoutes from '@/routes/categories';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Pencil, Trash2 } from 'lucide-vue-next';
import dayjs from 'dayjs';
import FlashMessageFrontend from '@/components/frontend/flash/FlashMessageFrontend.vue';
import BackButton from '@/components/frontend/BackButton.vue';
import { dashboard } from '@/routes';
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
        title: 'dashboard',
        href: dashboard().url,
    },

    {
        title: 'Categories List',
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
                // console.log('Supprimé avec succès')
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
    <FlashMessageFrontend v-if="$page.props.flash?.message" :message="$page.props.flash.message"
        :link="$page.props.flash.link" />

    <Head title="Categories" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4 overflow-x-auto">
            <BackButton class="m-4" />
            <!-- KPI Cards -->

            <div class="grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">

                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3 class="text-2xl">Total Catégories</h3>
                        <p> {{ stats.total }}</p>
                    </div>
                </div>

            </div>
            <h1 class="text-xl font-bold mb-4 text-[var(--primary-blue)] dark:text-[var(--dark-gold)] my-2">
                Categories List
            </h1>
            <!-- Recherche + Tableau -->
            <div class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border min-h-[50vh]">
                <div class="flex flex-col md:flex-row gap-2 md:gap-4 mb-4 p-2 ">
                    <!-- <input type="text" v-model="search" placeholder="Rechercher par nom"
                        class="border p-2 rounded flex-1 text-xs sm:text-sm md:text-base" /> -->
                    <div class="relative w-full">

                        <input v-model="search" type="text" placeholder="Search..." class="custom-input" />
                        <font-awesome-icon icon="magnifying-glass" class="custom-icon" />
                        <!-- Croix pour vider l'input, seulement si search n'est pas vide -->
                        <button v-if="search" @click="search = ''" type="button" class="clear-btn">
                            ✕
                        </button>
                    </div>




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
                                    <Link :href="categoriesRoutes.create().url" prefetch
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
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
                                <td class="p-2"><i class="text-xs">{{ formatDate(cat.created_at) }}</i></td>
                                <td class="p-2"><i class="text-xs">{{ formatDate(cat.updated_at) }}</i></td>
                                <td class="p-2 flex gap-2">
                                    <Link prefetch :href="`/admin/categories/${cat.id}/edit`"
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
