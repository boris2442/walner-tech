<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

const showBanner = ref(false)
const isClosed = ref(false)
const page = usePage()

const isAuthenticated = page.props.auth?.user
let reopenTimer = null

const handleScroll = () => {
    if (!isAuthenticated && !isClosed.value) {
        const scrollTop = window.scrollY
        if (scrollTop > 100) showBanner.value = true
    }
}

const closeBanner = () => {
    showBanner.value = false
    isClosed.value = true
    clearTimeout(reopenTimer)
    reopenTimer = setTimeout(() => {
        isClosed.value = false
    }, 10000)
}

const goToLogin = () => {
    router.visit('/login')
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
    clearTimeout(reopenTimer)
})
</script>

<template>
    <transition enter-active-class="transition ease-out duration-500 transform"
        enter-from-class="translate-y-6 opacity-0" enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition ease-in duration-300 transform" leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-6 opacity-0">
        <div v-if="showBanner" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 w-full max-w-[95%] px-3 py-3 shadow-xl 
             flex flex-col sm:flex-row justify-between items-center gap-3 z-[9999]
             bg-[var(--flash)] text-[var(--secondary-white)]
             dark:bg-[var(--dark-blue)] dark:text-[var(--dark-white)] 
             rounded-lg banner">
            <!-- Texte -->
            <span class="text-sm text-center sm:text-left flex-1">
                💫 Rejoins la vibe <strong>Walner Tech</strong> !
            </span>

            <!-- Boutons groupés -->
            <div class="flex items-center gap-2">
                <button @click="goToLogin" class="font-semibold px-3 py-2 rounded-lg whitespace-nowrap
                 bg-[var(--highlight-gold)] text-white 
                 hover:bg-[#333131] dark:bg-[var(--dark-gold)] 
                 dark:text-[var(--dark-black)] dark:hover:bg-[var(--dark-accent)] 
                 transition text-2xl">
                    Je me connecte 👍
                </button>

                <button @click="closeBanner" class="text-white hover:text-gray-100 dark:text-[var(--dark-white)] 
                 dark:hover:text-[var(--dark-grey)] text-xl font-bold 
                 bg-red-600 h-8 w-8 flex justify-center items-center  p-3 rounded-full">
                    &times;
                </button>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.fixed {
    animation: floatUp 0.3s ease-out;
}

@keyframes floatUp {
    from {
        transform: translateY(10px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* ✅ Correction mobile */
@media (max-width: 640px) {
    .banner {
        flex-direction: column;
        text-align: center;
        padding: 12px 10px;
    }

    .banner button {
        width: 100%;
    }
}
</style>
