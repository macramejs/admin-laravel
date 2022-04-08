<template>
    <BaseTree :tree="tree" :group="{ name: 'page-list' }">
        <template v-slot:default="{ item, children }">
            <PagesTreeItem :item="item" :children="children">
                <template v-slot:disclosure>
                    <PagesTree :tree="children" />
                </template>
            </PagesTreeItem>
        </template>
    </BaseTree>
</template>

<script setup lang="ts">
import { {{ model }} } from '@{{ app }}/types';
import { defineProps, PropType } from 'vue';
import { Tree } from '@macramejs/macrame-vue3';
import { Tree as BaseTree } from '@macramejs/admin-vue3';
import PagesTree from './PagesTree.vue';
import PagesTreeItem from './PagesTreeItem.vue';

defineProps({
    tree: {
        type: Object as PropType<Tree<{{ model }}>>,
        required: true,
    },
});
</script>