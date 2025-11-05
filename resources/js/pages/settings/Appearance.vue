<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import BackButton from '@/components/frontend/BackButton.vue';
import { appearance } from '@/routes';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: appearance().url,
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
  <BackButton class="m-4" />
        <Head title="Parametre d'apparence" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Parametre d'apparence"
                    description="Mettre à jour les paramètres d'apparence de votre compte" />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
