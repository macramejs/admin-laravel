<template>
    <BaseTree :tree="tree" :group="{ name: 'page-list' }">
        <template v-slot:default="{ item }">
            <Link
                class="flex-1 py-1 cursor-pointer"
                :href="`/admin/pages/${item.id}`"
            >
                {{ item.name }}
            </Link>

            <!-- <Dropdown /> -->
        </template>
        <template v-slot:disclosure="{ children }">
            <PagesTree :tree="children" />
        </template>
    </BaseTree>
</template>

<script setup lang="ts">
import { {{ model }} } from '@{{ app }}/types';
import { defineProps, PropType } from 'vue';
import { Tree } from '@macramejs/macrame-vue3';
import { Tree as BaseTree } from '@macramejs/admin-vue3';
import { Link } from '@inertiajs/inertia-vue3';
// import Dropdown from './Dropdown.vue';
import PagesTree from './PagesTree.vue';

const props = defineProps({
    tree: {
        type: Object as PropType<Tree<{{ model }}>>,
        required: true,
    },
});
</script>
