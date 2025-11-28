<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';
import { router, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import AddTicketModal from '@/Components/Tickets/AddTicketModal.vue';
import { ref } from 'vue';
import { useToast } from '@/Composables/Toast';

const showModal = ref(false)
const { success, error } = useToast()

const openDeleteTicketModal = () => {
  showModal.value = true
}
const closeModal = () => {
  showModal.value = false
}
const handleConfirm = async () => {
  try {
    await router.delete(route('tickets.destroy', props.ticket.id), {
      onSuccess: () => {
        success('Ticket Deleted', 'The ticket has been successfully deleted.')
        closeModal()
      },
      onError: (errors) => {
        error('Delete Failed', 'Unable to delete the ticket. Please try again.')
      }
    })
  } catch (err) {
    error('Error', 'An unexpected error occurred.')
  }
}

const props = defineProps({
  ticket: Object,
  canModify: Boolean
});

console.log(props.ticket.id)

</script>

<template>
  <Head :title="`Ticket #${ticket.id}`" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-white">
        Ticket Details
      </h2>
    </template>

    <div class="py-12">
        <AddTicketModal
        :show="showModal"
        @close="closeModal"
        @confirm="handleConfirm"
        />

      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-lg p-6">

            <div class="flex justify-between mb-6">
                <div class="">
                    Ticket Details
                </div>
                <div class="flex gap-2">
                    <div>
                        <Link
                            :href="route('tickets.index')"
                            class=""
                        >
                            <PrimaryButton>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                </svg>
                                Back
                            </PrimaryButton>
                        </Link>
                    </div>
                    <div>
                        <Link
                            v-if="canModify"
                            :href="route('tickets.edit', ticket.id)"
                            class=""
                        >
                            <PrimaryButton>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                Edit
                            </PrimaryButton>
                        </Link>
                    </div>
                    <div>
                        <DangerButton
                            @click="openDeleteTicketModal"
                            v-if="canModify"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            Delete
                        </DangerButton>
                    </div>
                    <div>

                    </div>
                </div>

            </div>

            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-2xl overflow-hidden">
                <!-- Header Section -->
                <div class="relative h-48 bg-gradient-to-r from-indigo-500 to-purple-600">

                    <img
                        :src="`/storage/${ticket.image}`"
                        class="absolute inset-0 w-full h-full bg-slate-400 object-cover opacity-30"
                        alt=""
                    >
                    <div class="absolute inset-0 flex items-center justify-center">
                    <h1 class="text-3xl font-bold text-white bg-slate-500 p-3 rounded-md">
                        Ticket #{{ ticket.id }}
                    </h1>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="flex flex-col space-y-6">

                        <div class="space-y-2">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Status</h3>
                            <span
                            class="inline-block px-3 py-1 text-sm font-medium rounded-full"
                            :class="ticket.status.toLowerCase() === 'open' ? 'bg-green-100 text-green-800'
                                : ticket.status.toLowerCase() == 'closed' ? 'bg-red-100 text-red-800'
                                : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300'"
                            >
                            {{ ticket.status }}
                            </span>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Title</h3>
                                <p class="text-gray-600 dark:text-gray-300">{{ ticket.title }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Description</h3>
                                <p class="text-gray-600 dark:text-gray-300">{{ ticket.description }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Assigned To</h3>
                                <p class="text-gray-600 dark:text-gray-300">{{ ticket.assignee?.name }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Requestor</h3>
                                <p class="text-gray-600 dark:text-gray-300">{{ ticket.reporter?.name }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Created At</h3>
                                {{ new Date(ticket.created_at).toLocaleString("en-US", {
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric",
                                    hour: "numeric",
                                    minute: "numeric",
                                    hour12: true
                                }) }}
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Updated At</h3>
                               {{ new Date(ticket.updated_at).toLocaleString("en-US", {
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric",
                                    hour: "numeric",
                                    minute: "numeric",
                                    hour12: true
                                }) }}
                            </div>

                        </div>

                    </div>
                </div>
                </div>

        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
