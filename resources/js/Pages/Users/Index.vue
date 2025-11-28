<script setup>
import Datatable from '@/Components/Datatable/Datatable.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    'users' : Object
});

console.log(props.users.data)

// dummy data
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
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
        Users
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-lg p-6">

            <div class="flex justify-between pb-4">
                <p class="">Users page</p>
                <Link
                    :href="route('users.create')"
                    class=""
                >
                    <PrimaryButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Create new user
                    </PrimaryButton>
                </Link>
            </div>

            <Datatable
                :columns="columns"
                :rows="rows"
            />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
