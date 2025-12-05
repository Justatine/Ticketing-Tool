<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ImageUpload from '@/Components/Tickets/ImageUpload.vue';
import Dropdown from '@/Components/Forms/Dropdowns/Tickets/Dropdown.vue';
import Textarea from '@/Components/Textarea.vue';

const params = route().params;
const page = usePage();

const props = defineProps({
  ticket: Object,
  assignees: Object,
  categories: Array,
  classifications: Array,
  service_types: Array,
  severity: Array,
  statuses: Array,
});

const form = useForm({
    title: props.ticket.title ?? '',
    description: props.ticket?.description ?? '',
    status: props.ticket?.status ?? '',
    assignee_id: props.ticket?.assignee_id ?? '',
    reporter_id: page.props.auth.user.id,
    category: props.ticket?.category ?? '',
    classification: props.ticket?.classification ?? '',
    service_type: props.ticket?.service_type ?? '',
    severity: props.ticket?.severity ?? '',
    reporter_department: props.ticket?.reporter_department ?? '',
    resolution: props.ticket?.resolution ?? '',
    image: null,
    _method: 'PUT'
});
</script>

<template>
  <Head title="Edit Ticket" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-white">
        Edit Ticket
      </h2>
    </template>

    <div class="">
      <div class="max-w-full w-full">
        <!-- Header Actions -->
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Update Ticket #{{ ticket.id }}
          </h1>
          <Link :href="route('tickets.index')">
            <PrimaryButton>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
              </svg>
              Back
            </PrimaryButton>
          </Link>
        </div>

        <form @submit.prevent="form.put(route('tickets.update', ticket.id))">
          <!-- Main Content Grid -->
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column - Form Fields (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">

              <!-- Basic Information -->
              <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                  Basic Information
                </h2>
                <div class="space-y-4">
                  <div>
                    <InputLabel for="title" value="Title" />
                    <TextInput
                      id="title"
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.title"
                      icon="heading"
                      placeholder="Enter title"
                      required
                      autofocus
                      autocomplete="title"
                    />
                    <InputError class="mt-2" :message="form.errors.title" />
                  </div>

                  <div>
                    <InputLabel for="description" value="Description" />
                    <Textarea
                        id="description"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        placeholder="Enter description details..."
                        rows="4"
                    />

                    <!-- <TextInput
                      id="description"
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.description"
                      icon="heading"
                      placeholder="Enter description"
                      required
                      autocomplete="description"
                    /> -->

                    <InputError class="mt-2" :message="form.errors.description" />
                  </div>
                </div>
              </div>

              <!-- Assignment -->
              <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                  Assignment
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <Dropdown
                    v-model="form.assignee_id"
                    :data="$page.props.assignees"
                    :error="form.errors.assignee_id"
                    label="Assignee"
                    placeholder="Select Assignee"
                  />

                  <Dropdown
                    v-model="form.status"
                    :data="$page.props.statuses"
                    :error="form.errors.status"
                    label="Status"
                    placeholder="Select Status"
                  />
                </div>
              </div>

              <!-- Classification & Priority -->
              <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                  Classification & Priority
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <Dropdown
                    v-model="form.category"
                    :data="$page.props.categories"
                    :error="form.errors.category"
                    label="Category"
                    placeholder="Select Category"
                  />

                  <Dropdown
                    v-model="form.classification"
                    :data="$page.props.classifications"
                    :error="form.errors.classification"
                    label="Classification"
                    placeholder="Select Classification"
                  />

                  <Dropdown
                    v-model="form.service_type"
                    :data="$page.props.service_types"
                    :error="form.errors.service_type"
                    label="Service Type"
                    placeholder="Select Service Type"
                  />

                  <Dropdown
                    v-model="form.severity"
                    :data="$page.props.severity"
                    :error="form.errors.severity"
                    label="Severity"
                    placeholder="Select Severity"
                  />
                </div>
              </div>

              <!-- Resolution -->
              <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                  Resolution
                </h2>
                <div>
                  <InputLabel for="resolution" value="Resolution Notes" />
                  <Textarea
                    id="resolution"
                    class="mt-1 block w-full"
                    v-model="form.resolution"
                    placeholder="Enter resolution details..."
                    rows="4"
                  />
                  <InputError class="mt-2" :message="form.errors.resolution" />
                </div>
              </div>

            </div>

            <!-- Right Column - Image Upload (1/3 width) -->
            <div class="lg:col-span-1">
              <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg p-6 sticky top-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                  Attachment
                </h2>
                <ImageUpload
                  @image="(e) => (form.image = e)"
                  :ticketImage="ticket.image"
                />
              </div>
            </div>

          </div>

          <!-- Submit Button -->
          <div class="mt-6 flex justify-end">
            <PrimaryButton :disabled="form.processing" class="px-8">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
              </svg>
              Update Ticket
            </PrimaryButton>
          </div>
        </form>

      </div>
    </div>
  </AuthenticatedLayout>
</template>
