<template>
    <SelectionMenu :selection="selection" :collections="collections" />
</template>

<script lang="ts" setup>
import SelectionMenu from './SelectionMenu.vue';
import { selection } from '../modules';
import { PropType } from 'vue';
import { MediaCollection } from '@admin/types/resources';

const props = defineProps({
    collections: {
        type: Array as PropType<MediaCollection[]>,
        required: true,
    },
});
</script>
