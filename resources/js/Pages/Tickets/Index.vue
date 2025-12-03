<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TicketCard from '@/Components/TicketCard.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Funnel, Plus } from 'lucide-vue-next';

const props = defineProps({
  tickets: Object,
  searchTerm: String
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
      <div class="max-w-full w-full">
        <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-lg p-6">

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
