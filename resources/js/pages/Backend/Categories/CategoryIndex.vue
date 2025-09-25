<template>
    <h1>Categoty List</h1>
    <!-- Flash global -->
    <FlashMessage v-if="$page.props.flash?.success" :message="$page.props.flash.success" type="success" />

    <FlashMessage v-if="$page.props.flash?.error" :message="$page.props.flash.error" type="error" />


</template>
<script setup>
import FlashMessage from '@/components/backend/flash/FlashMessage.vue';
</script>
<style scoped></style>