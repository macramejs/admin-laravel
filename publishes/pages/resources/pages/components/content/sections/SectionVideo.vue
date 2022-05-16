<template>
    <Card>
        Video
        <Textarea v-model="model.text" class="w-full" label="Video" />
    </Card>
</template>
<script setup lang="ts">
import { Card, Textarea } from '@macramejs/admin-vue3';
import { defineProps, watch, defineEmits, reactive } from 'vue';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
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
