<template>
    <TreeItem :item="navItem" :children="children" outline>
        <span class="flex-1 py-1 cursor-pointer">
            {{ navItem.title }}
        </span>

        <ContextMenu>
            <template #button>
                <ContextButton />
            </template>
            <EditItemModal
                :nav-item="navItem"
                :link-options="linkOptions"
                :type="type"
            >
                <template #button="{ open }">
                    <ContextMenuItem @click="open"> Edit </ContextMenuItem>
                </template>
            </EditItemModal>

            <ContextMenuItem
                class="hover:bg-red-signal text-red-signal"
                @click="deleteNavItem(type, navItem)"
            >
                <template #icon>
                    <IconTrash class="origin-left scale-75" />
                </template>
                <span>Delete</span>
            </ContextMenuItem>
        </ContextMenu>

        <template v-slot:disclosure>
            <NavTree
                :tree="children"
                :type="type"
                :link-options="linkOptions"
            />
        </template>
    </TreeItem>
</template>

<script lang="ts" setup>
import { Tree } from '@macramejs/macrame-vue3';
import { NavItem, LinkOption } from '@admin/types/resources';
import {
    TreeItem,
    ContextMenu,
    ContextMenuItem,
    ContextButton,
    IconTrash,
} from '@macramejs/admin-vue3';
import NavTree from './NavTree.vue';
import { PropType } from 'vue';
import EditItemModal from './EditItemModal.vue';
import { deleteNavItem } from '@admin/modules/nav';

const props = defineProps({
    navItem: {
        type: Object as PropType<NavItem>,
        required: true,
    },
    children: {
        type: Object as PropType<Tree<NavItem>>,
        required: true,
    },
    type: {
        type: String,
        required: true,
    },
    linkOptions: {
        required: true,
        type: Array as PropType<LinkOption[]>,
    },
});
</script>
