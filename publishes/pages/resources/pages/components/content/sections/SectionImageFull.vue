<template>
    <BaseSection>
        <img :src="selectedImage?.url" v-if="selectedImage" />
        <SelectImageModal v-model="selectedImage" v-if="!busy" />
    </BaseSection>
</template>
<script setup lang="ts">
import { getMediaById } from "@admin/modules/media";
import { Media } from "@admin/types";
import { Card, Button, Section as BaseSection } from "@macramejs/admin-vue3";
import { defineProps, watch, defineEmits, ref, onBeforeMount } from "vue";
import SelectImageModal from "./SelectImageModal.vue";

const emit = defineEmits(["update:modelValue"]);

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

watch(
    () => selectedImage,
    () => {
        emit("update:modelValue", { image: selectedImage.value?.id });
    },
    { deep: true }
);
</script>
