<template>
    <PagesList :list="list" />
</template>

<script lang="ts" setup>
import { PropType } from 'vue';
import PagesList from './PagesList.vue';
import { useList, TList } from '@macramejs/macrame-vue3';
import { {{ model }} } from '@{{ app }}/types';

const props = defineProps({
    list: {
        type: Object as PropType<TList<{{ model }}>>,
        required: true,
    },
});
</script>
