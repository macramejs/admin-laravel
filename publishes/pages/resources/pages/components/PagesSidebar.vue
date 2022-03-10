<template>
    <SidebarSecondary>
        <template v-slot:header>
            <PagesSidebarHeader />
        </template>
        <template v-slot:default>
            <PagesSidebarBody :list="list" />
        </template>
    </SidebarSecondary>
</template>

<script lang="ts" setup>
import { watch, PropType } from 'vue';
import { SidebarSecondary } from '@macramejs/admin-vue3';
import {
    useList,
    TList,
    RawListItem,
    RawList,
    useOriginal,
} from '@macramejs/macrame-vue3';
import PagesSidebarHeader from './PagesSidebarHeader.vue';
import PagesSidebarBody from './PagesSidebarBody.vue';
import { {{ model }}ListItem, {{ model }} } from '@{{ app }}/types';
import { saveQueue } from '@admin/modules/save-queue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    pages: {
        type: Object as PropType<{{ model }}ListItem[]>,
        required: true,
    },
});

type {{ model }}List = TList<{{ model }}>;

const list: {{ model }}List = useList<{{ model }}>(props.pages);

list.updateOnChange(props.pages);

const queueKey = `pages.order`;
let originalOrder = useOriginal(list.getOrder());

watch(
    list,
    () => {
        const order = list.getOrder();

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
