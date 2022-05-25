<template>
    <div @click="isOpen = true" v-if="!hideButton">
        <slot name="button">
            <div
                class="flex flex-col items-center justify-center w-full rounded cursor-pointer bg-gray-50 hover:bg-gray-200 h-28 text-gray"
            >
                <IconAddImage class="w-12 h-12" />
                Bild hinzufügen
            </div>
        </slot>
    </div>
    <Modal v-model:open="isOpen" @close="isOpen = false">
        <div class="grid grid-cols-12 gap-4">
            <div
                v-for="(image, key) in mediaIndex.items"
                :key="key"
                class="flex items-center col-span-6 cursor-pointer sm:col-span-4 md:col-span-4 lg:col-span-2"
                @click="selectImage(image)"
            >
                <img :src="image.url" />
            </div>
            <MediaUpload />
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import { IconAddImage } from '@macramejs/admin-vue3';
import { Modal } from '@macramejs/admin-vue3';
import { defineEmits, PropType, ref } from 'vue';
import { mediaIndex, MediaUpload } from '@admin/modules/media';
import { Media } from '@admin/types/resources';

const isOpen = ref<boolean>(false);

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object as PropType<Media | null>,
    },
    hideButton: {
        type: Boolean,
        default: false,
    },
});

mediaIndex.loadItems();

const selectImage = image => {
    emit('update:modelValue', image);
    isOpen.value = false;
};
</script>
