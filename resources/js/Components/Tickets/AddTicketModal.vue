<script setup>
import Modal from '../Modal.vue'
import PrimaryButton from '../PrimaryButton.vue'

const props = defineProps({
  show: {
    type: Boolean,
    required: true,
  },
})

const emit = defineEmits(['close', 'confirm'])
</script>

<template>
  <Modal :show="props.show" @close="$emit('close')">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">Confirm Action</h2>
      <p class="mt-2 text-sm text-gray-600">
        Are you sure you want to delete this ticket?
      </p>

      <div class="mt-4 flex justify-end space-x-2">
        <PrimaryButton @click="$emit('close')">Cancel</PrimaryButton>
        <PrimaryButton
          class="bg-red-600 hover:bg-red-700"
          @click="$emit('confirm')"
        >
          Confirm
        </PrimaryButton>
      </div>
    </div>
  </Modal>
</template>
