<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TicketCard from '@/Components/TicketCard.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Clock, Funnel, Plus, TicketSlash } from 'lucide-vue-next';
import StatCard from '@/Components/UI/StatCard.vue';
import { TicketCheck, TicketMinus, TicketPlus, TicketX } from 'lucide-vue-next';

const props = defineProps({
    tickets: Object,
    searchTerm: String,
    ticket_card_data: Object
});

const form = useForm({
    search: props.searchTerm,
});

const search = () =>{
    router.get(route("tickets.index"),
    {
        search: form.search,
        assignee_id: params.assignee_id
    });
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

    <div class="">
        <div class="space-y-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Ticket Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-3">
                <StatCard
                    title="Open/New "
                    :value="props.ticket_card_data.total_open_new"
                    :is-positive="true"
                    :icon="TicketPlus"
                />
                <StatCard
                    title="In Progress"
                    :value="props.ticket_card_data.total_inprog"
                    :is-positive="true"
                    :icon="TicketMinus"
                />
                <StatCard
                    title="Closed"
                    :value="props.ticket_card_data.total_closed"
                    :is-positive="false"
                    :icon="TicketCheck"
                />
                <StatCard
                    title="Pending"
                    :value="props.ticket_card_data.total_pending"
                    :is-positive="true"
                    :icon="Clock"
                />
                <StatCard
                    title="Failed"
                    :value="props.ticket_card_data.total_failed_unresolved"
                    :is-positive="true"
                    :icon="TicketX"
                />
                <StatCard
                    title="Voided"
                    :value="props.ticket_card_data.total_voided"
                    :is-positive="true"
                    :icon="TicketX"
                />
            </div>
        </div>

      <div class="max-w-full w-full pt-4">
        <div class="bg-white border border-gray-200 dark:bg-slate-800 shadow-sm sm:rounded-lg p-6">

            <!-- Search -->
            <div class="flex items-center justify-between mb-4">
            <!-- Search Bar -->
            <div class="flex-1">
                <form @submit.prevent="search">
                <TextInput
                    class="w-full"
                    type="search"
                    label=""
                    icon="magnifying-glass"
                    placeholder="Search title, description or ID..."
                    v-model="form.search"
                />
                </form>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2 ml-4">
                <PrimaryButton class="flex items-center gap-1">
                    <Funnel class="w-4 h-4"/>
                    Filter
                </PrimaryButton>

                <Link :href="route('tickets.create')">
                    <PrimaryButton class="flex items-center gap-1">
                        <Plus class="w-4 h-4"/>
                        New Ticket
                    </PrimaryButton>
                </Link>
            </div>
            </div>


            <div v-if="tickets.data.length" class="space-y-8">
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <TicketCard
                        v-for="ticket in tickets.data"
                        :key="ticket.id"
                        :ticket="ticket"
                    />
                </div>

                <PaginationLinks :paginator="tickets" />
            </div>

            <div v-else class="text-gray-500 dark:text-gray-400 text-center py-10">
                No tickets found.
            </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
