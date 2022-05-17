<template>
    <BaseSection>
        Tabs

        <div v-for="(item, key) in model.items" :key="key">
            <Input v-model="item.title" />
            <Textarea v-model="item.text" />
            <Button sm square @click="removeItem(key)">-</Button>
        </div>

        <Button sm square @click="addItem">+</Button>
    </BaseSection>
</template>
<script setup lang="ts">
import {
    Card,
    Sections,
    Button,
    Input,
    Textarea,
    Section as BaseSection,
} from "@macramejs/admin-vue3";
import { defineProps, watch, defineEmits, reactive } from "vue";
import { v4 as uuid } from "uuid";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            items: [],
        }),
    },
});

const model = reactive(props.modelValue);

const id = uuid();

function addItem() {
    model.items.push({
        title: "",
        text: "",
    });
}

function removeItem(index) {
    model.items.splice(index, 1);
}

emit("update:modelValue", model);

watch(
    () => model,
    () => emit("update:modelValue", model),
    { deep: true }
);
</script>
