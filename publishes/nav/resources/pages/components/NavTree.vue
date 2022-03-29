<template>
    <BaseTree :tree="tree" :group="{ name: 'nav-tree' }">
        <template v-slot:default="{ item }">
            <Link
                class="flex-1 py-1 cursor-pointer"
                :href="`/admin/pages/${item.id}`"
            >
                {{ item.title }}
            </Link>

            <!-- <Dropdown /> -->
        </template>
        <template v-slot:disclosure="{ children }">
            <NavTree :tree="children" />
        </template>
    </BaseTree>
</template>

<script lang="ts" setup>
import { NavItem } from '@{{ app }}/types';
import { defineProps, PropType } from 'vue';
import { Tree } from '@macramejs/macrame-vue3';
import { Tree as BaseTree } from '@macramejs/admin-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import NavTree from './NavTree.vue';

const props = defineProps({
    tree: {
        type: Object as PropType<Tree<NavItem>>,
        required: true,
    },
});
</script>
