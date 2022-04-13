<template>
    <Card>
        <Sections
            v-model="model.cards"
            :group="id"
            :sections="{ text_full: SectionTextFull }"
            class="w-full"
        />

        <Cabinet class="w-full col-span-1 space-y-2" :group="id">
            <DrawerTextFull :draws="SectionTextFull" />
        </Cabinet>
    </Card>
</template>
<script setup lang="ts">
import { Card, Sections } from '@macramejs/admin-vue3';
import { defineProps, watch, defineEmits, reactive } from 'vue';
import { SectionTextFull } from './index';
import { DrawerTextFull } from './../drawers';
import { v4 as uuid } from 'uuid';
import { Cabinet } from '@macramejs/page-builder-vue3';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            cards: [],
        }),
    },
});

const model = reactive(props.modelValue);

const id = uuid();

emit('update:modelValue', model);

watch(
    () => model,
    () => emit('update:modelValue', model),
    { deep: true }
);
</script>
