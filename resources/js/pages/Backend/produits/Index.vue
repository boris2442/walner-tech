<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import createProducts from '@/routes/products';
import { Inertia } from '@inertiajs/inertia';
import { Edit, Trash } from 'lucide-vue-next';
import FlashMessageFrontend from '@/components/frontend/flash/FlashMessageFrontend.vue';

interface Product {
  id: number;
  title: string;
  prix: number;
  category: { id: number; name: string } | null;
  images: { url_image: string }[];
  created_at: string;
  likes_count: number; // ✅ ajout du compteur de likes
}

const props = defineProps<{
  products: { data: Product[]; links: any[] };
  stats: any;
  filters: { search?: string; category?: string };
  categories: { id: number; name: string }[];
}>();

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');
const showGlobalMenu = ref(false);


function getImageUrl(path: string) {
  return path ? `/${path}` : '/fallback.png';
}

const productsWithImages = computed(() =>
  props.products.data.map(p => ({
    ...p,
    images: p.images.length ? p.images.map(img => ({ path: img.url_image })) : [],
  }))
);

const filteredProducts = computed(() => {
  let items = productsWithImages.value;
  if (search.value) items = items.filter(p => p.title.toLowerCase().includes(search.value.toLowerCase()));
  if (category.value) items = items.filter(p => p.category?.id == category.value);
  return items;
});

const deleteProduct = (id: number) => {
  if (confirm('Voulez-vous vraiment supprimer ce produit ?')) {
    Inertia.delete(`/admin/products/${id}`, { preserveScroll: true });
  }
};

// Auto-slide & touch
const currentIndexes = ref<{ [key: number]: number }>({});
let interval: ReturnType<typeof setInterval> | null = null;

onMounted(() => {
  interval = setInterval(() => {
    filteredProducts.value.forEach(prod => {
      if (prod.images.length > 1) {
        currentIndexes.value[prod.id] = ((currentIndexes.value[prod.id] || 0) + 1) % prod.images.length;
      }
    });
  }, 3000);
});

onUnmounted(() => {
  if (interval) clearInterval(interval);
});

// Touch swipe
const touchStartX = ref<{ [key: number]: number }>({});
const touchEndX = ref<{ [key: number]: number }>({});

function handleTouchStart(event: TouchEvent, id: number) {
  touchStartX.value[id] = event.touches[0].clientX;
}
function handleTouchMove(event: TouchEvent, id: number) {
  touchEndX.value[id] = event.touches[0].clientX;
}
function handleTouchEnd(id: number) {
  const start = touchStartX.value[id];
  const end = touchEndX.value[id];
  if (start != null && end != null) {
    const diff = start - end;
    if (diff > 50) { // swipe left
      currentIndexes.value[id] = (currentIndexes.value[id] + 1) % filteredProducts.value.find(p => p.id === id)?.images.length!;
    } else if (diff < -50) { // swipe right
      const len = filteredProducts.value.find(p => p.id === id)?.images.length!;
      currentIndexes.value[id] = (currentIndexes.value[id] - 1 + len) % len;
    }
  }
  touchStartX.value[id] = 0;
  touchEndX.value[id] = 0;
}

const breadcrumbs = [{ title: 'Produits', href: '/admin/products' }];


const totalLikes = computed(() =>
  props.products.data.reduce((sum, p) => sum + p.likes_count, 0)
);

</script>

<template>
  <FlashMessageFrontend v-if="$page.props.flash?.message" :message="$page.props.flash.message"
    :link="$page.props.flash.link" />

  <Head title="Produits" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4 p-4">

      <!-- KPI Cards -->
      <div class="grid gap-4 grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-5">
        <div class="kpi-card">
          <h3>Total Produits</h3>
          <p>{{ props.stats.total }}</p>
        </div>
        <div class="kpi-card">
          <h3>Ajoutés cette semaine</h3>
          <p>{{ props.stats.addedThisWeek }}</p>
        </div>
        <div v-for="item in props.stats.byCategory" :key="item.category?.id" class="kpi-card">
          <h3>{{ item.category?.name || 'Non catégorisé' }}</h3>
          <p>{{ item.count }}</p>
        </div>
        <div class="kpi-card">
          <h3>Total Likes</h3>
          <p>{{ totalLikes }}</p>
        </div>

      </div>

      <!-- Filtres -->
      <div class="flex flex-wrap gap-4 mb-4 p-2 items-center">
        <input v-model="search" placeholder="Rechercher un produit..."
          class="border p-2 rounded flex-1 min-w-[200px]" />
        <select v-model="category" class="border p-2 rounded min-w-[160px]">
          <option value="">Toutes les catégories</option>
          <option v-for="cat in props.categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
        </select>

        <div class="relative global-menu">
          <button @click.stop="showGlobalMenu = !showGlobalMenu"
            class="p-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700">⋮</button>
          <div v-if="showGlobalMenu"
            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border rounded shadow-lg z-50">
            <ul>
              <li>
                <Link prefetch :href="createProducts.create().url"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">
                Créer un produit
                </Link>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Liste produits -->
      <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
        <div v-for="prod in filteredProducts" :key="prod.id"
          class="border rounded flex flex-col gap-2 bg-white dark:bg-[#1E1E1E] relative overflow-hidden">

          <div class="relative rounded min-h-[160px] sm:min-h-[200px] md:min-h-[240px] lg:min-h-[260px]"
            @touchstart="e => handleTouchStart(e, prod.id)" @touchmove="e => handleTouchMove(e, prod.id)"
            @touchend="() => handleTouchEnd(prod.id)">

            <img v-if="prod.images.length" :src="getImageUrl(prod.images[currentIndexes[prod.id] || 0]?.path)"
              :alt="prod.title" class="w-full h-full object-cover rounded transition-opacity duration-700"
              loading="lazy" />
            <div v-else class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
              <span class="text-gray-500 text-sm">Aucune image</span>
            </div>

            <div class="absolute bottom-2 right-2 flex gap-2 z-50">
              <Link :href="`/admin/products/${prod.id}/edit`"
                class="p-1 bg-blue-500 text-white rounded hover:bg-blue-600">
              <Edit class="w-4 h-4" />
              </Link>
              <button @click="deleteProduct(prod.id)" class="p-1 bg-red-500 text-white rounded hover:bg-red-600">
                <Trash class="w-4 h-4" />
              </button>
            </div>
          </div>

          <div class="flex-1 flex flex-col justify-between mt-2 px-2 pb-2">
            <h3 class="font-bold truncate">{{ prod.title }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">{{ prod.category?.name || 'Non catégorisé' }}</p>
            <!-- <p class="font-semibold">{{ prod.prix }} FCFA</p> -->

            <div class="flex justify-between items-center mt-1">
              <p class="font-semibold">{{ prod.prix }} FCFA</p>
              <div class="flex items-center text-gray-600 dark:text-gray-300 text-sm">
                ❤️ {{ prod.likes_count }}
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style>
.kpi-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 1rem;
  border: 1px solid #d1d5db;
  border-radius: 0.75rem;
  transition: transform 0.2s;
}

.kpi-card:hover {
  transform: translateY(-0.25rem);
}

.kpi-card h3 {
  font-size: 0.875rem;
  font-weight: 600;
  color: #4b5563;
}

.kpi-card p {
  font-size: 1.25rem;
  font-weight: 700;
  /* color: #111827; */
}
</style>
