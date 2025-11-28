<script setup>
import { computed } from 'vue';

const emits = defineEmits(['page-change']);

const props = defineProps({
  totalItems: { type: Number, required: true },
  perPage: { type: Number, default: 10 },
  currentPage: { type: Number, default: 1 }
});

const totalPages = computed(() => Math.ceil(props.totalItems / props.perPage));

// calculate start–end indexes for “showing x–y of z items”
const startItem = computed(() => (props.currentPage - 1) * props.perPage + 1);
const endItem = computed(() =>
  Math.min(props.currentPage * props.perPage, props.totalItems)
);

function changePage(page) {
  if (page >= 1 && page <= totalPages.value) {
    emits('page-change', page);
  }
}
</script>

<template>
  <div class="flex justify-between items-center px-4 py-3 border-t bg-gray-50 text-sm text-gray-600">
    <!-- left: showing text -->
    <div>
      Showing {{ startItem }} to {{ endItem }} of {{ totalItems }} items
    </div>

    <!-- right: pagination -->
    <div class="flex items-center space-x-1">
      <!-- prev -->
      <button
        class="px-3 py-1 border rounded hover:bg-gray-100 disabled:opacity-50"
        :disabled="currentPage === 1"
        @click="changePage(currentPage - 1)"
      >
        Prev
      </button>

      <!-- numbers -->
      <button
        v-for="page in totalPages"
        :key="page"
        class="px-3 py-1 border rounded hover:bg-gray-100"
        :class="page === currentPage ? 'bg-gray-200 font-semibold' : ''"
        @click="changePage(page)"
      >
        {{ page }}
      </button>

      <!-- next -->
      <button
        class="px-3 py-1 border rounded hover:bg-gray-100 disabled:opacity-50"
        :disabled="currentPage === totalPages"
        @click="changePage(currentPage + 1)"
      >
        Next
      </button>
    </div>
  </div>
</template>
