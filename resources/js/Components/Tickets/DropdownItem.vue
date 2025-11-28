<script setup>

const props = defineProps({
  value: {
    type: [String, Number],
    required: true,
  },
});

const emit = defineEmits(["select"]);

const handleClick = () => {
  emit("select", props.value);
};
</script>

<template>
  <button
    type="button"
    @click="handleClick"
    class="w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 transition hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
  >
    <slot />
  </button>
</template>

