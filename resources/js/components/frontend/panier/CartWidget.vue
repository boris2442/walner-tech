<template>
    <div class="fixed right-6 bottom-6 z-50 flex flex-col items-end">
        <!-- Bouton Panier -->
        <button
            @click="toggleCart"
            type="button"
            title="Ouvrir le panier"
            aria-label="Bouton ouvrir le panier"
            ref="cartButton"
            class="animate-cart relative flex h-12 w-12 items-center justify-center rounded-full bg-[var(--primary-blue)] text-[var(--dark-gold)] shadow-lg transition-transform hover:scale-110"
        >
            <font-awesome-icon :icon="['fas', 'cart-shopping']" class="animate-spin-slow text-2xl" />
            <span
                v-if="totalItems > 0"
                class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white"
            >
                {{ totalItems }}
            </span>
        </button>

        <!-- Tooltip vide -->
        <div v-if="showEmptyTooltip" class="absolute right-0 bottom-14 rounded bg-red-500 px-2 py-1 text-xs text-white shadow-lg">
            Votre panier est vide !
        </div>

        <!-- Mini Panier -->
        <transition name="fade-slide">
            <div
                v-if="showCart"
                class="cart-widget dark:bg-dark-background cart-scroll absolute right-0 bottom-14 z-50 mt-2 max-h-96 w-80 overflow-y-auto rounded-lg bg-[var(--accent-cyan)] p-3 shadow-lg"
            >
                <div v-if="cart.length === 0" class="dark:text-dark-grey text-center text-sm text-gray-400">Le panier est vide 😕</div>

                <div v-for="item in cart" :key="item.id" class="mb-2 flex items-center">
                    <img :src="getImageUrl(item.images?.[0]?.url_image)" class="mr-2 h-12 w-12 rounded object-cover" />
                    <div class="flex-1">
                        <p class="truncate text-sm font-medium text-gray-100">{{ item.title }}</p>
                        <p class="text-xs text-[var(--dark-gold)]">{{ item.prix }} FCFA x {{ item.quantity }}</p>
                        <div class="mt-1 flex items-center gap-1">
                            <button
                                @click="decrease(item)"
                                type="button"
                                aria-label="Diminuer la quantité"
                                title="Diminuer la quantité"
                                class="rounded bg-gray-200 px-2 text-sm hover:bg-gray-300 dark:bg-gray-700"
                            >
                                -
                            </button>
                            <span class="px-2">{{ item.quantity }}</span>
                            <button
                                @click="increase(item)"
                                type="button"
                                aria-label="Augmenter la quantité"
                                title="Augmenter la quantité"
                                class="rounded bg-gray-200 px-2 text-sm hover:bg-gray-300 dark:bg-gray-700"
                            >
                                +
                            </button>
                        </div>
                    </div>
                </div>

                <hr class="my-2 border-gray-300 dark:border-[var(--dark-grey)]" />

                <div class="flex justify-between font-semibold">
                    <span class="text-[var(--dark-gold)]">Total :</span>
                    <span class="text-[var(--dark-white)] underline">{{ cartTotal }} FCFA</span>
                </div>

                <!-- <button type="button" title="Regler la commande sur WhatsApp"
                    aria-label="Bouton regler la commande sur WhatsApp" @click="orderOnWhatsapp"
                    :disabled="cart.length === 0"
                    class="w-full bg-white dark:bg-[var(--dark-gold)] text-[var(--accent-cyan)] py-2 rounded hover:bg-gray-100 transition mt-3">
                    Commander sur WhatsApp
                 
                </button> -->
                <button
                    type="button"
                    title="Régler la commande sur WhatsApp"
                    aria-label="Bouton régler la commande sur WhatsApp"
                    @click="orderOnWhatsapp"
                    :disabled="cart.length === 0"
                    class="mt-3 flex w-full items-center justify-center gap-2 rounded bg-white py-2 text-[var(--accent-cyan)] shadow-md transition hover:scale-[1.02] active:scale-95 dark:bg-[var(--dark-gold)]"
                >
                    <!-- Icône animée -->
                    <MessageCircle class="animate-pulse-glow h-5 w-5" />

                    Commander sur WhatsApp
                </button>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { cartStore } from '@/components/frontend/panier/stores/cart';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { router, usePage } from '@inertiajs/vue3';
