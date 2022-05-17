<template>
    <BaseSection>
        <Textarea v-model="model.text" class="w-full" label="foo" />
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
            text: "",
        }),
    },
});

const model = reactive(props.modelValue);

watch(
    () => model,
    () => {
        console.log(model);

        emit("update:modelValue", model);
    },
    { deep: true }
);
</script>
