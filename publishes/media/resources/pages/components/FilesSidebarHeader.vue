<template>
    <Header>
        <div class="flex items-center">
            <IconBookStack />
            <span class="inline-block text-xl"> Collections </span>
        </div>
        <Button
            secondary
            outline
            sm
            square
            @click="emit('update:showForm', !showForm)"
            class="ml-auto !border-white"
        >
            <IconPlus class="w-4 h-4 text-white"></IconPlus>
        </Button>
    </Header>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import {
    IconMediaImageFolder,
    Header,
    Button,
    IconPlus,
    IconBookStack,
} from '@macramejs/admin-vue3';

const emit = defineEmits(['update:showForm']);

defineProps({
    showForm: {
        type: Boolean,
        required: true,
    },
});
</script>
