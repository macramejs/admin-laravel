<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerInfoBox preview />
        </template>
        <div class="pb-5">
            <FormFieldLabel> Überschrift </FormFieldLabel>
            <Input v-model="model.title" class="w-full" label="Titel" />
        </div>

        <FormFieldLabel> Text </FormFieldLabel>
        <Textarea v-model="model.text" class="w-full" label="Text" />
    </BaseSection>
</template>
<script setup lang="ts">
import {
    Card,
    Textarea,
    Input,
    Section as BaseSection,
    FormFieldLabel,
} from '@macramejs/admin-vue3';
import DrawerInfoBox from './../drawers/DrawerInfoBox.vue';
import { defineProps, watch, defineEmits, reactive } from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            title: '',
            text: '',
        }),
    },
});

const model = reactive(props.modelValue);

watch(
    () => model,
    () => emit('update:modelValue', model),
    { deep: true }
);
</script>
