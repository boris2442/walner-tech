<script>
import { Link } from '@inertiajs/inertia-vue3'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'

// Brand icons
import { faFacebook, faTwitter, faInstagram, faLinkedin } from '@fortawesome/free-brands-svg-icons'

// Solid icons
import { faPhone, faEnvelope, faMapMarkerAlt, faGlobe } from '@fortawesome/free-solid-svg-icons'

// Ajouter toutes les icônes à la librairie
library.add(faFacebook, faTwitter, faInstagram, faLinkedin, faPhone, faEnvelope, faMapMarkerAlt, faGlobe)

export default {
    components: {
        Link,
        FontAwesomeIcon
    }
}
</script>

<template>
    <section>
        <footer class="bg-[var(--primary-blue)] text-white py-8">
            <div class="flex justify-between flex-wrap items-start gap-6 px-6">
                <!-- Contact -->
                <div>
                    <h3 class="font-bold text-lg md:text-xl mb-2">Nous contacter</h3>

                    <div class="flex items-center gap-2 mb-2">
                        <FontAwesomeIcon :icon="['fas', 'map-marker-alt']" />
                        <span>Bafoussam Immeuble Ancien Bureau des transports</span>
                    </div>

                    <div class="flex items-center gap-2 mb-2">
                        <FontAwesomeIcon :icon="['fas', 'phone']" />
                        <span>656 89 47 73 / 692 21 41 05</span>
                    </div>

                    <div class="flex items-center gap-2 mb-2">
                        <FontAwesomeIcon :icon="['fas', 'globe']" />
                        <a href="https://walcom.com" target="_blank" class="underline">https://walcom.com</a>
                    </div>

                    <div class="flex items-center gap-2">
                        <FontAwesomeIcon :icon="['fas', 'envelope']" />
                        <a href="mailto:walnertech@gmail.com" class="underline">walcom@gmail.com</a>
                    </div>
                </div>


                <!-- Ressources -->
                <div>
                    <h3 class="font-bold text-lg md:text-xl">Ressources</h3>
                    <div>
                        <Link href="">Mentions Légales</Link>
                    </div>
                    <div>
                        <Link href="">Politique de confidentialité</Link>
                    </div>
                    <div>
                        <Link href="">Conditions générales de vente</Link>
                    </div>
                    <div>
                        <Link href="">Conditions de remboursement</Link>
                    </div>
                </div>

                <!-- FAQ -->
                <div>
                    <h3 class="font-bold text-lg md:text-xl">F.A.Q</h3>
                    <div>—</div>
                </div>
            </div><br>
            <div class="border-white border-1 border-solid mx-auto w-[90%] "></div>
            <div class="flex justify-between flex-wrap items-center gap-4 px-4">
                <!-- Ligne + Réseaux sociaux -->
                <div class="mt-8  border-gray-400  ">
                    <h3 class="font-bold mb-2">Suivez-nous</h3>
                    <div class="flex justify-center gap-6 text-2xl ">
                        <a href="">
                            <FontAwesomeIcon :icon="['fab', 'facebook']" />
                        </a>
                        <a href="">
                            <FontAwesomeIcon :icon="['fab', 'instagram']" />
                        </a>
                        <a href="">
                            <FontAwesomeIcon :icon="['fab', 'twitter']" />
                        </a>
                        <a href="">
                            <FontAwesomeIcon :icon="['fab', 'linkedin']" />
                        </a>
                    </div>

                </div>
                <div class="text-center ">
                    <p class="text-xs md:text-sm">&copy; 2024 Walcom. Tous droits réservés.</p>

                    <p class="text-xs md:text-sm">Propulsé avec ❤️ par Aubin Boris Simo</p>
                </div>
            </div>
        </footer>
    </section>
</template>

<style>
/* tu peux personnaliser encore ici */
</style>
