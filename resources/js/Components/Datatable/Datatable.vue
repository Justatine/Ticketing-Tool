<script setup>
import { ref, computed } from 'vue';
import DatatableHeader from './DatatableHeader.vue';
import DatatableRow from './DatatableRow.vue';
import PaginationLinks from '../PaginationLinks.vue';
import DatatableSearch from './DatatableSearch.vue';
import UserDatatableRow from './UserDatatableRow.vue';

const props = defineProps({
  columns: { type: Array, required: true },
  rows: { type: Object, required: true }
});

const searchQuery = ref('');
const activeFilters = ref({});
const sortData = ref({ column: null, order: null });

const filteredRows = computed(() => {
  let data = props.rows.data;

  // search
  if (searchQuery.value) {
    data = data.filter((row) =>
      Object.values(row).some((val) =>
        String(val).toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    );
  }

  // filters
  if (activeFilters.value.role) {
    data = data.filter(row => row.role === activeFilters.value.role);
  }

  return data;
});

const sortedRows = computed(() => {
  if (!sortData.value.column) return filteredRows.value;

  return [...filteredRows.value].sort((a, b) => {
    let col = sortData.value.column;
    let order = sortData.value.order;

    if (a[col] < b[col]) return order === 'asc' ? -1 : 1;
    if (a[col] > b[col]) return order === 'asc' ? 1 : -1;
    return 0;
  });
});

function handleSort(column, order) {
  sortData.value = { column, order };
}
</script>

<template>
    <DatatableSearch
        v-model="searchQuery"
        v-model:filters="activeFilters"
    />

    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full bg-white border-collapse">
        <thead>
            <tr>
            <DatatableHeader
                v-for="col in columns"
                :key="col.data"
                :header="col.header"
                :data="col.data"
                :sortable="col.sortable"
                :sortData="sortData"
                @toggle-sort="handleSort"
            />
            </tr>
        </thead>
        <tbody>
            <UserDatatableRow
                v-for="(row, index) in sortedRows"
                :key="row.id ?? index"
                :row="row"
                :columns="columns"
            />
        </tbody>
        </table>

        <PaginationLinks :paginator="rows" />
    </div>
</template>
