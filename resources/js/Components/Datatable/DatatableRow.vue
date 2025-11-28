<script setup>
const props = defineProps({
  row: { type: Object, required: true },
  columns: { type: Array, required: true }
});
</script>

<template>
  <tr class="border-b hover:bg-gray-50 transition">
    <td
      v-for="col in columns"
      :key="col.data"
      class="px-4 py-2 text-sm text-gray-700"
    >
      <!-- Check if it's the Action column -->
      <!-- <template v-if="col.header === 'Action'">
        <button
          @click="handleAction(row[col.data])"
          class="px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600"
        >
          Action {{ row[col.data] }}
        </button>
      </template> -->

      <!-- Render avatar for Name -->
      <template v-if="col.data === 'name'">
        <div class="flex items-center space-x-2">
          <img
            :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(row[col.data])}&color=A32130&background=F5C3C9`"
            alt="avatar"
            class="w-6 h-6 rounded-full"
          />
          <span>{{ row[col.data] }}</span>
        </div>
      </template>

      <!-- Default -->
      <template v-else>
        {{ row[col.data] }}
      </template>
    </td>
  </tr>
</template>

<!-- <script setup>
const props = defineProps({
  row: { type: Object, required: true },
  columns: { type: Array, required: true }
});
</script>

<template>
  <tr class="border-b hover:bg-gray-50 transition">
    <td v-for="col in columns" :key="col.data" class="px-4 py-2 text-sm text-gray-700">
      {{ row[col.data] }}
    </td>
  </tr>
</template> -->