import { MessageCircle } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
const showCart = ref(false);
function toggleCart() {
    showCart.value = !showCart.value;
}

const cart = computed(() => cartStore.items);
const totalItems = computed(() => cartStore.totalItems());
const cartTotal = computed(() => cartStore.totalPrice());

function increase(item) {
    cartStore.increase(item);
}
function decrease(item) {
    cartStore.decrease(item);
}

function getImageUrl(path) {
    return path ? `/${path}` : '/fallback.png';
}

function orderOnWhatsapp() {
    const page = usePage(); // ✅ On récupère les props Inertia ici
    const user = page.props.auth?.user;
    const userName = user?.name || 'Client Walner Tech';

    // Vérifie la connexion
    if (!user) {
        if (confirm('⚠️ Vous devez être connecté pour pouvoir effectuer une commande.\nSouhaitez-vous vous connecter maintenant ?')) {
            router.visit('/login'); // redirige vers la page de connexion
        }
        return;
    }

    const entreprisePhone = '237657961059';

    let message = `*Bonjour équipe Walner Tech 👋,*
Je souhaite confirmer ma commande. Voici le récapitulatif :

`;

    cart.value.forEach((item) => {
        message += `• ${item.title} (x${item.quantity}) — ${item.prix * item.quantity} FCFA\n`;
    });

    // Ajout de la date de commande
    const date = new Date().toLocaleString('fr-FR', { timeZone: 'Africa/Douala' });

    message += `
*Montant total :* ${cartTotal.value} FCFA
🕒 *Date de commande :* ${date}

Merci de bien vouloir me confirmer la disponibilité et les modalités de livraison.

👤 *Nom du client :* ${userName}

Cordialement,
${userName}
`;

    window.open(`https://wa.me/${entreprisePhone}?text=${encodeURIComponent(message)}`, '_blank');
}

// Animation bouton vide
const cartButton = ref(null);
const showEmptyTooltip = ref(false);

function animateEmptyCart() {
    if (cartButton.value) {
        cartButton.value.classList.add('animate-shake');
        showEmptyTooltip.value = true;
        setTimeout(() => {
            cartButton.value.classList.remove('animate-shake');
            showEmptyTooltip.value = false;
        }, 800); // correspond à durée animation
    }
}

// Watch panier vide
watch(totalItems, (newVal) => {
    if (newVal === 0) {
        animateEmptyCart();
    }
});
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

/* ---- Mini Panier Scroll ---- */
.cart-scroll {
    max-height: 350px;
    overflow-y: auto;
    overscroll-behavior: contain;
    /* évite scroll du fond */
    scrollbar-width: none;
    /* Firefox */
    -ms-overflow-style: none;
    /* IE/Edge */
}

.cart-scroll::-webkit-scrollbar {
    display: none;
    /* Chrome / Safari */
}

/* ---- Shake Animation ---- */
@keyframes shake {
    0%,
    100% {
        transform: rotate(0deg);
    }

    25% {
        transform: rotate(-10deg);
    }

    50% {
        transform: rotate(10deg);
    }

    75% {
        transform: rotate(-10deg);
    }
}

.animate-shake {
    animation: shake 0.8s ease-in-out;
}

/* animation button  commander*/
@keyframes pulse-glow {
    0% {
        transform: scale(1);
        filter: drop-shadow(0 0 0px var(--accent-cyan));
    }

    50% {
        transform: scale(1.1);
        filter: drop-shadow(0 0 8px var(--accent-cyan));
    }

    100% {
        transform: scale(1);
        filter: drop-shadow(0 0 0px var(--accent-cyan));
    }
}

.animate-pulse-glow {
    animation: pulse-glow 2s ease-in-out infinite;
}
</style>
