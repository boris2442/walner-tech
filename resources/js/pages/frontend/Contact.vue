<template>
    <NavbarFrontend /><br /><br />

    <FlashMessage v-if="form.status" :message="form.status" type="success" />



    <section
        class="contact-page min-h-screen bg-[var(--background-light)] dark:bg-[var(--dark-background)] p-6 md:p-16">


        <div class="max-w-6xl mx-auto space-y-12">
            <!-- 🔹 Bouton retour -->
            <BackButton />
            <!-- Contact Infos + Formulaire -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Infos -->
                <div class="space-y-4">
                    <div
                        class="flex items-center gap-3 bg-[var(--secondary-white)] dark:bg-[var(--dark-blue)] p-4 rounded shadow">
                        <font-awesome-icon :icon="['fas', 'phone']" class="text-[var(--highlight-gold)] text-xl" />
                        <div>
                            <h3 class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Phone
                                Number</h3>
                            <p class="text-[var(--text-secondary)] dark:text-[var(--dark-white)]">656 89 47 73 / 692 21
                                41 05</p>
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-3 bg-[var(--secondary-white)] dark:bg-[var(--dark-blue)] p-4 rounded shadow">
                        <font-awesome-icon :icon="['fas', 'envelope']" class="text-[var(--highlight-gold)] text-xl" />
                        <div>
                            <h3 class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Contact
                            </h3>
                            <p class="text-[var(--text-secondary)] dark:text-[var(--dark-white)]">Walnertech@gmail.com
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-3 bg-[var(--secondary-white)] dark:bg-[var(--dark-blue)] p-4 rounded shadow">
                        <font-awesome-icon :icon="['fas', 'map-marker-alt']"
                            class="text-[var(--highlight-gold)] text-xl" />
                        <div>
                            <h3 class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
                                Localisation
                            </h3>
                            <p class="text-[var(--text-secondary)] dark:text-[var(--dark-white)]">
                                Bafoussam: Immeuble Ancien Bureau des transports<br />
                                Yaoundé: Terminus mimboman en face, sapeur pompier
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-3 bg-[var(--secondary-white)] dark:bg-[var(--dark-blue)] p-4 rounded shadow">
                        <font-awesome-icon :icon="['fas', 'clock']" class="text-[var(--highlight-gold)] text-xl" />
                        <div>
                            <h3 class="font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Horaires
                                d'ouverture</h3>
                            <p class="text-[var(--text-secondary)] dark:text-[var(--dark-white)]">Lundi-Samedi: 08h -
                                20h</p>
                        </div>
                    </div>
                </div>

                <!-- Formulaire -->
                <form class="bg-[var(--secondary-white)] dark:bg-[var(--dark-blue)] p-6 rounded shadow space-y-4"
                    @submit.prevent="submit">


                    <h2 class="text-2xl font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Contactez
                        Walner Tech</h2>
                    <p class="text-[var(--text-secondary)] dark:text-[var(--dark-white)]">Nous sommes à votre écoute.
                        Envoyez-nous votre message.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="">
                            <label for="name"
                                class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Enter
                                votre nom</label>
                            <input type="text" placeholder="Your Name" class="p-2 border border-gray-300 rounded w-full"
                                id="name" name="name" v-model="form.name" />
                        </div>
                        <div class="">
                            <label for="adresse"
                                class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Enter
                                votre Adresse</label>
                            <input type="email" placeholder="Email Address" id="adresse"
                                class="p-2 border border-gray-300 rounded w-full" name="email" v-model="form.email" />
                        </div>
                    </div>
                    <div class="">
                        <label for="subject"
                            class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Sujet</label>

                        <input type="text" placeholder="Subject" class="p-2 border border-gray-300 rounded w-full"
                            id="subject" name="subject" v-model="form.subject" />
                    </div>
                    <label for="message"
                        class="block mb-1 font-medium text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">Message</label>
                    <textarea id="message" placeholder="Message" class="p-2 border border-gray-300 rounded w-full h-32"
                        name="message" v-model="form.message"></textarea>
                    <button type="submit"
                        class="bg-[var(--primary-blue)] text-[var(--dark-blue)] px-4 py-2 rounded hover:opacity-90 transition"
                        :disabled="form.processing">
                        Envoyer
                    </button>
                </form>


            </div>

            <!-- Cartes Google Maps -->



            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 z-[-10]">
                <!-- Carte Bafoussam -->
                <MapCard title="Bafoussam" :center="[5.479026658474593, 10.415195351707034]" :zoom="13"
                    class="w-full h-96 rounded " />

                <!-- Carte Yaoundé -->
                <MapCard title="Yaoundé" :center="[3.8718546453685936, 11.550169137595887]" :zoom="13"
                    class="w-full h-96 rounded " />
            </div>




        </div>
    </section>
    <Footer />
</template>

<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faPhone, faEnvelope, faMapMarkerAlt, faClock } from '@fortawesome/free-solid-svg-icons'


library.add(faPhone, faEnvelope, faMapMarkerAlt, faClock)
import NavbarFrontend from '@/components/frontend/NavbarFrontend.vue'
// import { Link } from '@inertiajs/vue3'
import Footer from '@/components/frontend/Footer.vue';
import MapCard from '@/components/frontend/MapCard.vue'
import BackButton from '@/components/frontend/BackButton.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import FlashMessage from '@/components/frontend/flash/FlashMessage.vue'
const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: ''
});


const submit = () => {
    form.post('/contact', {
        onSuccess: (page) => {
            if (page.props.status) {
                form.status = page.props.status; // définis une variable locale
            }
            form.reset();
        }
    });
}


</script>
