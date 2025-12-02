<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TicketCard from '@/Components/TicketCard.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import DropdownLink from '@/Components/Tickets/DropdownItem.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DropdownItem from '@/Components/Tickets/DropdownItem.vue';
import ImageUpload from '@/Components/Tickets/ImageUpload.vue';
import InputError from '@/Components/InputError.vue';

import Dropdown from '@/Components/Forms/Dropdowns/Tickets/Dropdown.vue';

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
    title:null,
    description:null,
    status:"Open",
    assignee_id:null,
    priority:null,
    image:null,
    reporter_id: page.props.auth.user.id,
    category:null,
    classification:null,
    service_type:null,
    severity:null,
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
  <Head title="Tickets" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
        Tickets
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-lg p-6">

            <div class="flex justify-between mb-6">
                <div class="">
                    Create a new Ticket
                </div>
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

            <form
                @submit.prevent="submit"
                class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
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

                <div class="space-y-4">
                    <InputLabel for="description" value="Description" />

                    <TextInput
                        id="description"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        icon="heading"
                        placeholder="Enter description"
                        required
                        autofocus
                        autocomplete="description"
                    />

                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <!-- department -->
                <Dropdown
                    v-model="form.category"
                    :data="$page.props.categories"
                    :error="form.errors.category"
                    label="Category"
                    placeholder="Select Category"
                />

                <!-- department -->
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
                    label="Service type"
                    placeholder="Select Service type"
                />

                <Dropdown
                    v-model="form.severity"
                    :data="$page.props.severity"
                    :error="form.errors.severity"
                    label="Severity"
                    placeholder="Select Severity"
                />

                <Dropdown
                    v-model="form.assignee_id"
                    :data="$page.props.assignees"
                    :error="form.errors.assignee_id"
                    label="Assignee"
                    placeholder="Select Assignee"
                />

                <div class="space-y-4 col-span-2">
                    <ImageUpload @image="
                        (e) => {
                            form.image = e;
                        }
                    "/>
                </div>

                <div class="col-span-2 flex justify-end">
                    <PrimaryButton>
                        Save
                    </PrimaryButton>
                </div>

            </form>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
