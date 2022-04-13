<template>
    <Button @click="isOpen = true">Select Image</Button>
    <Modal v-model:open="isOpen" @close="isOpen = false">
        <div class="grid grid-cols-12 gap-4">

            <div
                v-for="(image, key) in mediaIndex.items"
                :key="key"
                class="col-span-6 sm:col-span-4 md:col-span-4 lg:col-span-2 flex items-center cursor-pointer"
                @click="selectImage(image)"
            >
                <img :src="image.url" />
            </div>
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import { Button } from '@macramejs/admin-vue3';
import { Modal } from '@macramejs/admin-vue3';
import { defineEmits, PropType, ref } from 'vue';
import { mediaIndex } from '@admin/modules/media';
import { Media } from '@admin/types/resources';

const isOpen = ref<boolean>(false);

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        required: true,
        type: Object as PropType<Media>,
    },
});

mediaIndex.loadItems();

const selectImage = (image) => {
    emit('update:modelValue', image)
    isOpen.value = false;
}
</script>
