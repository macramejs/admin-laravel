<template>
    <BaseTree :tree="tree" :group="{ name: 'nav-tree' }">
        <template v-slot:default="{ item, children }">
            <NavTreeItem
                :nav-item="item"
                :children="children"
                :type="type"
                :route-items="routeItems"
            />
        </template>
    </BaseTree>
</template>

<script lang="ts" setup>
import { NavItem, RouteItem } from '@{{ app }}/types/resources';
import { defineProps, PropType } from 'vue';
import { Tree } from '@macramejs/macrame-vue3';
import { Tree as BaseTree } from '@macramejs/admin-vue3';
import NavTreeItem from './NavTreeItem.vue';

const props = defineProps({
    tree: {
        type: Object as PropType<Tree<NavItem>>,
        required: true,
    },
    type: {
        type: String,
        required: true,
    },
    routeItems: {
        type: Object as PropType<RouteItem[]>,
    },
});
</script>
