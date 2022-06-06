<template>
    <BaseTree :tree="tree" :group="{ name: 'nav-tree' }">
        <template v-slot:default="{ item, children }">
            <NavTreeItem
                :nav-item="item"
                :children="children"
                :type="type"
                :link-options="linkOptions"
            />
        </template>
    </BaseTree>
</template>

<script lang="ts" setup>
import { NavItem, LinkOption } from '@admin/types/resources';
import { PropType } from 'vue';
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
    linkOptions: {
        required: true,
        type: Array as PropType<LinkOption[]>,
    },
});
</script>
