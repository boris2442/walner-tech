<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { Pencil, Trash2 } from 'lucide-vue-next';
import dayjs from 'dayjs';
import { Inertia } from '@inertiajs/inertia';
import FlashMessageFrontend from '@/components/frontend/flash/FlashMessageFrontend.vue';
import { router } from '@inertiajs/vue3';
import BackButton from '@/components/frontend/BackButton.vue';
import { dashboard } from '@/routes';
import users from '@/routes/users';
// Props envoyés depuis UserController@index
const props = defineProps<{
    stats: {
        total: number;
        today: number;
        admins: number;
        clients: number;
        week: number;

    };
    users: {
        data: any[];
        links: any[];
    };
    filters: {
        search?: string;
    };
    roles: string[];
}>();

// Breadcrumb
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'dashboard',
        href: dashboard().url,
    },
    {
        title: 'Users List',
        href: users.index().url,
    },
];

// Recherche côté client
const search = ref(props.filters.search || '');
// Watch pour envoyer la requête à chaque changement
watch(search, (value) => {
    router.get('/admin/users', { search: value }, { preserveState: true, replace: true });
});


// Filtrage client (si besoin, mais le mieux c'est via backend)

const filteredUsers = computed(() => {
    if (!search.value) return props.users.data;
    return props.users.data.filter(u =>
        (u.name ?? '').toLowerCase().includes(search.value.toLowerCase()) ||
        (u.phone ?? '').toLowerCase().includes(search.value.toLowerCase()) ||
        (u.role ?? '').toLowerCase().includes(search.value.toLowerCase()) ||
        (u.email ?? '').toLowerCase().includes(search.value.toLowerCase())
    );
});

// Formatage date
function formatDate(date: string) {
    return dayjs(date).format('DD/MM/YYYY HH:mm');
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

//Supprimer un user
const deleteUser = (id: number) => {
    if (confirm('Voulez-vous vraiment supprimer cette catégorie ?')) {
        Inertia.delete(`/admin/users/${id}`, {
            onSuccess: () => {
                // Optionnel : afficher message ou rafraîchir

            },
            preserveScroll: true
        })
    }
}

function changeRole(userId: number, newRole: string) {
    Inertia.put(`/admin/users/${userId}/role`, { role: newRole }, {
        preserveScroll: true,
        onSuccess: () => {
            //console.log(`Rôle de l'utilisateur ${userId} mis à jour : ${newRole}`);
        },
        onError: (errors) => {
            // console.error(errors);
        }
    });
}
function goToPage(url: string | null) {
    if (!url) return; // pas de lien → on ne fait rien
    router.get(url, {}, { preserveState: true, preserveScroll: true });
}

</script>

<template>
    <FlashMessageFrontend v-if="$page.props.flash?.message" :message="$page.props.flash.message"
        :link="$page.props.flash.link" />

    <Head title="Users List" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4 overflow-x-auto">


            <BackButton class="m-4" />
            <!-- KPI Cards -->
            <div class="grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
                <div class="kpi-card">
                    <div class="kpi-icon">👥</div>
                    <div class="kpi-text">
                        <h3>Total Utilisateurs</h3>
                        <p>{{ props.stats.total }}</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3>Inscrits Aujourd'hui</h3>
                        <p>{{ props.stats.today }}</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">🛡️</div>
                    <div class="kpi-text">
                        <h3>Administrateurs</h3>
                        <p>{{ props.stats.admins }}</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">👤</div>
                    <div class="kpi-text">
                        <h3>Utilisateurs</h3>
                        <p>{{ props.stats.clients }}</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">👤</div>
                    <div class="kpi-text">
                        <h3>Inscrit cette semaine</h3>
                        <p>{{ props.stats.week }}</p>
                    </div>
                </div>
            </div>
            <h1 class="text-xl font-bold mb-4 text-[var(--primary-blue)] dark:text-[var(--dark-gold)] my-2">
                Listes des utilisateurs
            </h1>
            <!-- Table -->
            <div class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border min-h-[50vh]">
                <div class="flex flex-col md:flex-row gap-2 md:gap-4 mb-4 p-2">
                    <!-- <input type="text" v-model="search" placeholder="Rechercher par nom ou contact ou email"
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
                                <!-- <li>
                                    <Link href="/admin/users/create"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
                                    Créer un utilisateur
                                    </Link>
                                </li> -->
                                <li>Rien.A.Signaler</li>
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

                                <th class="p-2">Email</th>
                                <th class="p-2">Téléphone</th>
                                <th class="p-2">Rôle</th>
                                <th class="p-2">Créé le</th>
                                <th class="p-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in filteredUsers" :key="user.id"
                                class="border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="p-2 truncate max-w-[150px]">{{ user.name }}</td>

                                <td class="p-2">{{ user.email }}</td>
                                <td class="p-2">{{ user.phone }}</td>
                                <td class="p-2">
                                    <select v-model="user.role" @change="e => changeRole(user.id, e.target.value)"
                                        class="border rounded px-2 py-1 text-sm">
                                        <option v-for="role in props.roles" :key="role" :value="role">
                                            {{ role }}
                                        </option>
                                    </select>
                                </td>


                                <td class="p-2"><i class="text-xs"> {{ formatDate(user.created_at) }}</i></td>
                                <td class="p-2 flex gap-2">
                                    <!-- <Link :href="`/admin/users/${user.id}/edit`"
                                        class="text-blue-500 hover:text-blue-700" title="Éditer">
                                    <Pencil class="w-4 h-4 md:w-5 md:h-5" />
                                    </Link> -->
                                    <button class="text-red-500 hover:text-red-700" title="Supprimer"
                                        @click="deleteUser(user.id)">
                                        <Trash2 class="w-4 h-4 md:w-5 md:h-5" />
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="filteredUsers.length === 0">
                                <td colspan="7" class="text-center p-4 text-gray-500">
                                    Aucun utilisateur trouvé
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- Pagination -->
                <div class="flex justify-center mt-6 mb-4">
                    <nav class="flex gap-2 mt-4 justify-end">
                        <button v-for="link in props.users.links" :key="link.label" v-html="link.label"
                            :disabled="!link.url"
                            @click.prevent="link.url && router.get(link.url, {}, { preserveState: true })"
                            class="px-3 py-1 border rounded disabled:opacity-50 hover:bg-gray-100 dark:hover:bg-gray-700"></button>
                    </nav>

                </div>

            </div>
        </div>
    </AppLayout>
</template>
