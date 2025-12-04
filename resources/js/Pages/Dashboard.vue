<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import StatCard from '@/Components/UI/StatCard.vue';
import { ChartNoAxesColumn, ClockCheck, Ticket, TicketCheck, TicketMinus, TicketPercent, TicketPlus, TicketX, Users } from 'lucide-vue-next';
import MyChart from '@/Components/Charts/MyChart.vue';
import MyChart2 from '@/Components/Charts/MyChart2.vue';
import Dropdown from '@/Components/Forms/Dropdowns/Tickets/Dropdown.vue';

const data = [
  { label: 'Dashboard', value: 'dashboard' },
  { label:'Users', value: 'users' },
  { label: 'Tickets', value: 'tickets' },
];
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
                    title="Total Tickets"
                    value="0"
                    :is-positive="true"
                    :icon="Ticket"
                />
                <StatCard
                    title="Overall Performace"
                    value="0"
                    :is-positive="true"
                    :icon="TicketPercent"
                />
                <StatCard
                    title="Average Resolution Time"
                    value="0"
                    :is-positive="false"
                    :icon="ClockCheck"
                />
                <StatCard
                    title="Average SLA"
                    value="0"
                    :is-positive="true"
                    :icon="ChartNoAxesColumn"
                />
            </div>
        </div>

        <div class="pt-5">
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

        <div class="pt-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-6 shadow-lg rounded-lg border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white pb-3 dark:border-gray-700">
                            Most Common Issues
                        </h2>
                        <select class="w-50 ml-auto px-3 py-2 bg-neutral-secondary-medium border border-gray-200 text-heading text-sm rounded-lg focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                            <option value="">Select Option</option>
                            <option value="">Option 1</option>
                            <option value="">Option 2</option>
                            <option value="">Option 3</option>
                        </select>
                    </div>
                    <MyChart />
                </div>
                <div class="bg-white p-6 shadow-lg rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white pb-3 dark:border-gray-700">
                                Top Performer
                            </h2>
                            <select class="w-50 ml-auto px-3 py-2 bg-neutral-secondary-medium border border-gray-200 text-heading text-sm rounded-lg focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                                <option value="">Select Option</option>
                                <option value="">Option 1</option>
                                <option value="">Option 2</option>
                                <option value="">Option 3</option>
                            </select>
                        </div>
                        <MyChart2 />
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
