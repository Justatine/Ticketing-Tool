<script setup>
import { ref } from 'vue';

const emit = defineEmits(['image']);
const props = defineProps({ ticketImage:String});
const currentImage = props.ticketImage ? `/storage/${props.ticketImage}` : null
const preview = ref(currentImage);
const oversizedImage = ref(false);
const showRevertBtn = ref(true);

const imageSelected = (e) => {
    preview.value = URL.createObjectURL(e.target.files[0]);
    oversizedImage.value = e.target.files[0].size  > 2145728;
    showRevertBtn.value = true;
    emit('image', e.target.files[0]);
}

const revertImageChange = () => {
    showRevertBtn.value = false;
    preview.value = currentImage;
    oversizedImage.value = false;
    emit('image', null);
}
</script>
<template>
    <div>
        <span
            :class="{ '!border-red-500' : oversizedImage }"
        >
            {{ oversizedImage ? 'The selected image exceeds 2Mb' : 'Image (Max size 2MB)' }}
        </span>
        <label
            for="image"
            class="block relative rounded-md mt-1 bg-slate-300 h-[140px] overflow-hidden cursor-pointer border-slate-300 border"
        >
            <img
                :src="preview ?? '/storage/images/tickets/default.png'"
                class="object-cover object-center h-full w-full"
                alt=""
            >
            <button
                v-if="showRevertBtn"
                @click.prevent="revertImageChange"
                type="button"
                class="absolute top-2 right-2 bg-white/75 w-8 h-8 rounded-full grid place-items-center text-slate-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 15-6 6m0 0-6-6m6 6V9a6 6 0 0 1 12 0v3" />
                </svg>
            </button>
        </label>

        <input
            @image="console.log('ok');"
            @input="imageSelected"
            id="image"
            type="file"
            name="image"
            hidden
        />
    </div>
</template>
