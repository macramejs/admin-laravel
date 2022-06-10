<template>
    <TreeItem
        :item="page"
        :children="children"
        :is-active="isActive"
        background
    >
        <Link
            class="flex-1 py-1 cursor-pointer"
            :href="`/admin/pages/${page.id}`"
        >
            <span
                :class="{
                    'opacity-50': !page.is_live,
                }"
            >
                {{ page.name }}
            </span>
        </Link>
        <div
            class="w-2 h-2 mr-2 rounded-full"
            :class="{
                ' bg-green': page.has_been_published, // live
                ' bg-orange': page.is_live && !page.has_been_published, // scheduled
                ' bg-red': !page.is_live && !page.publish_at, // not live && not scheduled
            }"
            :title="page.is_live ? 'online' : 'offline'"
        ></div>
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
