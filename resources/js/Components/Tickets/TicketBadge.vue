<!-- StatusBadge.vue -->
<script setup>
import { computed } from 'vue';

const props = defineProps({
  status: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: 'status', // 'status' or 'severity'
    validator: (value) => ['status', 'severity'].includes(value)
  }
});

const badgeClasses = computed(() => {
  if (props.type === 'status') {
    // Status: Open, Closed, Pending, etc.
    const statusMap = {
      'open': 'bg-green-50 border border-green-200 text-green-700',
      'new': 'bg-green-50 border border-green-200 text-green-700',
      'inprog': 'bg-yellow-50 border border-yellow-200 text-yellow-700',
      'pending': 'bg-gray-50 border border-gray-200 text-gray-700',
      'closed': 'bg-red-50 border border-red-200 text-red-700',
      'void': 'bg-blue-50 border border-blue-200 text-blue-700',
    };
    return statusMap[props.status.toLowerCase()] || 'bg-gray-50 border border-gray-200 text-gray-700';
  } else {
    // Severity: Critical, High, Normal, Low
    const severityMap = {
      'critical': 'bg-red-50 border border-red-200 text-red-700',
      'high': 'bg-orange-50 border border-orange-200 text-orange-700',
      'normal': 'bg-blue-50 border border-blue-200 text-blue-700',
      'medium': 'bg-yellow-50 border border-yellow-200 text-yellow-700',
      'low': 'bg-green-50 border border-green-200 text-green-700',
    };
    return severityMap[props.status.toLowerCase()] || 'bg-gray-50 border border-gray-200 text-gray-700';
  }
});
</script>

<template>
  <span
    :class="badgeClasses"
    class="text-xs font-medium px-2 py-1 rounded capitalize inline-block"
  >
    {{ status }}
  </span>
</template>
