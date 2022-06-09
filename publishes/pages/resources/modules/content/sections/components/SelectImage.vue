<template>
    <div class="relative">
        <div
            v-if="selectedImage"
            class="relative overflow-hidden rounded-sm mg-gray-100 min-h-[50px]"
        >
            <div class="absolute w-full h-full transform scale-110">
                <img
                    :src="selectedImage?.url.replaceAll(' ', '%20') + '?w=20'"
                    class="object-cover w-full h-full"
                />
            </div>
            <div
                class="absolute top-0 left-0 w-full h-full bg-white bg-opacity-50 backdrop-filter backdrop-blur-md"
            ></div>

            <div class="flex justify-center w-full image-preview">
                <ResponsiveImage
                    :src="selectedImage?.url.replaceAll(' ', '%20')"
                />
            </div>
        </div>
        <SelectImageModal v-model="selectedImage" v-else />
        <div class="absolute top-1 right-1" v-if="selectedImage">
            <ContextMenu placement="left">
                <template #button>
                    <InteractionButton class="mt-2 mr-2 cursor-pointer" dark>
                        <IconMoreHorizontal class="w-4 h-4" />
                    </InteractionButton>
                </template>
                <ContextMenuItem
                    class="hover:bg-red-signal text-red-signal"
                    @click="deleteImage()"
                >
                    <template #icon>
                        <IconTrash class="origin-left scale-75" />
                    </template>
                    <span>Löschen</span>
                </ContextMenuItem>
            </ContextMenu>
        </div>
    </div>
</template>

<script lang="ts" setup>
import 'lazysizes';
import { ResponsiveImage } from '@admin/components';
import { getMediaById } from '@admin/modules/media';
import { onBeforeMount, PropType, ref, watch } from 'vue';
import SelectImageModal from './SelectImageModal.vue';
import {
    InteractionButton,
    IconTrash,
    IconMoreHorizontal,
    ContextMenu,
    ContextMenuItem,
} from '@macramejs/admin-vue3';

const emit = defineEmits(['update:modelValue']);

interface ParseableImage {
    id: number;
    title: string;
    alt: string;
}

const props = defineProps({
    modelValue: {
        type: Object as PropType<ParseableImage>,
    },
});

const model = ref(props.modelValue);
const selectedImage = ref(null);

onBeforeMount(async () => {
    selectedImage.value = props.modelValue?.id
        ? await getMediaById(props.modelValue.id)
        : null;
});

watch(
    () => selectedImage.value,
    val => {
        emit('update:modelValue', {
            ...model.value,
            id: val?.id,
        });
    }
);

const deleteImage = () => {
    selectedImage.value = null;
};
</script>

<style>
.image-preview {
    background: rgba(0, 0, 0, 0.025);
}
.image-preview img {
    max-height: 25vh;
    width: auto;
    object-fit: contain;
    object-fit: contain !important;
}
</style>
