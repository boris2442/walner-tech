<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue'
import { SidebarTrigger } from '@/components/ui/sidebar'
import type { BreadcrumbItemType } from '@/types'
import NotificationBell from './backend/notifications/NotificationBell.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

// Définir un type pour l'utilisateur connecté
interface User {
    id: number
    name: string
    email: string
    role?: string
}

const page = usePage()

// Notifications
const notifications = computed(() => page.props.notifications || [])

// Vérifie si l'utilisateur est admin
const isAdmin = computed(() => (page.props.auth?.user as User)?.role === 'admin')

// Vérifie si la page actuelle est le dashboard admin
// 🔹 Remplace 'backend/admin/Administrateur' par le nom exact de ton composant Inertia
const isDashboardPage = computed(() => page.component === 'backend/admin/Administrateur')



withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItemType[]
    }>(),
    {
        breadcrumbs: () => [],
    }
)
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>

        <!-- 🔹 Notifications uniquement pour admin sur le dashboard -->
        <div v-if="isAdmin && isDashboardPage" class="flex items-center gap-3 absolute right-5">
            <NotificationBell :notifications="notifications" />
        </div>
    </header>
</template>
