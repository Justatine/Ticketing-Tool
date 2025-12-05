<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <textarea
        id="message"
        rows="4"
        class="rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring-red-900"
        ref="input"
        v-model="model"
    >
    </textarea>

</template>
