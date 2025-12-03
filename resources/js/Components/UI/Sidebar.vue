<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
  Home,
  Users,
  Ticket,
  X
} from 'lucide-vue-next';

const props = defineProps({
  open: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(['close']);

const sidebarItems = [
  { id: 'dashboard', label: 'Dashboard', icon: Home, href: '/dashboard' },
  { id: 'users', label: 'Users', icon: Users, href: '/users' },
  { id: 'tickets', label: 'Tickets', icon: Ticket, href: '/tickets' },
];

const page = usePage();

// Get current route to determine active menu
const currentRoute = computed(() => page.url);

const isActive = (href) => {
  return currentRoute.value === href || currentRoute.value.startsWith(href + '/');
};

const closeSidebar = () => {
  emit('close');
};
</script>

<template>
  <div>
    <!-- Overlay -->
    <div
      v-if="open"
      @click="closeSidebar"
      class="fixed inset-0 bg-black/50 lg:hidden z-30"
    />

    <!-- Sidebar -->
    <div
      :class="[
        'bg-[url(/assets/images/cartoon-bg.png)] bg-cover bg-center fixed lg:static inset-y-0 left-0 z-40 w-64 h-full bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transition-transform duration-300 lg:translate-x-0',
        open ? 'translate-x-0' : '-translate-x-full'
      ]"
    >
      <!-- Header -->
      <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-800">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg flex items-center justify-center">
            <!-- <span class="text-white font-bold text-sm">A</span> -->
            <img src="assets/images/company-logo.png" alt="Company Logo">
          </div>
          <span class="text-lg font-bold text-gray-900 dark:text-white">Ticketing Tool</span>
        </div>
        <button
          @click="closeSidebar"
          class="lg:hidden p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition-colors"
        >
          <X class="w-4 h-4" />
        </button>
      </div>

      <!-- Menu Items -->
      <nav class="px-3 py-6 space-y-2 overflow-y-auto">
        <Link
          v-for="item in sidebarItems"
          :key="item.id"
          :href="item.href"
          :class="[
            'flex items-center gap-3 px-3 py-2 rounded-lg transition-colors group cursor-pointer',
            isActive(item.href)
              ? 'bg-red-900 text-white'
              : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
          ]"
          @click="closeSidebar"
        >
          <component
            :is="item.icon"
            :class="[
              'w-5 h-5 flex-shrink-0',
              isActive(item.href) ? 'text-white' : 'group-hover:text-red-900'
            ]"
          />
          <span class="text-sm font-medium">{{ item.label }}</span>
        </Link>
      </nav>
    </div>
  </div>
</template>
