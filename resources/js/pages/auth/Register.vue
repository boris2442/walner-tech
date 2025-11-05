<script setup lang="ts">
import { ref } from 'vue';
import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle, Eye, EyeOff } from 'lucide-vue-next';
import BackButton from '@/components/frontend/BackButton.vue';
const showPassword = ref(false);
const showConfirmPassword = ref(false);

</script>

<template>
    <FloatingAction />
    <BackButton class="m-4" />

    <Head title="Register" />
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4 dark:bg-[var(--dark-background)]">
        <div
            class="w-full max-w-4xl flex flex-col md:flex-row bg-white rounded-lg shadow-lg overflow-hidden dark:bg-[var(--dark-background)]">
            <!-- Left Section (Welcome Back) -->
            <div
                class="w-full md:w-1/2 bg-[var(--primary-blue)] text-white p-8 flex flex-col justify-center items-center sm:rounded-tr-[90px] sm:rounded-br-[90px] dark:bg-[#535353]">
                <!-- Logo assets/walner.png -->
                <!-- <div class="mb-6 text-center">
                    <Link href="/home" class="nav-link">
                    <img src="assets/walner.png" alt="Walner Tech" class="max-h-14 object-cover w-[200px] z-1000" />
                    </Link>
                </div> -->
                <h2 class="text-2xl font-bold mb-2">Content de vous revoir!</h2>
                <p class="text-center mb-4">Saisissez vos informations personnelles pour vous connecter à votre compte
                </p>

            </div>

            <div class="w-full md:w-1/2 p-8 dark:bg-[var(--dark-background)]">
                <h2 class="text-xl font-semibold mb-6 text-[var(--primary-blue)]">Créer un compte</h2>
                <p class="text-sm text-gray-500 mb-6">ou utilisez votre email pour vous inscrire</p>
                <Form v-bind="RegisteredUserController.store.form()"
                    :reset-on-success="['password', 'password_confirmation']" v-slot="{ errors, processing }"
                    class="space-y-6">
                    <div class="grid gap-4">
                        <div class="grid gap-2">
                            <Label for="name" class="text-[var(--primary-blue)]">Nom</Label>
                            <Input
                                class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm "
                                id="name" type="text" required autofocus :tabindex="1" autocomplete="name" name="name"
                                placeholder="Full name" />
                            <InputError :message="errors.name" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="phone" class="text-[var(--primary-blue)]">Téléphone</Label>
                            <Input
                                class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm "
                                id="phone" type="tel" required autofocus :tabindex="1" autocomplete="phone" name="phone"
                                placeholder="652 22 65 29" />
                            <InputError :message="errors.phone" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="email" class="text-[var(--primary-blue)]">Address email</Label>
                            <Input id="email" type="email" required :tabindex="2" autocomplete="email" name="email"
                                placeholder="email@example.com" />
                            <InputError :message="errors.email" />
                        </div>
                        <!-- <div class="grid gap-2">
                            <Label for="password" class="text-[var(--primary-blue)]">Mot de passe</Label>
                            <Input id="password" type="password" required :tabindex="3" autocomplete="new-password"
                                name="password" placeholder="Password" />
                            <InputError :message="errors.password" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="password_confirmation" class="text-[var(--primary-blue)]">Confirmation mot de
                                passe</Label>
                            <Input id="password_confirmation" type="password" required :tabindex="4"
                                autocomplete="new-password" name="password_confirmation"
                                placeholder="Confirm password" />
                            <InputError :message="errors.password_confirmation" />
                        </div> -->

                        <!-- Champ Mot de passe -->
                        <div class="grid gap-2 relative">
                            <Label for="password" class="text-[var(--primary-blue)]">Mot de passe</Label>
                            <Input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                placeholder="********" required class="pr-10" />
                            <button type="button"
                                class="absolute right-3 top-9 text-gray-500 hover:text-[var(--primary-blue)] transition"
                                @click="showPassword = !showPassword">
                                <Eye v-if="!showPassword" class="w-5 h-5" />
                                <EyeOff v-else class="w-5 h-5" />
                            </button>
                            <InputError :message="errors.password" />
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div class="grid gap-2 relative">
                            <Label for="password_confirmation" class="text-[var(--primary-blue)]">Confirmer le mot de
                                passe</Label>
                            <Input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation"
                                name="password_confirmation" placeholder="********" required class="pr-10" />
                            <button type="button"
                                class="absolute right-3 top-9 text-gray-500 hover:text-[var(--primary-blue)] transition"
                                @click="showConfirmPassword = !showConfirmPassword">
                                <Eye v-if="!showConfirmPassword" class="w-5 h-5" />
                                <EyeOff v-else class="w-5 h-5" />
                            </button>
                            <InputError :message="errors.password_confirmation" />
                        </div>


                        <Button type="submit"
                            class="w-full bg-[var(--primary-blue)] text-white hover:bg-[var(--primary-blue2)] dark:bg-[var(--dark-black)] dark:hover:bg-gray-900 "
                            :disabled="processing">
                            <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin mr-2" />
                            S'inscrire
                        </Button>
                    </div>
                    <div class="text-center text-sm text-gray-500">
                        Deja un compte? <TextLink :href="login()" class="text-[var(--primary-blue)] hover:underline"
                            :tabindex="5">Se connecter</TextLink>
                    </div>
                </Form>
            </div>
        </div>
    </div>

</template>

<style scoped></style>