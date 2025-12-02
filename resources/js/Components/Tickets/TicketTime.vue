<!-- RemainingTime.vue -->
<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  date: {
    type: [String, Date],
    required: true
  },
  hours: {
    type: Number,
    default: 4
  },
  showSeconds: {
    type: Boolean,
    default: false
  },
  autoUpdate: {
    type: Boolean,
    default: true
  },
  status: {
    type: String,
    default: null
  },
  dateClosed: {
    type: [String, Date],
    default: null
  }
});

const currentTime = ref(new Date());
let intervalId = null;

const formatTimeDifference = (diffMs) => {
  const hours = Math.floor(diffMs / (1000 * 60 * 60));
  const minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((diffMs % (1000 * 60)) / 1000);

  if (hours > 0) {
    return props.showSeconds
      ? `${hours}h ${minutes}m ${seconds}s`
      : `${hours}h ${minutes}m`;
  } else if (minutes > 0) {
    return props.showSeconds
      ? `${minutes}m ${seconds}s`
      : `${minutes}m`;
  } else {
    return `${seconds}s`;
  }
};

const remainingTime = computed(() => {
  // If status is closed, show resolved time
  if (props.status && props.status.toLowerCase() === 'closed') {
    const reportedDate = new Date(props.date);

    let closedDate;
    if (props.dateClosed) {
      // Use actual date_closed if available
      closedDate = new Date(props.dateClosed);
    } else {
      closedDate = new Date(reportedDate.getTime() + ((props.hours-1) * 60 * 60 * 1000));
    }

    const diffMs = closedDate - reportedDate;

    return {
      text: `Resolved in ${formatTimeDifference(diffMs)}`,
      isOverdue: false,
      isClosed: true
    };
  }

  const reportedDate = new Date(props.date);
  const deadline = new Date(reportedDate.getTime() + (props.hours * 60 * 60 * 1000));
  const now = currentTime.value;

  const diffMs = deadline - now;

  // If deadline has passed
  if (diffMs <= 0) {
    return {
      text: 'Overdue',
      isOverdue: true,
      isClosed: false
    };
  }

  // Calculate remaining time
  const text = `${formatTimeDifference(diffMs)} remaining`;

  return {
    text,
    isOverdue: false,
    isClosed: false
  };
});

const updateTime = () => {
  currentTime.value = new Date();
};

onMounted(() => {
  // Don't auto-update if ticket is closed
  if (props.autoUpdate && props.status?.toLowerCase() !== 'closed') {
    const interval = props.showSeconds ? 1000 : 60000;
    intervalId = setInterval(updateTime, interval);
  }
});

onUnmounted(() => {
  if (intervalId) {
    clearInterval(intervalId);
  }
});
</script>

<template>
  <span
    :class="{
      'text-red-600 font-semibold': remainingTime.isOverdue,
      'text-green-600 font-semibold': remainingTime.isClosed,
      'text-gray-700': !remainingTime.isOverdue && !remainingTime.isClosed
    }"
  >
    {{ remainingTime.text }}
  </span>
</template>
