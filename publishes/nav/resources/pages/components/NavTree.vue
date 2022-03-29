<template>
    <List :list="tree" :group="{ name: 'navigations-list' }">
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
            <NavTree :list="children" />
        </template>
    </List>
</template>

<script lang="ts" setup>
import { NavItem } from '@{{ app }}/types';
import { defineProps, PropType } from 'vue';
import { TList } from '@macramejs/macrame-vue3';
import { List } from '@macramejs/admin-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import NavTree from './NavTree.vue';

const props = defineProps({
    tree: {
        type: Object as PropType<TList<NavItem>>,
        required: true,
    },
});
</script>
