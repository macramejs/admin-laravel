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
                    <SelectImage v-model="model.image" />
                </div>
            </div>
        </Card>
    </BaseSection>
</template>
<script setup lang="ts">
import {
    Textarea,
    Section as BaseSection,
    FormFieldLabel,
    Card,
} from '@macramejs/admin-vue3';
import { watch, reactive } from 'vue';

import DrawerTextImage from './../drawers/DrawerTextImage.vue';
import SelectImage from './components/SelectImage.vue';
const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            text: '',
            image: {
                id: null,
                title: '',
                alt: '',
            },
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
