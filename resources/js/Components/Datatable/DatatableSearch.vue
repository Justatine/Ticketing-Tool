<script setup>
import { ref, watch, reactive } from 'vue';
import PrimaryButton from '../PrimaryButton.vue';
import DatatableFilterModal from './DatatableFilterModal.vue';

const props = defineProps({
  modelValue: String,
  filters: { type: Object, default: () => ({}) },
  user_details: { type: Object, default: () => ({}) }
});

// console.log('dt search: '+JSON.stringify(props.user_details.regions))

const emit = defineEmits(['update:modelValue', 'update:filters']);
const search = ref(props.modelValue || '');

watch(search, (val) => {
  emit('update:modelValue', val);
});

const showModal = ref(false);
const selectedFilters = ref({ ...props.filters });

const removeFilter = (key) => {
    // alert(key)
    const newFilters = {...selectedFilters.value};
    delete newFilters[key];
    selectedFilters.value = newFilters;
    emit('update:filters', newFilters);
}

function openFilterModal() {
  showModal.value = true;
}
function closeModal() {
  showModal.value = false;
}

function handleConfirm(filters) {
  selectedFilters.value = filters;
  emit('update:filters', filters);
  closeModal();
}
</script>

<template>
  <div class="mb-4">
    <!-- Modal -->
    <DatatableFilterModal
      :show="showModal"
      @close="closeModal"
      @confirm="handleConfirm"
      :user_details="props.user_details"
    />

    <!-- Search + Filter -->
    <div class="flex gap-2">
      <input
        type="text"
        v-model="search"
        placeholder="Search..."
        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring focus:ring-red"
      />

      <PrimaryButton @click="openFilterModal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25
               2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659
               1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75
               21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659
               7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32
               48.32 0 0 1 12 3Z" />
        </svg>
        Filter
      </PrimaryButton>
    </div>

    <!-- ✅ Active filter tags -->
    <div v-if="Object.keys(selectedFilters).length" class="mt-2 flex gap-2 flex-wrap">
      <span
        v-for="(val, key) in selectedFilters"
        :key="key"
        class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700"
      >
        {{ key }}: {{ val }}
        <button
            type="button"
            @click="removeFilter(key)"
            class="ml-2 text-blue-500 hover:text-blue-800"
            >
            &times;
        </button>
      </span>
    </div>
  </div>
</template>
