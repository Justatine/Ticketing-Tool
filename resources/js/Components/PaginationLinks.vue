<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  paginator: { type: Object, required: true }
});

// convenience
const hasPrev = props.paginator.prev_page_url !== null;
const hasNext = props.paginator.next_page_url !== null;
</script>

<template>
  <div class="flex justify-between items-center px-4 py-3 border-t bg-gray-50 text-sm text-gray-600">
    <!-- left: showing text -->
    <div>
      Showing {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }} items
    </div>

    <!-- right: pagination -->
    <div class="flex items-center space-x-1">
      <!-- prev -->
      <Link
        v-if="hasPrev"
        :href="paginator.prev_page_url"
        class="px-3 py-1 border rounded hover:bg-gray-100"
      >
        Prev
      </Link>
      <span v-else class="px-3 py-1 border rounded text-gray-400 cursor-not-allowed">Prev</span>

      <!-- numbers -->
      <template v-for="(link, i) in paginator.links" :key="i">
        <Link
          v-if="link.url"
          :href="link.url"
          class="px-3 py-1 border rounded hover:bg-gray-100"
          :class="link.active ? 'bg-gray-200 font-semibold' : ''"
          v-html="link.label"
        />
        <span
          v-else
          class="px-3 py-1 border rounded text-gray-400 cursor-not-allowed"
          v-html="link.label"
        />
      </template>

      <!-- next -->
      <Link
        v-if="hasNext"
        :href="paginator.next_page_url"
        class="px-3 py-1 border rounded hover:bg-gray-100"
      >
        Next
      </Link>
      <span v-else class="px-3 py-1 border rounded text-gray-400 cursor-not-allowed">Next</span>
    </div>
  </div>
</template>
