<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import StatCard from '@/Components/UI/StatCard.vue';
import { TicketCheck, TicketMinus, TicketPlus, TicketX } from 'lucide-vue-next';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="space-y-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Ticket Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <StatCard
                    title="Open/New Tickets"
                    value="0"
                    :is-positive="true"
                    :icon="TicketPlus"
                />
                <StatCard
                    title="In Progress Tickets"
                    value="0"
                    :is-positive="true"
                    :icon="TicketMinus"
                />
                <StatCard
                    title="Closed Tickets"
                    value="0"
                    :is-positive="false"
                    :icon="TicketCheck"
                />
                <StatCard
                    title="Unresolved Tickets"
                    value="0"
                    :is-positive="true"
                    :icon="TicketX"
                />
            </div>
        </div>

        <div class="py-5">
            <div class="max-w-full w-full">
                <div
                    class="overflow-hidden bg-white border border-gray-200 shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
