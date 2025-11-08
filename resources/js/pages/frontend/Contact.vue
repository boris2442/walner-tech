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

    <section
        class="contact-page min-h-screen bg-[var(--background-light)] dark:bg-[var(--dark-background)] px-6 md:px-16 md:pb-16">
        <!-- 🔹 Bouton retour -->
        <BackButton class="my-0 py-0"/>
        <h1 class="text-2xl font-bold mb-8 text-center text-[var(--primary-blue)] dark:text-[var(--dark-accent)]">
            Contactez Walner Tech</h1>
        <div class="max-w-6xl mx-auto space-y-12">

            <!-- Contact Infos + Formulaire -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Infos -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3 bg-[var(--secondary-white)] p-4 rounded shadow dark:bg-[var(--dark-black)] group  hover:shadow-lg
hover:bg-[var(--primary-blue)] hover:text-white">
                        <font-awesome-icon :icon="['fas', 'phone']"
                            class="text-[var(--highlight-gold)] text-xl dark:text-[var(--dark-gold)] group-hover:text-[#FFE600]" />
                        <div>
                            <h3
                                class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)] group-hover:text-[#FFE600]">
                                Phone
                                Number</h3>
                            <p
                                class="text-[var(--text-secondary)] dark:text-[var(--dark-white)] group-hover:text-gray-300">
                                656 89 47 73 / 651 70
                                97 52</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-[var(--secondary-white)] p-4 rounded shadow dark:bg-[var(--dark-black)] group  hover:shadow-lg
hover:bg-[var(--primary-blue)] hover:text-white">
                        <font-awesome-icon :icon="['fas', 'envelope']"
                            class="text-[var(--highlight-gold)] text-xl dark:text-[var(--dark-gold)] group-hover:text-[#FFE600]" />
                        <div>
                            <h3
                                class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)] group-hover:text-[#FFE600]">
                                Contact
                            </h3>
                            <p
                                class="text-[var(--text-secondary)] dark:text-[var(--dark-white)] group-hover:text-gray-300">
                                Walnertech@gmail.com
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-[var(--secondary-white)] p-4 rounded shadow dark:bg-[var(--dark-black)] group  hover:shadow-lg
hover:bg-[var(--primary-blue)] hover:text-white">
                        <font-awesome-icon :icon="['fas', 'map-marker-alt']"
                            class="text-[var(--highlight-gold)] text-xl dark:text-[var(--dark-gold)] group-hover:text-[#FFE600]" />
                        <div>
                            <h3
                                class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)] group-hover:text-[#FFE600]">
                                Localisation</h3>
                            <p
                                class="text-[var(--text-secondary)] dark:text-[var(--dark-white)] group-hover:text-gray-300">
                                Bafoussam: Immeuble le Pelicant Ancien bureau des transports<br />
                                Yaoundé: Terminus mimboman en face, sapeur pompier
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-3 bg-[var(--secondary-white)] p-4 rounded shadow dark:bg-[var(--dark-black)] hover:shadow-lg dark:bg-[#2A2A2A] hover:bg-[var(--primary-blue)] hover:text-white group">
                        <font-awesome-icon :icon="['fas', 'clock']"
                            class="text-[var(--highlight-gold)] text-xl dark:text-[var(--dark-gold)] group-hover:text-[#FFE600]" />
                        <div>
                            <h3
                                class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)] group-hover:text-[#FFE600]">
                                Horaires
                                d'ouverture</h3>
                            <p
                                class="text-[var(--text-secondary)] dark:text-[var(--dark-white)] group-hover:text-gray-300">
                                Lundi-Samedi: 08h -
                                20h</p>
                        </div>
                    </div>
                </div>

                <!-- Formulaire -->
                <form class="bg-[var(--secondary-white)] p-6 rounded shadow space-y-4 dark:bg-[var(--dark-black)]"
                    @submit.prevent="submit">

                    <!-- <h2 class="text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Contactez
                        Walner Tech</h2> -->
                    <p class="text-[var(--text-secondary)] dark:text-[var(--dark-white)]"><i> Nous sommes à votre écoute.
                        Envoyez-nous votre message.</i></p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name"
                                class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Votre
                                nom</label>
                            <input type="text" placeholder="Your Name" class="p-2 border border-gray-300 rounded w-full"
                                id="name" name="name" v-model="form.name" />
                        </div>
                        <div>
                            <label for="adresse"
                                class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Votre
                                Contact</label>
                            <input type="tel" placeholder="650 20 16 89" id="adresse"
                                class="p-2 border border-gray-300 rounded w-full" name="email" v-model="form.email" />
                        </div>
                    </div>

                    <div>
                        <label for="subject"
                            class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Sujet</label>
                        <input type="text" placeholder="Subject" class="p-2 border border-gray-300 rounded w-full"
                            id="subject" name="subject" v-model="form.subject" />
                    </div>

                    <div>
                        <label for="message"
                            class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Message</label>
                        <textarea id="message" placeholder="Message"
                            class="p-2 border border-gray-300 rounded w-full h-32" name="message"
                            v-model="form.message"></textarea>
                    </div>

                    <button type="submit"
                        class="bg-[var(--primary-blue)] text-white px-4 py-2 rounded hover:opacity-90 transition"
                        :disabled="form.processing">
                        Envoyer
                    </button>
                </form>
            </div>

            <!-- Cartes Google Maps -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 z-[-10]">
                <MapCard title="Bafoussam" :center="[5.479026658474593, 10.415195351707034]" :zoom="13"
                    class="w-full h-96 rounded " />
                <MapCard title="Yaoundé" :center="[3.8718546453685936, 11.550169137595887]" :zoom="13"
                    class="w-full h-96 rounded " />
            </div>

        </div>
    </section>

    <Footer />
</template>

<script setup lang="ts">
import { ref } from 'vue'

import { Head } from '@inertiajs/vue3'

import { useForm } from '@inertiajs/inertia-vue3'
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue'
import Footer from '@/components/frontend/Footer.vue'
import FloatingAction from '@/components/frontend/FloatingAction.vue'
import TopBanner from '@/components/frontend/TopBanner.vue'
import LoginReminder from '@/components/frontend/flash/LoginReminder.vue'
import MapCard from '@/components/frontend/MapCard.vue'
import BackButton from '@/components/frontend/BackButton.vue'
import FlashMessage from '@/components/frontend/flash/FlashMessage.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faPhone, faEnvelope, faMapMarkerAlt, faClock } from '@fortawesome/free-solid-svg-icons'
import CartWidget from '@/components/frontend/panier/CartWidget.vue'
import FlashMessageNewsletter from '@/components/FlashMessageNewsletter.vue'

library.add(faPhone, faEnvelope, faMapMarkerAlt, faClock)

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: ''
})

const alertMessage = ref('')  // 🔹 variable pour le flash

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

            form.reset()
        }
    })
}


</script>
