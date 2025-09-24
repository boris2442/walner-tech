<!-- ServicesSection.vue -->
<script setup>
const services = [
    {
        icon: "💡",
        title: "Produits innovants",
        description: "Des solutions technologiques modernes et adaptées à vos besoins.",
    },
    {
        icon: "🚚",
        title: "Livraison rapide",
        description: "Recevez vos produits en un temps record, où que vous soyez.",
    },
    {
        icon: "🛠️",
        title: "Service après-vente",
        description: "Une équipe disponible pour vous accompagner après vos achats.",
    },
    {
        icon: "📞",
        title: "Support client",
        description: "Assistance 7j/7 pour répondre à toutes vos préoccupations.",
    },
];
</script>
<!-- ServicesSection.vue -->
<template>
    <section class="bg-[var(--background-light)] py-16 dark:bg-[var(--dark-background)]" id="services">
        <div class="container mx-auto px-6 text-center">
            <!-- Titre -->
            <h2 class="mb-12 text-2xl font-bold text-[var(--primary-blue)] sm:text-3xl dark:text-[var(--dark-white)]">
                Pourquoi choisir <span class="text-[var(--highlight-gold)]">Walner Tech</span> ?
            </h2>




            <!-- Grid des services -->
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div v-for="(service, index) in services" :key="index"
                    class="rounded-xl bg-white p-6 shadow-md transition hover:shadow-lg dark:bg-[#2A2A2A] hover:bg-[var(--primary-blue)]  hover:text-white group ">
                    <div class="mb-4 flex justify-center text-4xl text-[var(--accent-cyan)]">
                        {{ service.icon }}
                    </div>
                    <h3
                        class="mb-2 text-lg font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-white)] group-hover:text-[#FFE600]">
                        {{ service.title }}
                    </h3>
                    <p class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)] group-hover:text-gray-300">
                        {{ service.description }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
