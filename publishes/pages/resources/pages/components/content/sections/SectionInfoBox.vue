<template>
    <BaseSection>
        <Input v-model="model.title" class="w-full" label="Titel" />
        <Textarea v-model="model.text" class="w-full" label="Text" />
    </BaseSection>
</template>
<script setup lang="ts">
import {
    Card,
    Textarea,
    Input,
    Section as BaseSection,
} from "@macramejs/admin-vue3";
import { defineProps, watch, defineEmits, reactive } from "vue";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            title: "",
            text: "",
        }),
    },
});

const model = reactive(props.modelValue);

watch(
    () => model,
    () => emit("update:modelValue", model),
    { deep: true }
);
</script>
