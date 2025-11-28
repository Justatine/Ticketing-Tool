<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TicketCard from '@/Components/TicketCard.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import Dropdown from '@/Components/Tickets/Dropdown.vue';
import DropdownLink from '@/Components/Tickets/DropdownItem.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DropdownItem from '@/Components/Tickets/DropdownItem.vue';
import ImageUpload from '@/Components/Tickets/ImageUpload.vue';
import InputError from '@/Components/InputError.vue';

const params = route().params;
const page = usePage();

const props = defineProps({
  assignees: Object
});

console.log(props.assignees)

const form = useForm({
    title:null,
    description:null,
    status:"Open",
    assignee_id:null,
    priority:null,
    image:null,
    reporter_id: page.props.auth.user.id
});
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
                @submit.prevent="form.post(route('tickets.store'))"
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

                <div class="space-y-4">
                    <InputLabel for="description" value="Assign to" />

                   <Dropdown
                        align="right"
                        width="48"
                    >
                        <template #trigger>
                            <span class="inline-flex w-full rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex w-full items-center justify-between rounded-md border border-gray-200 bg-white px-3 py-3 text-md font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                >
                                    <!-- {{ $page.props.auth.user.name }} -->
                                {{ form.assignee_id ? assignees.find(u => u.id === form.assignee_id)?.name : 'Select Assignee' }}
                                    <svg
                                        class="ms-2 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownItem
                                v-for="user in props.assignees"
                                :key="user.id"
                                :value="user.id"
                                @select="form.assignee_id = $event"
                            >
                                {{ user.name }}
                            </DropdownItem>
                        </template>
                    </Dropdown>
                    <InputError class="mt-2" :message="form.errors.assignee_id" />
                </div>

                <div class="space-y-4">
                    <InputLabel for="description" value="Priority level" />
                    <Dropdown
                        align="right"
                        width="48"
                    >
                        <template #trigger>
                            <span class="inline-flex w-full rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex w-full items-center justify-between rounded-md border border-gray-200 bg-white px-3 py-3 text-md font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                >
                                    <!-- {{ $page.props.auth.user.name }} -->
                                    {{ form.priority ?? "Priority" }}
                                    <svg
                                        class="ms-2 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownItem value="Low" @select="form.priority = $event">Low</DropdownItem>
                            <DropdownItem value="Normal" @select="form.priority = $event">Normal</DropdownItem>
                            <DropdownItem value="High" @select="form.priority = $event">High</DropdownItem>
                        </template>
                    </Dropdown>
                    <InputError class="mt-2" :message="form.errors.priority" />
                </div>

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
