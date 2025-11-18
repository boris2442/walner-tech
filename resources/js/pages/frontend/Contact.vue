<template>
    <FlashMessageNewsletter />
    <CartWidget />

    <!-- Le composant Inertia Head assure aussi le rendu côté serveur -->

    <Head title="Contactez " />
    <TopBanner />
    <NavbarFrontend :auth="$page.props.auth as Record<string, any> | undefined" class="mt-10 md:mt-12" /><br /><br />
    <FloatingAction />
    <LoginReminder />

    <!-- Flash message unique en haut -->
    <FlashMessage v-if="alertMessage" :message="alertMessage" type="success" />

    <section class="contact-page min-h-screen bg-[var(--background-light)] px-6 md:px-16 md:pb-16 dark:bg-[var(--dark-background)]">
        <!-- 🔹 Bouton retour -->
        <BackButton class="my-0 py-0" />
        <h1 class="mb-8 text-center text-2xl font-bold text-[var(--primary-blue)] dark:text-[var(--dark-accent)]">Contactez Walner Tech</h1>
        <div class="mx-auto max-w-6xl space-y-12">
            <!-- Contact Infos + Formulaire -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <!-- Infos -->
                <div class="space-y-4">
                    <div
                        class="group flex items-center gap-3 rounded bg-[var(--secondary-white)] p-4 shadow hover:bg-[var(--primary-blue)] hover:text-white hover:shadow-lg dark:bg-[var(--dark-black)]"
                    >
                        <font-awesome-icon
                            :icon="['fas', 'phone']"
                            class="text-xl text-[var(--highlight-gold)] group-hover:text-[#FFE600] dark:text-[var(--dark-gold)]"
                        />
                        <div>
                            <h3 class="font-semibold text-[var(--primary-blue)] group-hover:text-[#FFE600] dark:text-[var(--dark-gold)]">
                                Phone Number
                            </h3>
                            <p class="text-[var(--text-secondary)] group-hover:text-gray-300 dark:text-[var(--dark-white)]">
                                656 89 47 73 / 651 70 97 52
                            </p>
                        </div>
                    </div>
                    <div
                        class="group flex items-center gap-3 rounded bg-[var(--secondary-white)] p-4 shadow hover:bg-[var(--primary-blue)] hover:text-white hover:shadow-lg dark:bg-[var(--dark-black)]"
                    >
                        <font-awesome-icon
                            :icon="['fas', 'envelope']"
                            class="text-xl text-[var(--highlight-gold)] group-hover:text-[#FFE600] dark:text-[var(--dark-gold)]"
                        />
                        <div>
                            <h3 class="font-semibold text-[var(--primary-blue)] group-hover:text-[#FFE600] dark:text-[var(--dark-gold)]">Contact</h3>
                            <p class="text-[var(--text-secondary)] group-hover:text-gray-300 dark:text-[var(--dark-white)]">Walnertech@gmail.com</p>
                        </div>
                    </div>
                    <div
                        class="group flex items-center gap-3 rounded bg-[var(--secondary-white)] p-4 shadow hover:bg-[var(--primary-blue)] hover:text-white hover:shadow-lg dark:bg-[var(--dark-black)]"
                    >
                        <font-awesome-icon
                            :icon="['fas', 'map-marker-alt']"
                            class="text-xl text-[var(--highlight-gold)] group-hover:text-[#FFE600] dark:text-[var(--dark-gold)]"
                        />
                        <div>
                            <h3 class="font-semibold text-[var(--primary-blue)] group-hover:text-[#FFE600] dark:text-[var(--dark-gold)]">
                                Localisation
                            </h3>
                            <p class="text-[var(--text-secondary)] group-hover:text-gray-300 dark:text-[var(--dark-white)]">
                                Bafoussam: Immeuble le Pelicant Ancien bureau des transports<br />
                                Yaoundé: Terminus mimboman en face, sapeur pompier
                            </p>
                        </div>
                    </div>
                    <div
                        class="group flex items-center gap-3 rounded bg-[var(--secondary-white)] p-4 shadow hover:bg-[var(--primary-blue)] hover:text-white hover:shadow-lg dark:bg-[#2A2A2A] dark:bg-[var(--dark-black)]"
                    >
                        <font-awesome-icon
                            :icon="['fas', 'clock']"
                            class="text-xl text-[var(--highlight-gold)] group-hover:text-[#FFE600] dark:text-[var(--dark-gold)]"
                        />
                        <div>
                            <h3 class="font-semibold text-[var(--primary-blue)] group-hover:text-[#FFE600] dark:text-[var(--dark-gold)]">
                                Horaires d'ouverture
                            </h3>
                            <p class="text-[var(--text-secondary)] group-hover:text-gray-300 dark:text-[var(--dark-white)]">
                                Lundi-Samedi: 08h - 20h
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Formulaire -->
                <form class="space-y-4 rounded bg-[var(--secondary-white)] p-6 shadow dark:bg-[var(--dark-black)]" @submit.prevent="submit">
                    <!-- <h2 class="text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Contactez
                        Walner Tech</h2> -->
                    <p class="text-sm text-[var(--text-secondary)] dark:text-[var(--dark-white)]">
                        <i> Nous sommes à votre écoute. Envoyez-nous votre message.</i>
                    </p>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1 block font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Votre nom</label>
                            <input
                                type="text"
                                placeholder="Your Name"
                                class="w-full rounded border border-gray-300 p-2"
                                id="name"
                                name="name"
                                v-model="form.name"
                            />
                        </div>
                        <div>
                            <label for="adresse" class="mb-1 block font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]"
                                >Votre Contact</label
                            >
                            <input
                                type="tel"
                                placeholder="650 20 16 89"
                                id="adresse"
                                class="w-full rounded border border-gray-300 p-2"
                                name="email"
                                v-model="form.email"
                            />
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="mb-1 block font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Sujet</label>
                        <input
                            type="text"
                            placeholder="Subject"
                            class="w-full rounded border border-gray-300 p-2"
                            id="subject"
                            name="subject"
                            v-model="form.subject"
                        />
                    </div>

                    <div>
                        <label for="message" class="mb-1 block font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Message</label>
                        <textarea
                            id="message"
                            placeholder="Message"
                            class="h-32 w-full rounded border border-gray-300 p-2"
                            name="message"
                            v-model="form.message"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        class="rounded bg-[var(--primary-blue)] px-4 py-2 text-white transition hover:opacity-90"
                        :disabled="form.processing"
                    >
                        Envoyer
                    </button>
                </form>
            </div>

            <!-- Cartes Google Maps -->
            <div class="z-[-10] grid grid-cols-1 gap-8 md:grid-cols-2">
                <MapCard title="Bafoussam" :center="[5.479026658474593, 10.415195351707034]" :zoom="13" class="h-96 w-full rounded" />
                <MapCard title="Yaoundé" :center="[3.8718546453685936, 11.550169137595887]" :zoom="13" class="h-96 w-full rounded" />
            </div>
        </div>
    </section>

    <Footer />
