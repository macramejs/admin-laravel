<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerGallery preview />
        </template>
        <Card>
            <Draggable
                :list="model.images"
                v-if="model.images && !busy"
                tag="div"
                class="grid grid-cols-12 gap-5 mb-5"
                @dragend="reload()"
            >
                <template #item="{ element, index }">
                    <div class="relative col-span-3">
                        <Image :id="element" />
                        <button
                            class="absolute flex items-center justify-center w-5 h-5 text-white bg-black hover:bg-red rounded-xs right-1 top-1"
                            @click="deleteImage(element.id)"
                        >
                            <IconTrash class="w-3 h-3" />
                        </button>
                    </div>
                </template>
            </Draggable>
            <SelectImageModal v-model="selectedImage" />
        </Card>
    </BaseSection>
</template>
<script setup lang="ts">
import Draggable from "vuedraggable";
import {
    Card,
    Button,
    Section as BaseSection,
    IconTrash,
} from "@macramejs/admin-vue3";
import { defineProps, watch, defineEmits, ref, nextTick } from "vue";
import SelectImageModal from "./SelectImageModal.vue";
import DrawerGallery from "./../drawers/DrawerGallery.vue";
import Image from "./Image.vue";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            images: [],
        }),
    },
});

const model = ref(props.modelValue);
const selectedImage = ref(null);

watch(
    () => selectedImage.value,
    (val) => {
        if (val?.id) {
            model.value.images.push(val.id);
        }
    },
    { deep: true }
);

watch(
    () => model,
    () => {
        emit("update:modelValue", model);
    },
    { deep: true }
);

const busy = ref(false);

const deleteImage = (index) => {
    busy.value = true;
    model.value.images.splice(index, 1);
    nextTick(() => {
        busy.value = false;
    });
};
const reload = () => {
    busy.value = true;
    nextTick(() => {
        busy.value = false;
    });
};
</script>
