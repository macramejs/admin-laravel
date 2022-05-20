<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerImageFull preview />
        </template>
        <FormFieldLabel> Bild </FormFieldLabel>
        <div v-if="selectedImage" class="relative">
            <img :src="selectedImage?.url" class="w-full" />
            <button
                class="absolute flex items-center justify-center w-5 h-5 text-white bg-black hover:bg-red rounded-xs right-1 top-1"
                @click="deleteImage()"
            >
                <IconTrash class="w-3 h-3" />
            </button>
        </div>
        <SelectImageModal
            v-model="selectedImage"
            v-if="!busy"
            :hide-button="selectedImage != null"
        />
    </BaseSection>
</template>
<script setup lang="ts">
import { getMediaById } from '@admin/modules/media';
import { Media } from '@admin/types';
import {
    FormFieldLabel,
    Button,
    Section as BaseSection,
    IconTrash,
} from '@macramejs/admin-vue3';
import { defineProps, watch, defineEmits, ref, onBeforeMount } from 'vue';
import SelectImageModal from './SelectImageModal.vue';
import DrawerImageFull from './../drawers/DrawerImageFull.vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            image: null,
        }),
    },
});

const busy = ref<boolean>(true);

const selectedImage = ref<Media | null>(null);

onBeforeMount(async () => {
    console.log({ model: props.modelValue });

    selectedImage.value = props.modelValue.image
        ? await getMediaById(props.modelValue.image)
        : null;

    busy.value = false;
});

const deleteImage = () => {
    selectedImage.value = null;
};

watch(
    () => selectedImage,
    () => {
        emit('update:modelValue', { image: selectedImage.value?.id });
    },
    { deep: true }
);
</script>
