<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Bell, Search, ChevronDown } from 'lucide-vue-next';

const notifications = [
  { id: 1, title: 'New User Signup', message: 'A new user has signed up', time: '5 minutes ago' },
  { id: 2, title: 'Order Placed', message: 'New order #1234 has been placed', time: '15 minutes ago' },
  { id: 3, title: 'System Update', message: 'System maintenance completed', time: '1 hour ago' },
];

const emit = defineEmits(['toggle-sidebar']);

const notifOpen = ref(false);
const userOpen = ref(false);

const page = usePage();
const user = page.props.auth?.user;

const toggleNotifications = () => {
  notifOpen.value = !notifOpen.value;
  if (notifOpen.value) userOpen.value = false;
};

const toggleUserMenu = () => {
  userOpen.value = !userOpen.value;
  if (userOpen.value) notifOpen.value = false;
};

// Close dropdowns when clicking outside
const handleClickOutside = (event) => {
  const target = event.target;
  if (!target.closest('.notification-dropdown') && !target.closest('.notification-button')) {
    notifOpen.value = false;
  }
  if (!target.closest('.user-dropdown') && !target.closest('.user-button')) {
    userOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
  <div class="h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-6 w-full">

    <!-- MOBILE SIDEBAR TOGGLE BUTTON -->
    <button
      @click="emit('toggle-sidebar')"
      class="lg:hidden p-2 mr-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300"
           fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    <!-- Right: Icons & User -->
    <div class="flex items-center gap-4 ml-auto">
      <!-- Mobile Search -->
      <button class="md:hidden p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
        <Search class="w-5 h-5" />
      </button>

      <!-- Notifications -->
      <div class="relative">
        <button
          @click="toggleNotifications"
          class="notification-button relative p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
        >
          <Bell class="w-5 h-5" />
          <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full" />
        </button>

        <div
          v-if="notifOpen"
          class="notification-dropdown absolute right-0 mt-2 w-80 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50"
        >
          <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">Notifications</h3>
          </div>
          <div class="max-h-96 overflow-y-auto">
            <div
              v-for="notif in notifications"
              :key="notif.id"
              class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors border-b border-gray-200 dark:border-gray-700 last:border-0"
            >
              <p class="text-sm font-medium text-gray-900 dark:text-white">{{ notif.title }}</p>
              <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ notif.message }}</p>
              <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ notif.time }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- User Dropdown -->
      <div class="relative">
        <button
          @click="toggleUserMenu"
          class="user-button flex items-center gap-2 px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
        >
          <img
            :src="user?.avatar || '/assets/images/default.svg'"
            :alt="user?.name || 'User'"
            class="w-8 h-8 rounded-full object-cover"
          />
          <span class="hidden sm:inline text-sm font-medium text-gray-900 dark:text-white">
            {{ user?.name || 'John Doe' }}
          </span>
          <ChevronDown class="w-4 h-4 text-gray-500 dark:text-gray-400" />
        </button>

        <div
          v-if="userOpen"
          class="user-dropdown absolute right-0 mt-2 w-48 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50"
        >
          <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <p class="text-sm font-semibold text-gray-900 dark:text-white">
              {{ user?.name || 'John Doe' }}
            </p>
            <p class="text-xs text-gray-600 dark:text-gray-400">
              {{ user?.email || 'admin@example.com' }}
            </p>
          </div>
          <nav class="py-2">
            <Link
              href="/profile"
              class="block px-4 py-2 text-sm text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            >
              Profile
            </Link>
            <Link
              href="/settings"
              class="block px-4 py-2 text-sm text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            >
              Settings
            </Link>
            <Link
              href="/help"
              class="block px-4 py-2 text-sm text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            >
              Help
            </Link>
            <hr class="my-2 border-gray-200 dark:border-gray-700" />
            <Link
              href="/logout"
              method="post"
              as="button"
              class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            >
              Logout
            </Link>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>
