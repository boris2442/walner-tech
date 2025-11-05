<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.vue';
import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { disable, enable, show } from '@/routes/two-factor';
import { BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';
import { ShieldBan, ShieldCheck } from 'lucide-vue-next';
import { onUnmounted, ref } from 'vue';
import BackButton from '@/components/frontend/BackButton.vue';

interface Props {
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
}

withDefaults(defineProps<Props>(), {
    requiresConfirmation: false,
    twoFactorEnabled: false,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Two-Factor Authentication',
        href: show.url(),
    },
];

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

onUnmounted(() => {
    clearTwoFactorAuthData();
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <BackButton class="m-4" />

        <Head title="Two-Factor Authentication" />
        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Two-Factor Authentication"
                    description="Manage your two-factor authentication settings" />

                <div v-if="!twoFactorEnabled" class="flex flex-col items-start justify-start space-y-4">
                    <Badge variant="destructive">Disabled</Badge>

                    <p class="text-muted-foreground">
                        Lorsque vous activez l'authentification à deux facteurs, un code PIN sécurisé vous sera demandé
                        lors de la connexion. Ce code PIN peut être récupéré depuis une application compatible TOTP sur
                        votre téléphone.
                    </p>

                    <div>
                        <Button v-if="hasSetupData" @click="showSetupModal = true">
                            <ShieldCheck />Continuer la configuration
                        </Button>
                        <Form v-else v-bind="enable.form()" @success="showSetupModal = true" #default="{ processing }">
                            <Button type="submit" :disabled="processing">
                                <ShieldCheck />Activer 2FA
                            </Button>
                        </Form>
                    </div>
                </div>

                <div v-else class="flex flex-col items-start justify-start space-y-4">
                    <Badge variant="default">Activé</Badge>

                    <p class="text-muted-foreground">
                        Lorsque l'authentification à deux facteurs est activée, un code PIN aléatoire et sécurisé vous
                        sera demandé lors de la connexion, que vous pourrez récupérer à partir de l'application
                        compatible TOTP sur votre téléphone.
                    </p>

                    <TwoFactorRecoveryCodes />

                    <div class="relative inline">
                        <Form v-bind="disable.form()" #default="{ processing }">
                            <Button variant="destructive" type="submit" :disabled="processing">
                                <ShieldBan />
                                Désactiver 2FA
                            </Button>
                        </Form>
                    </div>
                </div>

                <TwoFactorSetupModal v-model:isOpen="showSetupModal" :requiresConfirmation="requiresConfirmation"
                    :twoFactorEnabled="twoFactorEnabled" />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
