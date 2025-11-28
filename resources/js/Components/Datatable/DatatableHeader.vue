<script setup>
import { ref, computed, watch } from 'vue';

const emits = defineEmits(['toggle-sort']);

const props = defineProps({
  header: String,
  show: {
    type: Boolean,
    default: true
  },
  sortable: {
    type: Boolean,
    default: false
  },
  sortData: {
    type: Object,
    default: () => ({ column: null, order: null })
  },
  data: String,
});

// Computed properties for better reactivity
const isCurrentSortColumn = computed(() => {
  return props.sortData?.column === props.data;
});

const currentSortOrder = computed(() => {
  return isCurrentSortColumn.value ? props.sortData?.order : null;
});

// Show sort icons based on current state
const showSortIcon = computed(() => {
  return props.sortable;
});

function toggleSort() {
  if (!props.sortable) return;

  let newOrder = 'asc'; // Default to ascending

  if (isCurrentSortColumn.value) {
    // If this column is currently sorted, toggle the order
    newOrder = currentSortOrder.value === 'asc' ? 'desc' : 'asc';
  }

  emits('toggle-sort', props.data, newOrder);
}
</script>

<template>
  <th
    class="py-3 px-4 text-left text-xs text-[#6B7280] bg-gray-100 font-medium uppercase whitespace-nowrap"
    scope="col"
    :class="{ 'cursor-pointer': sortable }"
  >
    <div class="flex items-center justify-between">
      <span>{{ header }}</span>

      <div v-if="showSortIcon" class="flex items-center ml-2">
        <!-- Show different icons based on sort state -->
        <div class="relative" @click="toggleSort">
          <!-- Ascending arrow (up) -->
          <svg
            v-if="isCurrentSortColumn && currentSortOrder === 'asc'"
            class="cursor-pointer w-4 h-4 text-gray-600"
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path d="M7 14l5-5 5 5z"/>
          </svg>

          <!-- Descending arrow (down) -->
          <svg
            v-else-if="isCurrentSortColumn && currentSortOrder === 'desc'"
            class="cursor-pointer w-4 h-4 text-gray-600"
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path d="M7 10l5 5 5-5z"/>
          </svg>


          <svg
            v-else
            class="cursor-pointer w-4 h-4 text-gray-400 hover:text-gray-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
          </svg>
        </div>
      </div>
    </div>
  </th>
</template>
