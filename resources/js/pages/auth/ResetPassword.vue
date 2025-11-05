<script setup lang="ts">
import NewPasswordController from '@/actions/App/Http/Controllers/Auth/NewPasswordController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import BackButton from '@/components/frontend/BackButton.vue';
import { ref } from 'vue';
const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
     <BackButton class="m-4" />
    <AuthLayout title="Reset password" description="Veuillez saisir votre nouveau mot de passe ci-dessous">
        <Head title="Reset password" />

        <Form
            v-bind="NewPasswordController.store.form()"
            :transform="(data) => ({ ...data, token, email })"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input id="email" type="email" name="email" autocomplete="email" v-model="inputEmail" class="mt-1 block w-full" readonly />
                    <InputError :message="errors.email" class="mt-2" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Mot de passe</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        autofocus
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation"> Confirmation mot de passe </Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        class="mt-1 block w-full"
                        placeholder="Confirm password"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-4 w-full" :disabled="processing">
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                   Réinitialiser le mot de passe
                </Button>
            </div>
        </Form>
    </AuthLayout>
</template>
