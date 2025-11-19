<script setup>
// Liste des logos
const logos = [
    'partenariats/insam.jpeg',
    'partenariats/keyce.jpeg',
    'partenariats/insam.jpeg',
    'partenariats/keyce.jpeg',
    'partenariats/insam.jpeg',
    'partenariats/keyce.jpeg',
    'partenariats/insam.jpeg',
    'partenariats/keyce.jpeg',
    'partenariats/insam.jpeg',
    'partenariats/keyce.jpeg',
];
</script>

<template>
    <section class="relative flex h-[480px] w-full items-center justify-center overflow-hidden bg-gray-100 dark:bg-[#000000]">
        <!-- Ligne du haut -->
        <div class="group absolute top-20 w-full overflow-hidden sm:top-24">
            <div class="animate-marquee-left flex whitespace-nowrap group-hover:[animation-play-state:paused]">
                <img
                    v-for="(logo, i) in logos"
                    :key="'top1-' + i"
                    :src="logo"
                    class="mx-8 h-20 w-20 cursor-pointer rounded-xl border-2 border-transparent object-cover transition hover:border-blue-500 hover:shadow-[0_0_20px] hover:shadow-blue-500/40 sm:h-24 sm:w-24 md:h-28 md:w-28"
                />
                <img
                    v-for="(logo, i) in logos"
                    :key="'top2-' + i"
                    :src="logo"
                    aria-hidden="true"
                    class="mx-8 h-20 w-20 cursor-pointer rounded-xl border-2 border-transparent object-cover transition hover:border-blue-500 hover:shadow-[0_0_20px] hover:shadow-blue-500/40 sm:h-24 sm:w-24 md:h-28 md:w-28"
                />
            </div>
        </div>

        <!-- Ligne du bas -->
        <div class="group absolute bottom-20 w-full overflow-hidden sm:bottom-24">
            <div class="animate-marquee-right flex whitespace-nowrap group-hover:[animation-play-state:paused]">
                <img
                    v-for="(logo, i) in logos"
                    :key="'bottom1-' + i"
                    :src="logo"
                    class="mx-8 h-20 w-20 cursor-pointer rounded-xl border-2 border-transparent object-cover transition hover:border-yellow-400 hover:shadow-[0_0_20px] hover:shadow-yellow-400/40 sm:h-24 sm:w-24 md:h-28 md:w-28"
                />
                <img
                    v-for="(logo, i) in logos"
                    :key="'bottom2-' + i"
                    :src="logo"
                    aria-hidden="true"
                    class="mx-8 h-20 w-20 cursor-pointer rounded-xl border-2 border-transparent object-cover transition hover:border-yellow-400 hover:shadow-[0_0_20px] hover:shadow-yellow-400/40 sm:h-24 sm:w-24 md:h-28 md:w-28"
                />
            </div>
        </div>

        <!-- Card centrale -->
        <div
            class="relative z-10 mx-4 max-w-2xl rounded-2xl bg-white px-8 py-8 text-center shadow-xl transition hover:shadow-2xl sm:mx-6 sm:px-12 sm:py-10 md:mx-auto md:px-16 md:py-12 dark:bg-[#1E1E1E]"
        >
            <h2 class="text-2xl leading-tight font-bold text-gray-800 sm:text-3xl md:text-4xl dark:text-white">
                Collaborations <br />
                <span class="text-blue-600 dark:text-yellow-300">Partenariats</span>
            </h2>

            <p class="mt-3 text-sm text-gray-600 sm:text-base md:text-lg dark:text-gray-300">
                Walner Tech collabore avec des partenaires fiables <br />
                pour offrir des appareils performants et durables.
            </p>
        </div>
    </section>
</template>

<style scoped>
@keyframes marquee-left {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

@keyframes marquee-right {
    0% {
        transform: translateX(-50%);
    }
    100% {
        transform: translateX(0);
    }
}

.animate-marquee-left {
    animation: marquee-left 35s linear infinite;
}

.animate-marquee-right {
    animation: marquee-right 35s linear infinite;
}
</style>
