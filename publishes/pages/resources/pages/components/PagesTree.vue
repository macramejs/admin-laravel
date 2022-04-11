<template>
    <BaseTree :tree="tree" :group="{ name: '{{ name }}-list' }">
        <template v-slot:default="{ item, children }">
            <TreeItem :item="item" :children="children">
                <Link
                    class="flex-1 py-1 cursor-pointer"
                    :href="`/{{ app }}/{{ route }}/${item.id}`"
                >
                    {{ item.name }}
                </Link>

                <template v-slot:disclosure>
                    <PagesTree :tree="children" />
                </template>
            </TreeItem>
            <!-- <Dropdown /> -->
        </template>
    </BaseTree>
</template>

<script setup lang="ts">
import { {{ model }} } from '@{{ app }}/types';
import { defineProps, PropType } from 'vue';
import { Tree } from '@macramejs/macrame-vue3';
import { Tree as BaseTree, TreeItem } from '@macramejs/admin-vue3';
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
