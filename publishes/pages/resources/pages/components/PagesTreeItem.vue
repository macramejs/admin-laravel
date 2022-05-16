<template>
    <TreeItem :item="page" :children="children" :is-active="isActive">
        <Link
            class="flex-1 py-1 cursor-pointer"
            :href="`/admin/pages/${page.id}`"
        >
            {{ page.name }}
        </Link>

        <PageContextMenu :page="page" />

        <template v-slot:disclosure>
            <PagesTree :tree="children" />
        </template>
    </TreeItem>
</template>

<script lang="ts" setup>
import { Tree } from '@macramejs/macrame-vue3';
import { Page } from '@admin/types';
import { TreeItem } from '@macramejs/admin-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import PagesTree from './PagesTree.vue';
import PageContextMenu from './PageContextMenu.vue';
import { computed, PropType } from 'vue';

const props = defineProps({
    page: {
        type: Object as PropType<Page>,
        required: true,
    },
    children: {
        type: Object as PropType<Tree<Page>>,
        required: true,
    },
});

const isActive = computed(
    () => `/admin/pages/${props.page.id}` == window.location.pathname
);
</script>
