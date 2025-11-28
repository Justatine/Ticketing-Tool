<script setup>
import InputLabel from '../InputLabel.vue'
import Modal from '../Modal.vue'
import PrimaryButton from '../PrimaryButton.vue'
import Dropdown from '../Tickets/Dropdown.vue'
import DropdownItem from '../Tickets/DropdownItem.vue'
import { ref } from 'vue'

const props = defineProps({ show: Boolean })
const emit = defineEmits(['close', 'confirm'])

const role = ref(null)

function applyFilters() {
  emit('confirm', { role: role.value }) // ✅ send selected filter
}
</script>

<template>
  <Modal :show="props.show" @close="$emit('close')">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">Filter Users</h2>

      <div class="mt-2">
        <InputLabel for="role" value="Role" />
        <select
          v-model="role"
          class="w-full mt-1 border-gray-300 rounded-md shadow-sm"
        >
          <option value="">All</option>
          <option value="Admin">Admin</option>
          <option value="User">User</option>
        </select>
      </div>

      <div class="mt-4 flex justify-end space-x-2">
        <PrimaryButton @click="$emit('close')">Cancel</PrimaryButton>
        <PrimaryButton class="bg-green-600 hover:bg-green-700" @click="applyFilters">
          Apply
        </PrimaryButton>
      </div>
    </div>
  </Modal>
</template>
