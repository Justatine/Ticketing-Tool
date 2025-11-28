<template>
  <span
    :class="[
      'border text-heading text-xs font-medium px-1.5 py-0.5 rounded',
      colorClass,
      extraClass
    ]"
  >
    {{ label }}
  </span>
</template>

<script setup>
const props = defineProps({
  label: {
    type: String,
    default: "Badge",
  },
  color: {
    type: String,
    default: "neutral", // neutral, success, danger, warning, info...
  },
  extraClass: {
    type: String,
    default: "",
  }
});

// Map color variants to classes
const colorClass = computed(() => {
  const variants = {
    neutral: "bg-neutral-primary-soft border-default",
    success: "bg-green-100 border-green-300",
    danger: "bg-red-100 border-red-300",
    warning: "bg-yellow-100 border-yellow-300",
    info: "bg-blue-100 border-blue-300",
  };

  return variants[props.color] || variants.neutral;
});
</script>
