<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import BackButton from '@/components/frontend/BackButton.vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { Eye, EyeOff, LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';
const showPassword = ref(false);
const showConfirmPassword = ref(false);
defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
// Fonction pour rediriger vers Google OAuth
const loginWithGoogle = () => {
    window.location.href = '/auth/google';
};
</script>

<template>
    <BackButton class="m-4" />
    <AuthBase title="Connectez-vous à votre compte walner tech" description="Entrez votre email et votre mot de passe ci-dessous pour vous connecter">
        <Head title="Log in" />
        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>
        <div class="flex items-center justify-center">
            <div class="flex w-full max-w-4xl flex-col overflow-hidden rounded-lg bg-white shadow-lg md:flex-row dark:bg-[var(--dark-background)]">
                <!-- Left Section (Sign In Form) -->
                <div class="w-full p-6 md:w-1/2 md:p-8">
                    <div class="py-4 text-center text-gray-400"></div>
                    <Form
                        v-bind="AuthenticatedSessionController.store.form()"
                        :reset-on-success="['password']"
                        v-slot="{ errors, processing }"
                        class="space-y-6"
                    >
                        <div class="grid gap-4">
                            <div class="grid gap-2">
                                <Label for="email" class="text-[var(--primary-blue)]">Adresse email</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    name="email"
                                    required
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="email"
                                    placeholder="email@example.com"
                                />
                                <InputError :message="errors.email" />
                            </div>
                            <div class="relative grid gap-2">
                                <div class="flex items-center justify-between">
                                    <Label for="password" class="text-[var(--primary-blue)]">Mot de passe</Label>
                                    <TextLink
                                        v-if="canResetPassword"
                                        :href="request()"
                                        class="dark:text-[#ffe600] text-sm text-[var(--primary-blue)] hover:underline"
                                        :tabindex="5"
                                    >
                                        Mot de passe oublié?
                                    </TextLink>
                                </div>
                                <Input
                                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    required
                                    :tabindex="2"
                                    autocomplete="current-password"
                                    placeholder="Password"
                                />

                                <button
                                    type="button"
                                    class="absolute top-9 right-3 text-gray-500 transition hover:text-[var(--primary-blue)]"
                                    @click="showPassword = !showPassword"
                                >
                                    <Eye v-if="!showPassword" class="h-5 w-5" />
                                    <EyeOff v-else class="h-5 w-5" />
                                </button>
                                <InputError :message="errors.password" />
                            </div>
                            <div class="flex items-center justify-between">
                                <Label for="remember" class="flex items-center space-x-3">
                                    <Checkbox id="remember" name="remember" :tabindex="3" class="bg-[var(--primary-blue)]" />
                                    <span class="text-[var(--primary-blue)] dark:text-[#ffe600]">Se souvenir de moi</span>
                                </Label>
                            </div>
                            <Button
                                type="submit"
                                class="w-full bg-[var(--primary-blue)] text-white hover:bg-[var(--primary-blue2)] dark:bg-[var(--dark-black)]"
                                :tabindex="4"
                                :disabled="processing"
                            >
                                <LoaderCircle v-if="processing" class="mr-2 h-4 w-4 animate-spin" />
                                Se connecter
                            </Button>
                        </div>
                        <div class="text-center text-sm text-gray-500">
                            Vous n'avez pas de compte ?
                            <TextLink :href="register()" class="text-2xl text-[var(--primary-blue)] hover:underline dark:text-[#ffe600]" :tabindex="5"
                                >S'inscrire
                            </TextLink>
                        </div>
                    </Form>
                </div>

                <div
                    class="flex w-full flex-col items-center justify-center bg-[var(--primary-blue)] p-6 text-white sm:rounded-tl-[90px] sm:rounded-bl-[90px] md:w-1/2 md:p-8 dark:bg-[#000]"
                >
                    <h2 class="mb-4 text-2xl font-bold">Hello, Friend!</h2>
                    <p class="mb-6 text-center">Connectez-vous avec vos identifiants pour accéder à votre compte.</p>
                </div>
            </div>
        </div>
    </AuthBase>
</template>
