<template>
    <SidebarSecondary>
        <template v-slot:header>
            <PagesSidebarHeader />
        </template>
        <template v-slot:default>
            <PagesSidebarBody :tree="tree" />
        </template>
    </SidebarSecondary>
</template>

<script lang="ts" setup>
import { watch, PropType } from 'vue';
import { SidebarSecondary } from '@macramejs/admin-vue3';
import {
    useTree,
    Tree,
    RawTreeItem,
    RawTree,
    useOriginal,
} from '@macramejs/macrame-vue3';
import PagesSidebarHeader from './PagesSidebarHeader.vue';
import PagesSidebarBody from './PagesSidebarBody.vue';
import { PageTreeItem, Page } from '@admin/types';
import { post } from '@admin/modules/request';

const props = defineProps({
    pages: {
        type: Object as PropType<PageTreeItem[]>,
        required: true,
    },
});

type PageTree = Tree<Page>;

const tree: PageTree = useTree<Page>(props.pages);

tree.updateOnChange(() => props.pages);

let originalOrder = useOriginal(tree.getOrder());

watch(
    tree,
    () => {
        const order = tree.getOrder();

        if (!originalOrder.matches(order)) {
            originalOrder.update(order);
            post('/admin/pages/order', { body: { order: order } });
        }
    },
    { immediate: true, deep: true }
);
</script>
