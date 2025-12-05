<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ImageUpload from '@/Components/Tickets/ImageUpload.vue';
import InputError from '@/Components/InputError.vue';
import Dropdown from '@/Components/Forms/Dropdowns/Tickets/Dropdown.vue';
import Textarea from '@/Components/Textarea.vue';

const params = route().params;
const page = usePage();

const props = defineProps({
  assignees: Object,
  categories: Array,
  classifications: Array,
  service_types: Array,
  severity: Array,
});

console.log(props.assignees)

const form = useForm({
    title: null,
    description: null,
    status: "Open",
    assignee_id: null,
    priority: null,
    image: null,
    reporter_id: page.props.auth.user.id,
    category: null,
    classification: null,
    service_type: null,
    severity: null,
});

const submit = () => {
  form.post(route('tickets.store'), {
    onSuccess: () => {
      success('User Created', 'Ticket created')
    },
    onError: (errors) => {
      error('Create Failed', 'Please fix the errors and try again.')
    }
  })
}
</script>

<template>
  <Head title="Create Ticket" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-white">
        Create New Ticket
      </h2>
    </template>

    <div class="">
      <div class="max-w-full w-full">
        <!-- Header Actions -->
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Create a New Ticket
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

        <form @submit.prevent="submit">
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
                      placeholder="Enter ticket title"
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
                        placeholder="Enter ticket description"
                        rows="4"
                    />
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
                  <div>
                    <InputLabel value="Status" />
                    <div class="mt-4 px-4 py-2 bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 dark:text-gray-400">
                      Open (Default)
                    </div>
                  </div>
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

            </div>

            <!-- Right Column - Image Upload (1/3 width) -->
            <div class="lg:col-span-1">
              <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg p-6 sticky top-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                  Attachment
                </h2>
                <ImageUpload @image="(e) => { form.image = e; }" />
              </div>
            </div>

          </div>

          <!-- Submit Button -->
          <div class="mt-6 flex justify-end">
            <PrimaryButton :disabled="form.processing" class="px-8">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>
              Create Ticket
            </PrimaryButton>
          </div>
        </form>

      </div>
    </div>
  </AuthenticatedLayout>
</template>
