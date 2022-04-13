<template>
    <TreeItem :item="page" :children="children" :is-active="isActive">
        <Link
            class="flex-1 py-1 cursor-pointer"
            :href="`/{{ app }}/{{ route }}/${page.id}`"
        >
            {{ page.name }}
        </Link>

        <ContextButton />

        <template v-slot:disclosure>
            <PagesTree :tree="children" />
        </template>
    </TreeItem>
</template>

<script lang="ts" setup>
import { Tree } from '@macramejs/macrame-vue3';
import { {{ model }} } from '@{{ app }}/types';
import { TreeItem, ContextButton } from '@macramejs/admin-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import PagesTree from './PagesTree.vue';
import { computed, PropType } from 'vue';

const props = defineProps({
    page: {
        type: Object as PropType<{{ model }}>,
        required: true,
    },
    children: {
        type: Object as PropType<Tree<{{ model }}>>,
        required: true,
    },
});

const isActive = computed(
    () => `/{{ app }}/{{ route }}/${props.page.id}` == window.location.pathname
);
</script>
