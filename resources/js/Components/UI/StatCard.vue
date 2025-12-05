<script setup>
import { TrendingUp, TrendingDown } from 'lucide-vue-next';

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  value: {
    type: String,
    required: true
  },
  change: {
    type: String,
    required: true
  },
  isPositive: {
    type: Boolean,
    required: true
  },
  icon: {
    type: [Object,Function],
    default: '📊'
  }
});
</script>

<template>
  <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ title }}</p>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ value }}</p>
        <!-- <p
          :class="[
            'text-xs mt-2 font-medium flex items-center gap-1',
            isPositive ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500'
          ]"
        >
          <TrendingUp v-if="isPositive" class="w-3 h-3" />
          <TrendingDown v-else class="w-3 h-3" />
          {{ change }} from last month
        </p> -->
      </div>
      <div class="w-12 h-12 bg-red-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center text-xl">
        <!-- {{ icon }} -->
        <component v-if="icon" :is="icon" class="w-6 h-6" />
        <span v-else class="text-xl">📊</span>
      </div>
    </div>
  </div>
</template>
