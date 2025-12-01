<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownItem from '@/Components/Tickets/DropdownItem.vue';
import { useToast } from '@/Composables/Toast';
import { computed } from 'vue';

const params = route().params;
const page = usePage();
const { success, error } = useToast()

const props = defineProps({
    user: Object,
    departments: Array,
    teams: Array,
});

const form = useForm({
    name: props.user.name ?? '',
    email: props.user?.email ?? '',
    password: null,
    role: props.user?.role ?? '',
    department: props.user?.department ?? '',
    team: props.user?.team ?? '',
    _method: 'PUT'
});

const teams = props.teams;
const selectedTeamLabel = computed(() => {
    const selected = teams?.find(team => team.value === form.team);
    return selected?.label ?? "Team";
});

const submit = () => {
  form.post(route('users.update', props.user.id), {
    onSuccess: () => {
      success('User Updated', 'The user has been successfully updated.')
      form.reset('password')
    },
    onError: (errors) => {
      error('Create Failed', 'Please fix the errors and try again.')
    }
  })
}

</script>

<template>
  <Head title="Users" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
        Users
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-lg p-6">

            <div class="flex justify-between mb-6">
                <div class="">
                    Edit User
                </div>
                <Link
                    :href="route('users.index')"
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
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        icon="heading"
                        placeholder="Enter name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="space-y-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        icon="heading"
                        placeholder="Enter email"
                        required
                        autofocus
                        autocomplete="email"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>


                <div class="space-y-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        icon="heading"
                        placeholder="Enter to change password"
                        autofocus
                        autocomplete="password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="space-y-4">
                    <InputLabel for="role" value="Role" />
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
                                    {{ form.role ?? "Role" }}
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
                            <DropdownItem value="Admin" @select="form.role = $event">Admin</DropdownItem>
                            <DropdownItem value="User" @select="form.role = $event">User</DropdownItem>
                        </template>
                    </Dropdown>
                    <InputError class="mt-2" :message="form.errors.role" />
                </div>

                <!-- department -->
                <div class="space-y-4">
                    <InputLabel for="role" value="Department    " />
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
                                    {{ form.department ?? "Department" }}
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
                                v-for="department in $page.props.departments"
                                :key="department.value"
                                :value="department.value"
                                @select="form.department = department.value"
                            >
                                {{ department.label }}
                            </DropdownItem>
                        </template>
                    </Dropdown>
                    <InputError class="mt-2" :message="form.errors.department" />
                </div>

                <!-- teams -->
                <div class="space-y-4">
                    <InputLabel for="role" value="Team" />
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
                                    {{ selectedTeamLabel }}
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
                                v-for="team in $page.props.teams"
                                :key="team.value"
                                :value="team.value"
                                @select="form.team = team.value"
                            >
                            {{ team.label }}
                            </DropdownItem>
                        </template>
                    </Dropdown>
                    <InputError class="mt-2" :message="form.errors.team" />
                </div>

                <div class="col-span-2 flex justify-end">
                    <PrimaryButton>
                        Update
                    </PrimaryButton>
                </div>

            </form>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
