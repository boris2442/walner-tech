<!-- ServicesSection.vue -->
<script setup>
import { onMounted, ref } from "vue";
import ScrollReveal from "scrollreveal";
// import LoginReminder from '@/components/frontend/flash/LoginReminder.vue';
const services = [
    {
        icon: "💻",
        title: "Produits de qualité",
        description: "Ordinateurs, téléphones et équipements électroniques fiables, adaptés à vos besoins personnels et professionnels.",
    },
    {
        icon: "🚚",
        title: "Livraison rapide",
        description: "Recevez vos PC, smartphones ou accessoires (clé USB, disque dur, projecteur...) rapidement et en toute sécurité.",
    },
    {
        icon: "🛠️",
        title: "Service après-vente",
        description: "Assistance technique et garantie pour vos appareils électroniques afin d’assurer leur performance durable.",
    },
    {
        icon: "📞",
        title: "Support client",
        description: "Un service d’assistance disponible 7j/7 pour répondre à vos questions et vous guider dans vos choix.",
    }

];
const visible = ref([]);

// Détection au scroll (Intersection Observer)
onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const index = entry.target.getAttribute("data-index");
                    visible.value[index] = true;
                    observer.unobserve(entry.target); // 👈 stoppe l'observation après apparition
                }
            });
        },
        { threshold: 0.2 }
    );

    document.querySelectorAll(".service-card").forEach((el) => observer.observe(el));
});

// scroll Reveal

onMounted(() => {
    const cards = document.querySelectorAll(".service-card");

    cards.forEach((card, i) => {
        ScrollReveal().reveal(card, {
            duration: 800,
            distance: "50px",
            origin: "bottom",
            easing: "ease-out",
            reset: false,       // ne rejoue pas
            delay: i * 400,     // i = index dans la boucle
        });
    });
});

</script>
<!-- ServicesSection.vue -->
<template>
    <section class="bg-[var(--background-light)] py-4 dark:bg-[var(--dark-background)]" id="services">
        <!-- <LoginReminder /> -->
        <div class="container mx-auto px-6 text-center">
            <!-- Titre -->
            <h2 class="mb-12 text-2xl font-bold text-[var(--primary-blue)] sm:text-3xl dark:text-[var(--dark-white)]">
                Pourquoi choisir <span class="text-[var(--highlight-gold)]">Walner Tech</span> ?
            </h2>

            <!-- Grid des services -->
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div v-for="(service, index) in services" :key="index"
                    class="service-card rounded-xl bg-white p-6 shadow-md transition hover:shadow-lg dark:bg-[#2A2A2A] hover:bg-[var(--primary-blue)]  hover:text-white group dark:hover:bg-[var(--card-dark)]"
                    :class="{
                        'animate-fade-in-up': visible[index],
                    }" :data-index="index">
                    <div class="mb-4 flex justify-center text-4xl text-[var(--accent-cyan)] animate-bounce-slow">
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
<style scoped>
/* Animation fade-in-up */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease forwards;
}

/* Animation lente pour les icônes */
@keyframes bounceSlow {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-6px);
    }
}

.animate-bounce-slow {
    animation: bounceSlow 2.5s infinite;
}
</style>