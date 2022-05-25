<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerTextFull preview />
        </template>
        <Card>
            <Wysiwyg v-model="model.text" class="w-full" />
        </Card>
    </BaseSection>
</template>
<script setup lang="ts">
import { Wysiwyg, Section as BaseSection, Card } from "@macramejs/admin-vue3";

import DrawerTextFull from "./../drawers/DrawerTextFull.vue";
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
