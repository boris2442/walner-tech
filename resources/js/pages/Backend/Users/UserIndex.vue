<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Pencil, Trash2 } from 'lucide-vue-next';
import dayjs from 'dayjs';
import { Inertia } from '@inertiajs/inertia';

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
        title: 'Users',
        href: '/admin/users',
    },
];

// Recherche côté client
const search = ref(props.filters.search || '');

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
                console.log('Supprimé avec succès')
            },
            preserveScroll: true
        })
    }
}

function changeRole(userId: number, newRole: string) {
    Inertia.put(`/admin/users/${userId}/role`, { role: newRole }, {
        preserveScroll: true,
        onSuccess: () => {
            console.log(`Rôle de l'utilisateur ${userId} mis à jour : ${newRole}`);
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}
</script>

<template>

    <Head title="Users" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4 overflow-x-auto">

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

            <!-- Table -->
            <div class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border min-h-[50vh]">
                <div class="flex flex-col md:flex-row gap-2 md:gap-4 mb-4 p-2">
                    <input type="text" v-model="search" placeholder="Rechercher par nom ou contact ou email"
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
                                    <Link href="/admin/users/create"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Créer un utilisateur
                                    </Link>
                                </li>
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
                                <!-- <td class="p-2">{{ user.role }}</td> -->
                                <!-- <td class="p-2">
                                    <select :value="user.role" @change="e => changeRole(user.id, e.target.value)"
                                        class="border rounded p-1 text-sm">
                                        <option v-for="role in props.roles" :key="role" :value="role">
                                            {{ role }}
                                        </option>
                                    </select>
                                </td> -->


                                <!-- <td class="p-2">
                                    <select v-model="user.role" @change="updateRole(user)"
                                        class="border rounded px-2 py-1 text-sm">
                                        <option v-for="role in props.roles" :key="role" :value="role">
                                            {{ role }}
                                        </option>
                                    </select>
                                </td> -->
                                <!-- <td class="p-2">
                                    <select v-model="user.role" @change="() => changeRole(user.id, user.role)"
                                        class="border rounded px-2 py-1 text-sm">
                                        <option v-for="role in props.roles" :key="role" :value="role">
                                            {{ role }}
                                        </option>
                                    </select>
                                </td> -->

                                <td class="p-2">
                                    <select v-model="user.role" @change="e => changeRole(user.id, e.target.value)"
                                        class="border rounded px-2 py-1 text-sm">
                                        <option v-for="role in props.roles" :key="role" :value="role">
                                            {{ role }}
                                        </option>
                                    </select>
                                </td>


                                <td class="p-2">{{ formatDate(user.created_at) }}</td>
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
                    <!-- <div class="mt-4 flex justify-end">
                        <nav class="flex items-center gap-1">
                            <button v-for="link in props.users.links" :key="link.label" v-html="link.label"
                                :disabled="!link.url"
                                @click.prevent="link.url && Inertia.get(link.url, {}, { preserveState: true })"
                                class="px-3 py-1 rounded border bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50"></button>
                        </nav>
                    </div> -->





                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style scoped>
.kpi-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 1rem;
    /* plus compact que before */
    border-radius: 0.5rem;
    border: 1px solid #cbd5e1;
    min-height: 60px;
    /* un peu plus petit */
    transition: transform 0.2s;
    font-size: 0.875rem;
    /* taille de texte plus petite */
}

.kpi-card:hover {
    transform: translateY(-1px);
}

.kpi-icon {
    font-size: 1.25rem;
    /* icône plus petite */
}

.kpi-text h3 {
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 0.1rem;
}

.kpi-text p {
    font-size: 1rem;
    font-weight: 700;
}
</style>