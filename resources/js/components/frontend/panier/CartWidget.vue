<template>
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <!-- Bouton Panier -->
        <button @click="toggleCart" ref="cartButton"
            class="relative bg-[var(--primary-blue)] rounded-full w-12 h-12 flex items-center justify-center text-[var(--dark-gold)] shadow-lg hover:scale-110 transition-transform">
            <font-awesome-icon :icon="['fas', 'cart-shopping']" class="text-2xl" />
            <span v-if="totalItems > 0"
                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                {{ totalItems }}
            </span>
        </button>

        <!-- Tooltip vide -->
        <div v-if="showEmptyTooltip"
            class="absolute bottom-14 right-0 bg-red-500 text-white text-xs py-1 px-2 rounded shadow-lg">
            Votre panier est vide !
        </div>

        <!-- Mini Panier -->
        <transition name="fade-slide">
            <div v-if="showCart"
                class="cart-widget absolute bottom-14 right-0 z-50 w-80 max-h-96 bg-[var(--accent-cyan)] dark:bg-dark-background shadow-lg rounded-lg overflow-y-auto p-3 cart-scroll mt-2">

                <div v-if="cart.length === 0" class="text-sm text-gray-400 dark:text-dark-grey text-center">
                    Le panier est vide 😕
                </div>

                <div v-for="item in cart" :key="item.id" class="flex items-center mb-2">
                    <img :src="getImageUrl(item.images?.[0]?.url_image)" class="w-12 h-12 object-cover rounded mr-2" />
                    <div class="flex-1">
                        <p class="text-sm font-medium truncate text-gray-100">{{ item.title }}</p>
                        <p class="text-xs text-[var(--dark-gold)]">{{ item.prix }} FCFA x {{ item.quantity }}</p>
                        <div class="flex items-center mt-1 gap-1">
                            <button @click="decrease(item)"
                                class="bg-gray-200 dark:bg-gray-700 rounded px-2 text-sm hover:bg-gray-300">-</button>
                            <span class="px-2">{{ item.quantity }}</span>
                            <button @click="increase(item)"
                                class="bg-gray-200 dark:bg-gray-700 rounded px-2 text-sm hover:bg-gray-300">+</button>
                        </div>
                    </div>
                </div>

                <hr class="my-2 border-gray-300 dark:border-[var(--dark-grey)]" />

                <div class="flex justify-between font-semibold">
                    <span class="text-[var(--dark-gold)]">Total :</span>
                    <span class="text-[var(--dark-white)] underline">{{ cartTotal }} FCFA</span>
                </div>

                <button @click="orderOnWhatsapp" :disabled="cart.length === 0"
                    class="w-full bg-white dark:bg-[var(--dark-gold)] text-[var(--accent-cyan)] py-2 rounded hover:bg-gray-100 transition mt-3">
                    Commander sur WhatsApp
                </button>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { cartStore } from '@/components/frontend/panier/stores/cart'

const showCart = ref(false)
function toggleCart() { showCart.value = !showCart.value }

const cart = computed(() => cartStore.items)
const totalItems = computed(() => cartStore.totalItems())
const cartTotal = computed(() => cartStore.totalPrice())

function increase(item) { cartStore.increase(item) }
function decrease(item) { cartStore.decrease(item) }

function getImageUrl(path) { return path ? `/${path}` : '/fallback.png' }

function orderOnWhatsapp() {
    const entreprisePhone = "237656894773"
    let message = `Bonjour Walner Tech 👋,\nJe souhaite passer la commande suivante :\n\n`
    cart.forEach(item => {
        message += `• ${item.title} (x${item.quantity}) = ${item.prix * item.quantity} FCFA\n`
    })
    message += `\nMontant total : ${cartTotal.value} FCFA\n\nMerci !`
    window.open(`https://wa.me/${entreprisePhone}?text=${encodeURIComponent(message)}`, "_blank")
}

// Animation bouton vide
const cartButton = ref(null)
const showEmptyTooltip = ref(false)

function animateEmptyCart() {
    if (cartButton.value) {
        cartButton.value.classList.add('animate-shake')
        showEmptyTooltip.value = true
        setTimeout(() => {
            cartButton.value.classList.remove('animate-shake')
            showEmptyTooltip.value = false
        }, 800) // correspond à durée animation
    }
}

// Watch panier vide
watch(totalItems, (newVal) => {
    if (newVal === 0) {
        animateEmptyCart()
    }
})
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
</style>
