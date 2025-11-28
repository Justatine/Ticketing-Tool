<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TicketCard from '@/Components/TicketCard.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 shadow-sm sm:rounded-lg p-6">

            <!-- Search -->
            <div class="flex items-center justify-between mb-4">

                <div>
                    Filters
                </div>
                <div class="flex justify-end gap-2">
                    <div>
                        <form @submit.prevent="search">
                            <TextInput
                                type="search"
                                label=""
                                icon="magnifying-glass"
                                placeholder="Search..."
                                v-model="form.search"
                            />
                        </form>
                    </div>
                    <div class="">
                        <Link
                            :href="route('tickets.create')"
                            class=""
                        >
                            <PrimaryButton>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                New Ticket
                            </PrimaryButton>
                        </Link>
                    </div>
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
