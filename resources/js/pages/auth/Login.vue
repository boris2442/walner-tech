
<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
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
import { LoaderCircle, LogIn } from 'lucide-vue-next';

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
    <AuthBase title="Connectez-vous à votre compte walner tech" description="Entrez votre email et votre mot de passe ci-dessous pour vous connecter">

        <Head title="Log in" />
        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>
        <div class=" flex items-center justify-center">
            <div
                class="w-full max-w-4xl flex flex-col md:flex-row bg-white rounded-lg shadow-lg overflow-hidden dark:bg-[var(--dark-background)]">
                <!-- Left Section (Sign In Form) -->
                <div class="w-full md:w-1/2 p-6 md:p-8">
                    
                    <div class="py-4 text-center text-gray-400 ">
             
                    </div>
                    <Form v-bind="AuthenticatedSessionController.store.form()" :reset-on-success="['password']"
                        v-slot="{ errors, processing }" class="space-y-6">
                        <div class="grid gap-4">
                            <div class="grid gap-2">
                                <Label for="email" class="text-[var(--primary-blue)]">Adresse email</Label>
                                <Input id="email" type="email" name="email" required autofocus :tabindex="1"
                                    autocomplete="email" placeholder="email@example.com" />
                                <InputError :message="errors.email" />
                            </div>
                            <div class="grid gap-2">
                                <div class="flex items-center justify-between">
                                    <Label for="password" class="text-[var(--primary-blue)]">Mot de passe</Label>
                                    <TextLink v-if="canResetPassword" :href="request()"
                                        class="text-sm text-[var(--primary-blue)] hover:underline" :tabindex="5"> Mot de passe oublié?
                                    </TextLink>
                                </div>
                                <Input id="password" type="password" name="password" required :tabindex="2"
                                    autocomplete="current-password" placeholder="Password" />
                                <InputError :message="errors.password" />
                            </div>
                            <div class="flex items-center justify-between">
                                <Label for="remember" class="flex items-center space-x-3 ">
                                    <Checkbox id="remember" name="remember" :tabindex="3"
                                        class="bg-[var(--primary-blue)]" />
                                    <span class="text-[var(--primary-blue)]">Se souvenir de moi</span>
                                </Label>
                            </div>
                            <Button type="submit"
                                class="w-full bg-[var(--primary-blue)] text-white hover:bg-[var(--primary-blue2)] dark:bg-[var(--dark-black)]"
                                :tabindex="4" :disabled="processing">
                                <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin mr-2" />
                                Se connecter
                            </Button>

                        </div>
                        <div class="text-center text-sm text-gray-500">
                            Vous n'avez pas de compte ?
                            <TextLink :href="register()" class="text-[var(--primary-blue)] hover:underline"
                                :tabindex="5">S'inscrire
                            </TextLink>
                        </div>
                    </Form>
                </div>
             
                <div
                    class="w-full md:w-1/2 bg-[var(--primary-blue)] text-white p-6 md:p-8 flex flex-col justify-center items-center sm:rounded-tl-[90px] sm:rounded-bl-[90px] dark:bg-[var(--text-secondary)]">
                    <h2 class="text-2xl font-bold mb-4">Hello, Friend!</h2>
                    <p class="text-center mb-6">Connectez-vous avec vos identifiants pour accéder à votre compte.</p>


                </div>
            </div>
        </div>
    </AuthBase>
</template>

