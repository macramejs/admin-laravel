<template>
    <ContextMenu placement="bottom" customButton>
        <template #button>
            <slot name="button">
                <Button secondary :disabled="selection.files.length == 0">
                    Edit Selection
                </Button>
            </slot>
        </template>

        <AddToCollectionModal
            :selection="selection"
            :collections="collections"
        />

        <ContextMenuDivider />

        <ContextMenuItem
            class="text-red-signal hover:bg-red-signal"
            @click="selection.delete"
        >
            <template #icon>
                <IconMoreHorizontal class="origin-left scale-75" />
            </template>
            <span>Delete</span>
        </ContextMenuItem>
    </ContextMenu>
</template>
<script lang="ts" setup>
import {
    Button,
    ContextMenu,
    ContextMenuItem,
    ContextMenuDivider,
    IconMoreHorizontal,
} from '@macramejs/admin-vue3';
import { PropType } from 'vue';
import { Selection } from '../modules';
import AddToCollectionModal from './AddToCollectionModal.vue';
import { MediaCollection } from '@admin/types/resources';

const props = defineProps({
    selection: {
        type: Object as PropType<Selection>,
        required: true,
    },
    collections: {
        type: Array as PropType<MediaCollection[]>,
        required: true,
    },
});
</script>
