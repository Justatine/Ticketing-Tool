<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-12 min-h-screen">

        <div class="col-span-1 lg:col-span-4 flex items-center justify-center bg-white dark:bg-gray-800 px-6 py-12">
            <div class="w-full max-w-md">
                <div class="bg-white dark:bg-gray-900 px-8 py-10 rounded-lg">
                    <!-- Header -->
                    <div class="flex flex-col items-center justify-center mb-8">
                        <div class="mb-4">
                            <Link href="/">
                                <ApplicationLogo class="h-16 fill-current text-gray-500" />
                            </Link>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                            Ticketing Tool
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            Sign in to your account
                        </p>
                    </div>

                    <!-- Form Content -->
                    <slot />
                </div>
            </div>
        </div>

        <div class="hidden lg:block lg:col-span-8 bg-gray-100 dark:bg-gray-900">
            <img
                src="/assets/images/default.svg"
                alt="Illustration"
                class="w-full h-screen object-cover"
            />
        </div>
    </div>
</template>
