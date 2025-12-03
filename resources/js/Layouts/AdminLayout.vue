<script setup>
import { ref } from 'vue';
import Sidebar from '@/Components/UI/Sidebar.vue';
import Topbar from '@/Components/UI/Topbar.vue';

const sidebarOpen = ref(false);

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};

const closeSidebar = () => {
  sidebarOpen.value = false;
};
</script>

<template>
  <div class="flex h-screen bg-gray-50 dark:bg-gray-950">
    <Sidebar :open="sidebarOpen" @close="closeSidebar" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <Topbar @toggle-sidebar="toggleSidebar" />

      <div class="flex-1 overflow-auto">
        <div class="p-6">
            <main>
                <slot/>
            </main>
        </div>
      </div>
    </div>
  </div>
</template>
