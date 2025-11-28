<script setup>
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3';

const params = route().params;
defineProps({
  ticket: Object
});

const selectUser = (id) => {
    router.get(route("tickets.index"), {
        assignee_id : id,
        search: params.search
    })
}
</script>

<template>
    <div
        class="bg-white dark:bg-slate-800 rounded-2xl shadow-md overflow-hidden transition transform hover:scale-[1.02] hover:shadow-xl duration-300 flex flex-col h-full"
    >
    <!-- Image or Header Block -->
    <Link
        :href="route('tickets.show', ticket.id)"
    >
      <img
        :src="`/storage/${ticket.image}`"
        alt="Ticket image"
        class="w-full h-48 object-cover object-center bg-slate-300"
      />
    </Link>

    <!-- Card Content -->
    <div class="p-5 flex-1 flex flex-col justify-between">
      <div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
          {{ ticket.title }}
        </h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
          {{ ticket.description }} - {{ ticket.status }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Created at {{ new Date(ticket.created_at).toLocaleDateString() }}
          by

          <span class="underline text-blue-500" @click="selectUser(ticket.assignee.id)">
            {{ ticket.assignee?.name ?? 'Unassigned' }}
          </span>
        </p>
      </div>

      <!-- Optional Action Button -->
      <div class="mt-4">
        <Link
          :href="route('tickets.show', ticket.id)"
          class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition"
        >
          View Details
        </Link>
      </div>
    </div>
  </div>
</template>
