<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from "vue";
import BackButton from '@/components/frontend/BackButton.vue';
import { type BreadcrumbItem } from '@/types';
import FlashMessageFrontend from '@/components/frontend/flash/FlashMessageFrontend.vue';
import { dashboard } from '@/routes';
import dayjs from 'dayjs';

function formatDate(date: string) {
    return dayjs(date).format('DD/MM/YYYY HH:mm');
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Create Category', href: dashboard().url },
];

const props = defineProps({
    descriptions: Array,
    stats: Object,
});

const search = ref("");
const showActions = ref(false);
const expandedItems = ref<number[]>([]); // 🔥 pour suivre les descriptions ouvertes

const filteredDescriptions = computed(() => {
    if (!search.value) return props.descriptions;
    return props.descriptions.filter((desc: any) =>
        desc.product.title.toLowerCase().includes(search.value.toLowerCase())
    );
});

// 🔥 Fonction pour tronquer la description
function truncateText(text: string, length = 100) {
    return text.length > length ? text.substring(0, length) + "..." : text;
}

// 🔥 Gérer le basculement "voir plus / voir moins"
function toggleExpand(id: number) {
    if (expandedItems.value.includes(id)) {
        expandedItems.value = expandedItems.value.filter(i => i !== id);
    } else {
        expandedItems.value.push(id);
    }
}
</script>

<template>
    <FlashMessageFrontend v-if="$page.props.flash?.message" :message="$page.props.flash.message"
        :link="$page.props.flash.link" />

    <Head title="Listes des descriptions" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <BackButton class="m-4" />
          
            <div class="relative min-h-[80vh] flex-1 rounded-xl border p-6">

                <div class="grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
                    <div class="kpi-card">
                        <div class="kpi-icon">🆕</div>
                        <div class="kpi-text">
                            <h3>Total produit à décrire</h3>
                            <p> {{ props.stats.totalADecrit }}</p>
                        </div>
                    </div>
                    <div class="kpi-card">
                        <div class="kpi-icon">🆕</div>
                        <div class="kpi-text">
                            <h3>Descriptions deja effectuée</h3>
                            <p> {{ props.stats.totalDescriptions }}</p>
                        </div>
                    </div>
                    <div class="kpi-card">
                        <div class="kpi-icon">🆕</div>
                        <div class="kpi-text">
                            <h3>Produits sans description</h3>
                            <p> {{ props.stats.totalWithoutDescription }}</p>
                        </div>
                    </div>

                </div>

                <h1 class="text-xl font-bold mb-4 text-[var(--primary-blue)] dark:text-[var(--dark-gold)] my-2">
                    Descriptions des produits
                </h1>

                <div class="relative border rounded-xl min-h-[50vh]">
                    <div class="flex flex-col md:flex-row gap-4 mb-4 p-2">
                        <div class="relative w-full">
                            <input v-model="search" type="text" placeholder="Search..." class="custom-input" />
                            <font-awesome-icon icon="magnifying-glass" class="custom-icon" />
                            <button v-if="search" @click="search = ''" type="button" class="clear-btn">✕</button>
                        </div>

                        <div class="relative">
                            <button @click="showActions = !showActions"
                                class="p-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700">⋮</button>

                            <div v-if="showActions"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border rounded shadow-lg z-50">
                                <ul>
                                    <li>
                                        <Link href="/admin/products/descriptions/create"
                                            class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
                                        Créer une description
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="desc in filteredDescriptions" :key="desc.id"
                            class="border p-4 rounded shadow hover:shadow-lg transition">
                            <h3 class="font-bold text-lg mb-2">
                                Produit : {{ desc.product.title }}
                            </h3>

                            <!-- 🔥 Affichage dynamique du texte -->
                            <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                                Description :
                                <span>
                                    {{
                                        expandedItems.includes(desc.id)
                                            ? desc.content
                                            : truncateText(desc.content)
                                    }}
                                </span>
                                <button v-if="desc.content.length > 100" @click="toggleExpand(desc.id)"
                                    class="text-blue-600 hover:underline ml-2">
                                    {{ expandedItems.includes(desc.id) ? 'Voir moins' : 'Voir plus' }}
                                </button>
                            </p>

                            <p>
                                <i class="text-xs">Créé le {{ formatDate(desc.created_at) }}</i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
