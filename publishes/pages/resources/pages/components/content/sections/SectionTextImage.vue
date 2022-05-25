<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerTextImage preview />
        </template>
        <Card>
            <div class="grid grid-cols-2 gap-5">
                <div class="col-span-1">
                    <FormFieldLabel> Text </FormFieldLabel>
                    <Textarea v-model="model.text" label="foo" />
                </div>

                <div class="col-span-1">
                    <FormFieldLabel> Bild </FormFieldLabel>
                    <div v-if="selectedImage" class="relative">
                        <Image :id="selectedImage.id" />
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
                </div>
            </div>
        </Card>
    </BaseSection>
</template>
<script setup lang="ts">
import {
    Textarea,
    Section as BaseSection,
    IconTrash,
    FormFieldLabel,
    Card,
} from "@macramejs/admin-vue3";
import {
    defineProps,
    watch,
    defineEmits,
    reactive,
    ref,
    onBeforeMount,
} from "vue";

import { getMediaById } from "@admin/modules/media";
import { Media } from "@admin/types";
import SelectImageModal from "./SelectImageModal.vue";
import DrawerTextImage from "./../drawers/DrawerTextImage.vue";
import Image from "./Image.vue";
const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            text: "",
            image: null,
        }),
    },
});

const model = reactive(props.modelValue);

watch(
    () => model,
    () => emit("update:modelValue", model),
    { deep: true }
);

const busy = ref<boolean>(true);
const selectedImage = ref<Media | null>(null);

onBeforeMount(async () => {
    selectedImage.value = props.modelValue.image
        ? await getMediaById(props.modelValue.image)
        : null;

    busy.value = false;
});

const deleteImage = () => {
    selectedImage.value = null;
    model.image = null;
};

watch(
    () => selectedImage,
    () => (model.image = selectedImage.value?.id),
    { deep: true }
);
</script>
