<template>
  <div class="bg-white shadow-lg rounded-lg overflow-hidden dark:bg-[var(--card-dark)]">
    <div class="p-4">
      <h3 class="text-lg font-semibold mb-2 text-[var(--primary-blue)] dark:text-[var(--dark-gold)]">
        {{ title }}
      </h3>
    </div>
    <l-map :zoom="zoom" :center="center" class="w-full h-64 rounded">
      <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        attribution="&copy; OpenStreetMap contributors" />
      <l-marker :lat-lng="center" />
    </l-map>
  </div>
</template>

<script setup>
import { LMap, LTileLayer, LMarker } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import L from "leaflet";

// ==============================
// Configuration des icônes Leaflet
// ==============================
import iconUrl from "leaflet/dist/images/marker-icon.png";
import iconRetinaUrl from "leaflet/dist/images/marker-icon-2x.png";
import shadowUrl from "leaflet/dist/images/marker-shadow.png";
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
  iconRetinaUrl,
  iconUrl,
  shadowUrl,
});

// ==============================
// Props pour rendre le composant réutilisable
// ==============================
defineProps({
  title: { type: String, required: true },
  center: { type: Array, required: true }, // [lat, lng]
  zoom: { type: Number, default: 13 },
});
</script>

<style>
.leaflet-container {
  height: 100%;
  width: 100%;
  z-index: 10;
}
</style>
