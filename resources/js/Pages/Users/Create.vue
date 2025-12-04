<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { useToast } from '@/Composables/Toast';
import { UserPlus } from 'lucide-vue-next';
import Dropdown from '@/Components/Forms/Dropdowns/Tickets/Dropdown.vue';

const { success, error } = useToast()

const props = defineProps({
    departments: Array,
    teams: Array,
    regions: Array,
    roles: Array
});

const form = useForm({
    name: null,
    email: null,
    password: null,
    role: null,
    department: null,
    team: null,
    region: null,
});

const submit = () => {
  form.post(route('users.store'), {
    onSuccess: () => {
      success('User Created', 'The user has been successfully created.')
      form.reset('password')
    },
    onError: (errors) => {
      error('Create Failed', 'Please fix the errors and try again.')
    }
  })
}

</script>

<template>
  <Head title="Create User" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
            Create New User
          </h2>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Add a new team member to your organization
          </p>
        </div>
        <Link :href="route('users.index')">
          <PrimaryButton>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
            </svg>
            Back to Users
          </PrimaryButton>
        </Link>
      </div>
    </template>

    <div class="">
      <div class="">
        <form @submit.prevent="submit">

          <div class="space-y-6">

            <!-- Account Information Section -->
            <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
              <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-900">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                  </svg>
                  Account Information
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                  Basic account credentials and contact information
                </p>
              </div>

              <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <InputLabel for="name" value="Full Name" class="font-semibold" />
                    <TextInput
                      id="name"
                      type="text"
                      class="mt-2 block w-full"
                      v-model="form.name"
                      placeholder="Enter full name"
                      required
                      autofocus
                      autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                  </div>

                  <div>
                    <InputLabel for="email" value="Email Address" class="font-semibold" />
                    <TextInput
                      id="email"
                      type="email"
                      class="mt-2 block w-full"
                      v-model="form.email"
                      placeholder="user@example.com"
                      required
                      autocomplete="email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                  </div>

                  <div class="md:col-span-2">
                    <InputLabel for="password" value="Password" class="font-semibold" />
                    <TextInput
                      id="password"
                      type="password"
                      class="mt-2 block w-full"
                      v-model="form.password"
                      placeholder="Enter secure password"
                      required
                      autocomplete="new-password"
                    />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                      Password must be at least 8 characters long
                    </p>
                    <InputError class="mt-2" :message="form.errors.password" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Role & Permissions Section -->
            <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg border border-gray-200 dark:border-gray-700 overflow-visible z-1">
              <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-slate-800 dark:to-slate-900">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-purple-600 dark:text-purple-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                  </svg>
                  Role & Permissions
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                  Define user's role and access level
                </p>
              </div>

              <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <Dropdown
                    v-model="form.role"
                    :data="$page.props.roles"
                    :error="form.errors.role"
                    label="Role"
                    placeholder="Select Role"
                  />
                </div>
              </div>
            </div>

            <!-- Organization Details Section -->
            <div class="overflow-visible z-1 bg-white dark:bg-slate-800 shadow-md rounded-lg border border-gray-200 dark:border-gray-700">
              <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-slate-800 dark:to-slate-900">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 dark:text-green-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                  </svg>
                  Organization Details
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                  Department, team and location assignment
                </p>
              </div>

              <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <Dropdown
                    v-model="form.department"
                    :data="$page.props.departments"
                    :error="form.errors.department"
                    label="Department"
                    placeholder="Select Department"
                    :z-index="40"
                  />

                  <Dropdown
                    v-model="form.team"
                    :data="$page.props.teams"
                    :error="form.errors.team"
                    label="Team"
                    placeholder="Select Team"
                    :z-index="20"
                  />

                  <Dropdown
                    v-model="form.region"
                    :data="$page.props.regions"
                    :error="form.errors.region"
                    label="Region"
                    placeholder="Select Region"
                    :z-index="20"
                  />
                </div>
              </div>
            </div>

          </div>

          <!-- Submit Button -->
          <div class="mt-8 flex items-center justify-end gap-4">
            <Link :href="route('users.index')">
              <button
                type="button"
                class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 font-medium transition-colors"
              >
                Cancel
              </button>
            </Link>
            <PrimaryButton
              :disabled="form.processing"
              class="px-8 py-3 shadow-lg hover:shadow-xl transition-all"
            >
              <UserPlus class="w-5 h-5 mr-2" />
              {{ form.processing ? 'Creating...' : 'Create User' }}
            </PrimaryButton>
          </div>

        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
