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
                <!-- Service 1 -->
                <div class="rounded-xl bg-white p-6 shadow-md transition hover:shadow-lg dark:bg-[#2A2A2A]">
                    <div class="mb-4 flex justify-center text-4xl text-[var(--accent-cyan)]">💡</div>
                    <h3 class="mb-2 text-lg font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-white)]">Produits innovants</h3>
                    <p class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">
                        Des solutions technologiques modernes et adaptées à vos besoins.
                    </p>
                </div>

                <!-- Service 2 -->
                <div class="rounded-xl bg-white p-6 shadow-md transition hover:shadow-lg dark:bg-[#2A2A2A]">
                    <div class="mb-4 flex justify-center text-4xl text-[var(--accent-cyan)]">🚚</div>
                    <h3 class="mb-2 text-lg font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-white)]">Livraison rapide</h3>
                    <p class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">
                        Recevez vos produits en un temps record, où que vous soyez.
                    </p>
                </div>

                <!-- Service 3 -->
                <div class="rounded-xl bg-white p-6 shadow-md transition hover:shadow-lg dark:bg-[#2A2A2A]">
                    <div class="mb-4 flex justify-center text-4xl text-[var(--accent-cyan)]">🛠️</div>
                    <h3 class="mb-2 text-lg font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-white)]">Service après-vente</h3>
                    <p class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">
                        Une équipe disponible pour vous accompagner après vos achats.
                    </p>
                </div>

                <!-- Service 4 -->
                <div class="rounded-xl bg-white p-6 shadow-md transition hover:shadow-lg dark:bg-[#2A2A2A]">
                    <div class="mb-4 flex justify-center text-4xl text-[var(--accent-cyan)]">📞</div>
                    <h3 class="mb-2 text-lg font-semibold text-[var(--primary-blue)] dark:text-[var(--dark-white)]">Support client</h3>
                    <p class="text-[var(--text-secondary)] dark:text-[var(--dark-grey)]">
                        Assistance 7j/7 pour répondre à toutes vos préoccupations.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
