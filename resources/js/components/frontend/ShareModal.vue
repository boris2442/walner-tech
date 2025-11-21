<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- backdrop -->
        <div class="absolute inset-0 bg-black/40" @click="close"></div>

        <!-- modal -->
        <div class="relative z-10 w-[90%] max-w-md rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800" role="dialog" aria-modal="true">
            <button class="absolute top-3 right-3 text-2xl" @click="close" aria-label="Close">✕</button>

            <div class="grid grid-cols-2 gap-6 py-4">
                <a :href="shareUrls.whatsapp" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3">
                    <font-awesome-icon :icon="['fab', 'whatsapp']" class="h-7 w-7" />
                    <span>WhatsApp</span>
                </a>

                <a :href="shareUrls.facebook" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3">
                    <font-awesome-icon :icon="['fab', 'facebook']" class="h-7 w-7" />
                    <span>Facebook</span>
                </a>

                <a :href="shareUrls.telegram" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3">
                    <font-awesome-icon :icon="['fab', 'telegram']" class="h-7 w-7" />
                    <span>Telegram</span>
                </a>

                <a :href="shareUrls.twitter" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3">
                    <font-awesome-icon :icon="['fab', 'twitter']" class="h-7 w-7" />
                    <span>Twitter</span>
                </a>

                <a :href="shareUrls.linkedin" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3">
                    <font-awesome-icon :icon="['fab', 'linkedin']" class="h-7 w-7" />
                    <span>LinkedIn</span>
                </a>

                <a :href="shareUrls.email" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3">
                    <font-awesome-icon :icon="['fas', 'envelope']" class="h-7 w-7" />
                    <span>Email</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script setup>
const emit = defineEmits(['close']);

const props = defineProps({
    show: { type: Boolean, default: false },
    product: { type: Object, required: true },
    url: { type: String, required: false },
});

// -- Données du produit --
const productTitle = props.product?.title || '';
const productUrl = props.url || window.location.href;
const text = ` ${productUrl}`;

function enc(s) {
    return encodeURIComponent(s);
}

// -- URLs de partage --
const shareUrls = {
    whatsapp: `https://wa.me/?text=${enc(text)}`,
    facebook: `https://www.facebook.com/sharer/sharer.php?u=${enc(productUrl)}&t=${enc(productTitle)}`,
    telegram: `https://t.me/share/url?url=${enc(productUrl)}&text=${enc(productTitle)}`,
    twitter: `https://twitter.com/intent/tweet?text=${enc(productTitle)}&url=${enc(productUrl)}`,
    linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${enc(productUrl)}`,
    email: `mailto:?subject=${enc(productTitle)}&body=${enc(text)}`,
};

// -- Fermeture du modal --
function close() {
    emit('close');
}
</script>

<style scoped>
a {
    color: inherit;
    text-decoration: none;
    padding: 8px;
    border-radius: 8px;
}

a:hover {
    background: rgba(0, 0, 0, 0.04);
}
</style>
