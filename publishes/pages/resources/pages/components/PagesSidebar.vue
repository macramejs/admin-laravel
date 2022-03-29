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
import { {{ model }}TreeItem, {{ model }} } from '@{{ app }}/types';
import { saveQueue } from '@admin/modules/save-queue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    pages: {
        type: Object as PropType<{{ model }}TreeItem[]>,
        required: true,
    },
});

type {{ model }}Tree = Tree<{{ model }}>;

const tree: {{ model }}Tree = useTree<{{ model }}>(props.pages);

tree.updateOnChange(props.pages);

const queueKey = `pages.order`;
let originalOrder = useOriginal(tree.getOrder());

watch(
    tree,
    () => {
        const order = tree.getOrder();

        if (originalOrder.matches(order)) {
            saveQueue.remove(queueKey);
        } else {
            saveQueue.add(queueKey, async () => {
                originalOrder.update(order);
                Inertia.post('/{{ app }}/{{ route }}/order', { order });
            });
        }
    },
    { immediate: true, deep: true }
);
</script>
