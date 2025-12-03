<script setup>
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import TicketBadge from './Tickets/TicketBadge.vue';
import TicketTime from './Tickets/TicketTime.vue';

defineProps({
  ticket: Object
});

const selectUser = (id) => {
    router.get(route("tickets.index"), {
        assignee_id: id
    })
}
</script>

<template>
  <div class="bg-white border border-gray-200 dark:bg-slate-800 rounded-xl shadow-sm p-4 flex flex-col gap-2 hover:shadow-md transition duration-200">

    <div class="flex justify-between items-start">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
        # {{ ticket.id }}
      </h3>
      <TicketBadge :status="ticket.severity" type="severity" />
    </div>

    <p class="text-sm text-gray-600 dark:text-gray-400">
      {{ ticket.title }}
    </p>

    <p class="text-xs text-gray-500 dark:text-gray-400">
      {{ ticket.description }}
      <!-- Created by
      <span class="underline text-blue-500 cursor-pointer" @click="selectUser(ticket.reporter?.id)">
        {{ ticket.reporter?.name ?? 'Unassigned' }}
      </span>
      to be addressed by
      <span class="font-medium">
        {{ ticket.assignee?.name ?? 'Unassigned' }}
      </span> -->
    </p>

    <div class="text-xs text-gray-400 flex justify-between items-center">
      <TicketTime
        :date="ticket.date_reported"
        :hours="4"
        :show-seconds="true"
        :status="ticket.status"
        :dateClosed="ticket.date_closed"
      />
      <span>{{ new Date(ticket.created_at).toLocaleDateString() }}</span>
    </div>

    <div class="flex justify-between pt-2">
        <p class="text-xs text-gray-500 dark:text-gray-400">
            Requested by: {{ ticket.reporter?.name }}
        </p>
        <Link
            :href="route('tickets.show', ticket.id)"
            class="text-indigo-600 text-sm font-medium hover:underline"
        >
            View Details
        </Link>
    </div>
  </div>
</template>
