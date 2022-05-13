<template>
    <ContextMenu>
        <AddPageModal :parent="page">
            <template #button="{ open }">
                <ContextMenuItem @click="open">
                    <template #icon>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="-4.5 -4.5 24 24"
                            class="w-4 h-4 fill-white"
                            stroke-width="1.5"
                        >
                            <path
                                d="M8.9 6.9v-5a1 1 0 1 0-2 0v5h-5a1 1 0 1 0 0 2h5v5a1 1 0 1 0 2 0v-5h5a1 1 0 1 0 0-2h-5z"
                            ></path>
                        </svg>
                    </template>
                    Unterseite
                </ContextMenuItem>
            </template>
        </AddPageModal>
        <ContextMenuDivider />
        <ContextMenuItem
            class="hover:bg-red-signal text-red-signal"
            @click="deletePage(page)"
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
    ContextMenu,
    ContextMenuItem,
    ContextMenuDivider,
} from '@macramejs/admin-vue3';
import { PropType } from 'vue';
import { Page } from '@admin/types/resources';
import { deletePage } from '@admin/modules/page';
import AddPageModal from './AddPageModal.vue';

const props = defineProps({
    page: {
        type: Object as PropType<Page>,
        required: true,
    },
});
</script>
