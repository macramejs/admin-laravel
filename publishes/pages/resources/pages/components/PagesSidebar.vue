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
import { saveQueue } from '@admin/modules/save-queue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    pages: {
        type: Object as PropType<PageTreeItem[]>,
        required: true,
    },
});

type PageTree = Tree<Page>;

const tree: PageTree = useTree<Page>(props.pages);

tree.updateOnChange(props.pages);

const queueKey = `pages.order`;
let originalOrder = useOriginal(tree.getOrder());

watch(
    tree,
    () => {
        const order = tree.getOrder();
        if (!originalOrder.matches(order)) {
            Inertia.post('/admin/pages/order', { order });
        }
    },
    { immediate: true, deep: true }
);
</script>
