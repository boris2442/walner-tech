<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
  import BackButton from '@/components/frontend/BackButton.vue';
defineProps<{
    messages: Array<{
        id: number
        name: string
        email: string
        subject: string
        message: string
        created_at: string
    }>
    totalMessages: number
    messagesThisWeek: number
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contacts',
        href: dashboard().url,
    },
];
</script>

<template>

    <Head title="Messages" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
          

  <BackButton class="m-4" />
            <!-- KPI Cards -->
            <div class="grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">

                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3>Total Messages</h3>
                        <p>{{ totalMessages }}</p>
                    </div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-icon">🆕</div>
                    <div class="kpi-text">
                        <h3>Total Messages semaine </h3>
                        <p>{{ messagesThisWeek }}</p>
                    </div>
                </div>

            </div>

            <!-- Section Messages -->
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-6">
                <h1 class="text-lg font-semibold mb-4">📩 Liste des messages</h1>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div v-for="msg in messages" :key="msg.id"
                        class="bg-white dark:bg-sidebar rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <h3 class="font-semibold text-lg">{{ msg.name }}</h3>
                        <p class="text-sm text-gray-500">{{ msg.email }}</p>
                        <p class="mt-2 text-sm font-medium">Sujet : {{ msg.subject }}</p>
                        <p class="mt-2 text-gray-700 dark:text-gray-300">{{ msg.message }}</p>
                        <p class="mt-3 text-xs text-gray-400">Reçu le : {{ new Date(msg.created_at).toLocaleString() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style scoped>

</style>