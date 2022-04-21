<template>
    <Card class="flex">
        <Textarea v-model="model.text" class="w-1/2" label="foo" />

        <div class="w-1/2">
            <img :src="selectedImage?.url" v-if="selectedImage" />
            <SelectImageModal v-model="selectedImage" v-if="!busy" />
        </div>
    </Card>
</template>
<script setup lang="ts">
import { Card, Textarea } from '@macramejs/admin-vue3';
import {
    defineProps,
    watch,
    defineEmits,
    reactive,
    ref,
    onBeforeMount,
} from 'vue';

import { getMediaById } from '@admin/modules/media';
import { Media } from '@admin/types';
import SelectImageModal from './SelectImageModal.vue';
const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            text: '',
        }),
    },
});

const model = reactive(props.modelValue);

watch(
    () => model,
    () => emit('update:modelValue', model),
    { deep: true }
);

const busy = ref<boolean>(true);
const selectedImage = ref<Media | null>(null);

onBeforeMount(async () => {
    console.log({ model: props.modelValue });

    selectedImage.value = props.modelValue.image
        ? await getMediaById(props.modelValue.image)
        : null;

    busy.value = false;
});

watch(
    () => selectedImage,
    () => {
        emit('update:modelValue', { image: selectedImage.value?.id });
    },
    { deep: true }
);
</script>