</template>

<script setup lang="ts">
import { ref } from 'vue';

import { Head } from '@inertiajs/vue3';

import FlashMessageNewsletter from '@/components/FlashMessageNewsletter.vue';
import BackButton from '@/components/frontend/BackButton.vue';
import FlashMessage from '@/components/frontend/flash/FlashMessage.vue';
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
import FloatingAction from '@/components/frontend/FloatingAction.vue';
import Footer from '@/components/frontend/Footer.vue';
import MapCard from '@/components/frontend/MapCard.vue';
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue';
import CartWidget from '@/components/frontend/panier/CartWidget.vue';
import TopBanner from '@/components/frontend/TopBanner.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faClock, faEnvelope, faMapMarkerAlt, faPhone } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useForm } from '@inertiajs/inertia-vue3';

library.add(faPhone, faEnvelope, faMapMarkerAlt, faClock);

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const alertMessage = ref(''); // 🔹 variable pour le flash

const submit = () => {
    form.post('/contact', {
        onSuccess: (page) => {
            // afficher le flash envoyé par le backend
            // const status = page.props.flash?.status
            // if (status) {
            //     alertMessage.value = status

            //     // disparaît après 4 secondes
            //     setTimeout(() => {
            //         alertMessage.value = ''
            //     }, 4000)
            // }

            form.reset();
        },
    });
};
</script>
