<template>
    <div class="p-12">
        <h1 class="flex justify-between mb-4">
            <span>Items</span>
            <AddItemModal :type="type" :link-options="linkOptions" />
        </h1>
        <NavTree :tree="tree" :type="type" :link-options="linkOptions" />
    </div>
</template>

<script lang="ts" setup>
import { PropType, ref, watch } from 'vue';
import { NavItemTreeItem, NavItem, LinkOption } from '@admin/types/resources';
import { useTree, useOriginal } from '@macramejs/macrame-vue3';
import { Button } from '@macramejs/admin-vue3';
import { saveQueue } from '@admin/modules/save-queue';
import NavTree from './NavTree.vue';
import AddItemModal from './AddItemModal.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    items: {
        type: Array as PropType<NavItemTreeItem[]>,
        required: true,
    },
    linkOptions: {
        type: Array as PropType<LinkOption[]>,
    },
});

const tree = useTree<NavItem>(props.items, {
    onOrderChange,
});

tree.updateOnChange(() => props.items);

let originalOrder = useOriginal(tree.getOrder());

const orderQueueKey = `nav.${props.type}.order`;

function onOrderChange(order) {
    if (!originalOrder) return;
    if (originalOrder.matches(order)) {
        saveQueue.remove(orderQueueKey);
    } else {
        saveQueue.add(orderQueueKey, async () => {
            originalOrder.update(order);
            Inertia.post(`/admin/nav/${props.type}/order`, {
                order,
            });
        });
    }
}
</script>
