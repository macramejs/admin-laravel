<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerImageFull preview />
        </template>
        <FormFieldLabel> Bild </FormFieldLabel>
        <SelectImage v-model="model.image" />
    </BaseSection>
</template>
<script setup lang="ts">
import { FormFieldLabel, Section as BaseSection } from '@macramejs/admin-vue3';
import { watch, ref } from 'vue';
import DrawerImageFull from './../drawers/DrawerImageFull.vue';
import SelectImage from './components/SelectImage.vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            image: {
                id: null,
                title: '',
                alt: '',
            },
        }),
    },
});

const model = ref(props.modelValue);

watch(
    () => model,
    () => {
        emit('update:modelValue', model);
    },
    { deep: true }
);
</script>
