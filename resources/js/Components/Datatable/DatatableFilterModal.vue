<script setup>
import Dropdown from '../Forms/Dropdowns/Tickets/Dropdown.vue'
import InputLabel from '../InputLabel.vue'
import Modal from '../Modal.vue'
import PrimaryButton from '../PrimaryButton.vue'
import DropdownItem from '../Tickets/DropdownItem.vue'
import { ref } from 'vue'

const props = defineProps({
    show: Boolean,
    user_details: { type: Object }
})

// console.log('dt search: '+JSON.stringify(props.user_details.regions))

const emit = defineEmits(['close', 'confirm'])

const role = ref(null)
const team = ref(null)
const department = ref(null)
const region = ref(null)

function applyFilters() {
  emit('confirm', { Role: role.value })
//   console.log('role value: '+ role.value)
}
</script>

<template>
  <Modal :show="props.show" @close="$emit('close')">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900">Filter Users</h2>

      <div class="mt-2">
        <Dropdown
            v-model="role"
            :data="props.user_details.roles"
            label="Role"
            placeholder="Select Role"
        />
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
