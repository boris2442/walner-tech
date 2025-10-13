
<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import type { User } from '@/types';
import { computed } from 'vue';

interface Props {
    user?: User | null;  // <-- rendre nullable
    showEmail?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    showEmail: false,
});

const { getInitials } = useInitials();

// Compute whether we should show the avatar image
const showAvatar = computed(() => props.user?.avatar && props.user.avatar !== '');
</script>

<template>
    <div v-if="props.user" class="flex items-center gap-2">
        <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
            <AvatarImage v-if="showAvatar" :src="props.user.avatar!" :alt="props.user.name" />
            <AvatarFallback class="rounded-lg text-black dark:text-white">
                {{ getInitials(props.user.name) }}
            </AvatarFallback>
        </Avatar>

        <div class="grid flex-1 text-left text-sm leading-tight">
            <span class="truncate font-medium">{{ props.user.name }}</span>
            <span v-if="props.showEmail" class="truncate text-xs text-muted-foreground">{{ props.user.email }}</span>
        </div>
    </div>

    <div v-else class="flex items-center gap-2 text-muted-foreground text-sm">
        <!-- Affichage quand aucun utilisateur n'est connecté -->
        <span>Utilisateur non connecté</span>
    </div>
</template>
