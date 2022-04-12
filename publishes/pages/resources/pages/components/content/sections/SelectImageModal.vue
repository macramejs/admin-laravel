<template>
    <Button @click="isOpen = true">Select Image</Button>
    <Modal v-model:open="isOpen" @close="isOpen = false">
        <div
            v-for="(image, key) in mediaIndex.items"
            :key="key"
            class="w-8 h-8 bg-red"
            @click="emit('update:modelValue', image)"
        >
            {{ image }}
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import { Card, Button } from '@macramejs/admin-vue3';
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
</script>
