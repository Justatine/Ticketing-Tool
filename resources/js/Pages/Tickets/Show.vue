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
import TicketBadge from '@/Components/Tickets/TicketBadge.vue';
import TicketTime from '@/Components/Tickets/TicketTime.vue';

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
console.log(props.canModify)

</script>

<template>
  <Head :title="`Ticket #${ticket.id}`" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-white">
        Ticket Details
      </h2>
    </template>

    <div class="">

        <AddTicketModal
            :show="showModal"
            @close="closeModal"
            @confirm="handleConfirm"
        />

      <div class="max-w-full w-full">
        <!-- Header Actions -->
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Ticket #{{ ticket.id }}
          </h1>
          <div class="flex gap-3">
            <Link :href="route('tickets.index')">
              <PrimaryButton>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Back
              </PrimaryButton>
            </Link>
            <Link v-if="canModify" :href="route('tickets.edit', ticket.id)">
              <PrimaryButton>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                Edit
              </PrimaryButton>
            </Link>
            <DangerButton @click="openDeleteTicketModal" v-if="canModify">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
              </svg>
              Delete
            </DangerButton>
          </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          <!-- Left Column - Details (2/3 width) -->
          <div class="lg:col-span-2 space-y-6">

            <!-- Basic Information -->
            <div class="bg-white border border-gray-200 dark:bg-slate-800 shadow-sm rounded-lg p-6">
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                Basic Information
              </h2>
              <div class="space-y-4">
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.title }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.description }}</p>
                </div>
              </div>
            </div>

            <!-- Assignment Details -->
            <div class="bg-white border border-gray-200 dark:bg-slate-800 shadow-sm rounded-lg p-6">
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                Assignment
              </h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned To</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.assignee?.name || 'Unassigned' }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned Team</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.assignee_team_label || 'None' }}</p>
                </div>
              </div>
            </div>

            <!-- Reporter Details -->
            <div class="bg-white border border-gray-200 dark:bg-slate-800 shadow-sm rounded-lg p-6">
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                Reporter Information
              </h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Reported By</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.reporter?.name }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Department</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.reporter_department_label }}</p>
                </div>
              </div>
            </div>

            <!-- Classification & Priority -->
            <div class="bg-white border border-gray-200 dark:bg-slate-800 shadow-sm rounded-lg p-6">
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                Classification & Priority
              </h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.category_label }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Classification</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.classification_label }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Service Type</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.service_type_label }}</p>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Severity</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">{{ ticket.severity_label }}</p>
                </div>
              </div>
            </div>

            <!-- Timeline & Resolution -->
            <div class="bg-white border border-gray-200 dark:bg-slate-800 shadow-sm rounded-lg p-6">
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                Timeline & Resolution
              </h2>
              <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Date Reported</label>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                      {{ new Date(ticket.date_reported).toLocaleString("en-US", {
                        year: "numeric",
                        month: "long",
                        day: "numeric",
                        hour: "numeric",
                        minute: "numeric",
                        hour12: true
                      }) }}
                    </p>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Date Closed</label>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                      <span v-if="ticket.date_closed">
                        {{ new Date(ticket.date_closed).toLocaleString("en-US", {
                          year: "numeric",
                          month: "long",
                          day: "numeric",
                          hour: "numeric",
                          minute: "numeric",
                          hour12: true
                        }) }}
                      </span>
                      <span v-else class="text-gray-500 dark:text-gray-400 italic">Not closed yet</span>
                    </p>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Remaining Time</label>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                      <TicketTime
                        :date="ticket.date_reported"
                        :hours="4"
                        :show-seconds="true"
                        :status="ticket.status"
                        :updatedAt="ticket.updated_at"
                      />
                    </p>
                  </div>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Resolution</label>
                  <p class="mt-1 text-base text-gray-900 dark:text-white">
                    {{ ticket.resolution || 'No resolution provided yet' }}
                  </p>
                </div>
              </div>
            </div>

          </div>

          <!-- Right Column - Status & Image (1/3 width) -->
          <div class="lg:col-span-1 space-y-6">

            <!-- Status Card -->
            <div class="bg-white border border-gray-200 dark:bg-slate-800 shadow-sm rounded-lg p-6 top-6">
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                Status
              </h2>
              <div class="flex justify-start">
                <TicketBadge :status="ticket.status" type="status" />
              </div>
            </div>

            <!-- Image Card -->
            <div class="bg-white border border-gray-200 dark:bg-slate-800 shadow-sm rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                Attachment
            </h2>

            <div class="aspect-video rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                <a v-if="ticket.image" :href="`/storage/${ticket.image}`" target="_blank" rel="noopener noreferrer">
                <img
                    :src="`/storage/${ticket.image}`"
                    class="w-full h-full object-fit"
                    alt="Ticket attachment"
                >
                </a>
                <div v-else class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                </div>
            </div>
            </div>

          </div>

        </div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
