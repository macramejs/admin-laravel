<template>
    <PagesTree :tree="tree" />
</template>

<script lang="ts" setup>
import { PropType } from 'vue';
import PagesTree from './PagesTree.vue';
import { Tree } from '@macramejs/macrame-vue3';
import { Page } from '@admin/types';

const props = defineProps({
    tree: {
        type: Object as PropType<Tree<Page>>,
        required: true,
    },
});
</script>
