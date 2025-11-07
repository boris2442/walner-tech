<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import categoriesRoutes from '@/routes/categories';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import dayjs from 'dayjs';

import BackButton from '@/components/frontend/BackButton.vue';
import { dashboard } from '@/routes';
import { Inertia } from '@inertiajs/inertia';
import newsletter from '@/routes/admin/newsletter'
defineProps({
    newsletterList: Array,
    totalEmailNewsletter: Number,
})
// Breadcrumb
const breadcrumbs: BreadcrumbItem[] = [

    {
        title: 'dashboard',
        href: dashboard().url,
    },

    {
        title: 'NewsLetter List',
        href: newsletter.index().url
    }
];
// Formatage date
function formatDate(date: string) {
    return dayjs(date).format('DD/MM/YYYY HH:mm');
}
</script>

<template>


    <Head title="Newsletter list" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4 overflow-x-auto">
            <BackButton class="m-4" />
            <!-- KPI Cards -->

            <div class="grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 ">

               
                
                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3>Total Email</h3>
                        <p> {{ totalEmailNewsletter }}</p>
                    </div>
                </div>


            </div>
            <h1 class="text-xl font-bold mb-4 text-[var(--primary-blue)] dark:text-[var(--dark-gold)] my-2">
                Email NewsLetters List
            </h1>
            <!-- Recherche + Tableau -->
            <div class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border min-h-[50vh]">


                <div class="overflow-x-auto">
                    <table
                        class="w-full text-left border-collapse text-[0.75rem] sm:text-[0.75rem] md:text-[0.875rem] lg:text-[0.875rem]">
                        <thead>
                            <tr class="border-b">
                                <th class="p-2">Id</th>
                                <th class="p-2">Email</th>
                                <th class="p-2">Créé le</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="newletter in newsletterList" :key="newletter.id"
                                class="border-b hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="p-2 truncate max-w-[150px]">#{{ newletter.id }}</td>
                                <td class="p-2 truncate max-w-[250px]">{{ newletter.email }}</td>
                                <td class="p-2"><i class="text-xs"> {{ formatDate(newletter.created_at) }}</i></td>

                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
