<script setup>
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '../PrimaryButton.vue';
import AddTicketModal from '../Tickets/AddTicketModal.vue';
import { useToast } from '@/Composables/Toast';
import { ref } from 'vue';
import DangerButton from '../DangerButton.vue';
import { router, useForm } from '@inertiajs/vue3';

const showModal = ref(false)
const { success, error } = useToast()
const props = defineProps({
  row: { type: Object, required: true },
  columns: { type: Array, required: true }
});

const openDeleteTicketModal = () => {
  showModal.value = true
}
const closeModal = () => {
  showModal.value = false
}
const handleConfirm = async () => {
  try {
    await router.delete(route('users.destroy', props.row.id), {
      onSuccess: () => {
  router.visit(route('users.index'), {
    only: ['users'],
    preserveScroll: true,
  }),        success('User Deleted', 'The user has been successfully deleted.')
        closeModal()
      },
      onError: (errors) => {
        error('Delete Failed', 'Unable to delete the user. Please try again.')
      }
    })
  } catch (err) {
    error('Error', 'An unexpected error occurred.')
  }
}

</script>

<template>
    <AddTicketModal
        :show="showModal"
        @close="closeModal"
        @confirm="handleConfirm"
    />

    <tr class="border-b hover:bg-gray-50 transition">
        <!-- ID -->
        <td class="px-4 py-2 text-sm text-gray-700">
        {{ row.id }}
        </td>

        <!-- Name with avatar -->
        <td class="px-4 py-2 text-sm text-gray-700 flex items-center gap-2">
        <img
            class="w-8 h-8 rounded-full"
            :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(row.name)}&color=A32130&background=F5C3C9`"
            :alt="row.name"
        />
        <span>{{ row.name }}</span>
        </td>

        <!-- Email -->
        <td class="px-4 py-2 text-sm text-gray-700">
        {{ row.email }}
        </td>

        <!-- Role with badge -->
        <td class="px-4 py-2 text-sm">
        <span
            :class="[
            'px-2 py-1 rounded-full text-xs font-semibold',
            row.role === 'Admin'
                ? 'bg-red-100 text-red-700'
                : 'bg-green-100 text-green-700'
            ]"
        >
            {{ row.role }}
        </span>
        </td>

        <!-- Action button -->
        <td class="flex gap-2 px-4 py-2 text-sm text-gray-700">
            <Link
                :href="route('users.edit', row.id)"
                class=""
            >
                <PrimaryButton>
                    Edit
                </PrimaryButton>
            </Link>

            <DangerButton
                @click="openDeleteTicketModal"
            >
                Delete
            </DangerButton>
        </td>
    </tr>
</template>

<!-- <template>
  <tr class="border-b hover:bg-gray-50 transition">
    <td v-for="col in columns" :key="col.data" class="px-4 py-2 text-sm text-gray-700">
      {{ row[col.data] }}
    </td>
  </tr>
</template> -->

