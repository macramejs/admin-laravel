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
                <svg
                    width="24"
                    height="24"
                    class="origin-left scale-75"
                    stroke-width="1.5"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M19 11v9.4a.6.6 0 0 1-.6.6H5.6a.6.6 0 0 1-.6-.6V11M10 17v-6M14 17v-6M21 7h-5M3 7h5m0 0V3.6a.6.6 0 0 1 .6-.6h6.8a.6.6 0 0 1 .6.6V7M8 7h8"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
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
