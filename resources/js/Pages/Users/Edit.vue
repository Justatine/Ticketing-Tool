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
import RoleDropdown from '@/Components/Forms/Dropdowns/RoleDropdown.vue';
import DepartmentDropdown from '@/Components/Forms/Dropdowns/DepartmentDropdown.vue';
import TeamDropdown from '@/Components/Forms/Dropdowns/TeamDropdown.vue';
import RegionDropdown from '@/Components/Forms/Dropdowns/RegionDropdown.vue';

const params = route().params;
const page = usePage();
const { success, error } = useToast()

const props = defineProps({
    user: Object,
    departments:Array,
    teams: Array,
    regions: Array,
    roles: Array
});

const form = useForm({
    name: props.user.name ?? '',
    email: props.user?.email ?? '',
    password: null,
    role: props.user?.role ?? '',
    department: props.user?.department ?? '',
    team: props.user?.team ?? '',
    region: props.user?.region ?? '',
    _method: 'PUT'
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

    <div class="">
      <div class="max-w-full w-full">
        <div class="bg-white border border-gray-200 dark:bg-slate-800 shadow-sm sm:rounded-lg p-6">

            <div class="flex justify-between mb-6">
                <div class="">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit User</h1>
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

                <!-- roles -->
                <RoleDropdown
                    v-model="form.role"
                    :roles="$page.props.roles"
                    :error="form.errors.role"
                />

                <!-- department -->
                <DepartmentDropdown
                    v-model="form.department"
                    :departments="$page.props.departments"
                    :error="form.errors.department"
                />

                <!-- teams -->
                <TeamDropdown
                    v-model="form.team"
                    :teams="$page.props.teams"
                    :error="form.errors.team"
                />

                <!-- region -->
                <RegionDropdown
                    v-model="form.region"
                    :regions="$page.props.regions"
                    :error="form.errors.region"
                />

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
