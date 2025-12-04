<script setup>
import Datatable from '@/Components/Datatable/Datatable.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatCard from '@/Components/UI/StatCard.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Users, UserPlus, UserCheck, UserX, Shield } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    'users' : Object,
    'user_details' : Object,
    'user_card_data' : Object
});

// console.log(props.users.data)
// console.log(props.user_card_data)

const columns = [
  { header: 'ID', data: 'id', sortable: true },
  { header: 'Name', data: 'name', sortable: true },
  { header: 'Email', data: 'email', sortable: true },
  { header: 'Role', data: 'role', sortable: true },
  { header: 'Action', data: 'id', sortable: false },
];

const rows = props.users;

</script>

<template>
  <Head title="Users" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
            User Management
          </h2>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Manage your team members and their account permissions
          </p>
        </div>
        <Link :href="route('users.create')">
          <PrimaryButton class="shadow-lg hover:shadow-xl transition-shadow">
            <UserPlus class="w-5 h-5 mr-2" />
            Add New User
          </PrimaryButton>
        </Link>
      </div>
    </template>

    <div class="">
      <div class="max-w-full w-full space-y-6">

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
          <StatCard
            title="Total Users"
            :value="props.user_card_data.total_users"
            change="+12.5%"
            :is-positive="true"
            :icon="Users"
          />
          <StatCard
            title="Administrators"
            :value="props.user_card_data.total_admins"
            change="+2"
            :is-positive="true"
            :icon="Shield"
          />
        </div>

        <!-- Users Table -->
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">

          <!-- Table Header -->
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-slate-800 dark:to-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <Users class="w-6 h-5 text-red-900 dark:text-red-900" />
                    All Users
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    A list of all users in your account including their name, email and role.
                    </p>
                </div>
                <Link
                    :href="route('users.create')"
                    class=""
                >
                    <PrimaryButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        New User
                    </PrimaryButton>
                </Link>
            </div>
          </div>

          <!-- Table Content -->
          <div class="p-6">
            <Datatable
              :columns="columns"
              :rows="rows"
              :user_details="props.user_details"
            />
          </div>
        </div>

      </div>
    </div>
  </AuthenticatedLayout>
</template>
