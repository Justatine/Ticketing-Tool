<!-- itemDropdown.vue -->
<script setup>
import { computed } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownItem from '@/Components/Tickets/DropdownItem.vue';

const props = defineProps({
  modelValue: {
    type: [String, Number, null],
    default: null
  },
  data: {
    type: Array,
    required: true
  },
  error: {
    type: String,
    default: ''
  },
  label: {
    type: String,
    default: 'item'
  },
  placeholder: {
    type: String,
    default: 'Select item'
  },
  zIndex: {
    type: Number,
    default: 10
  }
});

const emit = defineEmits(['update:modelValue']);

const selectedLabel = computed(() => {
  const selected = props.data?.find(item => item.value === props.modelValue);
  return selected?.label ?? props.placeholder;
});
</script>

<template>
  <div class="space-y-4 relative z-{{ zIndex }}">
    <InputLabel :value="label" />
    <Dropdown align="right" width="48">
      <template #trigger>
        <span class="inline-flex w-full rounded-md">
          <button
            type="button"
            class="inline-flex w-full items-center justify-between rounded-md border border-gray-200 bg-white px-3 py-3 text-md font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
          >
            {{ selectedLabel }}
            <svg
              class="ms-2 h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </span>
      </template>

      <template #content>
        <DropdownItem
          v-for="item in data"
          :key="item.value"
          :value="item.value"
          @select="emit('update:modelValue', item.value)"
        >
          {{ item.label }}
        </DropdownItem>
      </template>
    </Dropdown>
    <InputError class="mt-2" :message="error" />
  </div>
</template>
