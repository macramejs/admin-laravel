<template>
    <div class="relative">
        <img :src="selectedImage?.url" class="w-full" v-if="selectedImage" />
        <SelectImageModal v-model="selectedImage" v-else />
        <div class="absolute top-1 right-1" v-if="selectedImage">
            <ContextMenu placement="left">
                <template #button>
                    <InteractionButton class="cursor-pointer" dark>
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
import { getMediaById } from "@admin/modules/media";
import { onBeforeMount, PropType, ref, watch } from "vue";
import SelectImageModal from "./SelectImageModal.vue";
import {
    InteractionButton,
    IconTrash,
    IconMoreHorizontal,
    ContextMenu,
    ContextMenuItem,
} from "@macramejs/admin-vue3";

const emit = defineEmits(["update:modelValue"]);

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
    selectedImage.value = props.modelValue.id
        ? await getMediaById(props.modelValue.id)
        : null;
});

watch(
    () => selectedImage.value,
    (val) => {
        emit("update:modelValue", {
            ...model.value,
            id: val?.id,
        });
    }
);

const deleteImage = () => {
    selectedImage.value = null;
};
</script>
