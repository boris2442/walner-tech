<script setup>
import { Head } from '@inertiajs/inertia-vue3'

const props = defineProps({
  title: { type: String, required: true },
  description: { type: String, required: true },
  url: { type: String, default: 'https://walner.evendeco.com' },
  image: { type: String, default: 'https://walner-tech.com/assets/walner.jpg' },
  keywords: { type: String, default: 'Walner Tech, électronique, PC, portable, accessoires' }
})
</script>

<template>
  <Head>
    <title>{{ String(props.title) }}</title>
    <meta name="description" :content="String(props.description)" />
    <meta name="keywords" :content="String(props.keywords)" />

    <meta property="og:title" :content="String(props.title)" />
    <meta property="og:description" :content="String(props.description)" />
    <meta property="og:type" content="website" />
    <meta property="og:url" :content="String(props.url)" />
    <meta property="og:image" :content="String(props.image)" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" :content="String(props.title)" />
    <meta name="twitter:description" :content="String(props.description)" />
    <meta name="twitter:image" :content="String(props.image)" />
  </Head>
</template>
