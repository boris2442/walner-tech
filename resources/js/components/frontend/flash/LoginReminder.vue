<!-- <script setup>
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
    }, 8000)
}

const goToLogin = () => {
    router.visit('/register')
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
        enter-from-class="translate-y-10 opacity-0" enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition ease-in duration-300 transform" leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-10 opacity-0">
        <div v-if="showBanner" class="fixed bottom-0 left-0 w-full px-6 py-4 shadow-lg flex justify-between items-center z-50
                   bg-[var(--primary-blue)] text-[var(--secondary-white)]
                   dark:bg-[var(--dark-blue)] dark:text-[var(--dark-white)]">
            <span class="text-sm md:text-base">
                💫 Rejoins la vibe Walner Tech !
            </span>

            <div class="flex items-center gap-4">
                <button @click="goToLogin"
                    class="font-semibold px-4 py-2 rounded-lg 
                           bg-[var(--highlight-gold)] text-white 
                           hover:bg-[var(--accent-cyan)] dark:bg-[var(--dark-gold)] dark:text-[var(--dark-black)] dark:hover:bg-[var(--dark-accent)] transition text-sm md:text-base ">
                    Je me connecte 👍
                </button>


            </div>
            <button @click="closeBanner"
                class="text-white hover:text-gray-100 dark:text-[var(--dark-white)] dark:hover:text-[var(--dark-grey)] text-5xl font-bold bg-red-600 h-[40px] w-[40px] flex justify-center items-center">
                &times;
            </button>
        </div>
    </transition>
</template>

<style scoped>
.fixed {
    animation: floatUp 0.3s ease-out;
}

@keyframes floatUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style> -->



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
    }, 8000)
}

const goToLogin = () => {
    router.visit('/register')
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
        <div v-if="showBanner" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 w-[90%] md:w-[80%] px-4 py-3 shadow-xl flex flex-col md:flex-row justify-between items-center z-[9999]
                bg-[var(--primary-blue)] text-[var(--secondary-white)]
                dark:bg-[var(--dark-blue)] dark:text-[var(--dark-white)] rounded-lg">

            <span class="text-sm md:text-base text-center md:text-left mb-2 md:mb-0">
                💫 Rejoins la vibe Walner Tech !
            </span>

            <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4">
                <button @click="goToLogin"
                    class="font-semibold px-4 py-2 rounded-lg 
                       bg-[var(--highlight-gold)] text-white 
                       hover:bg-[var(--accent-cyan)] dark:bg-[var(--dark-gold)] dark:text-[var(--dark-black)] dark:hover:bg-[var(--dark-accent)] transition text-sm md:text-base">
                    Je me connecte 👍
                </button>

                <button @click="closeBanner"
                    class="text-white hover:text-gray-100 dark:text-[var(--dark-white)] dark:hover:text-[var(--dark-grey)] text-2xl md:text-3xl font-bold bg-red-600 h-10 w-10 flex justify-center items-center rounded-full">
                    &times;
                </button>
            </div>
        </div>
    </transition>
</template>

<style scoped>
/* Animation flottante douce */
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
</style>
