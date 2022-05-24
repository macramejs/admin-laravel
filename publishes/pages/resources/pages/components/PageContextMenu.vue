<template>
    <ContextMenu>
        <template v-slot:button>
            <button
                class="p-1 text-gray-100 opacity-0 hover:bg-black rounded-xs group-hover:opacity-100"
            >
                <IconMoreHorizontal class="w-4 h-4" />
            </button>
        </template>
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
        <DuplicatePageModal :page="page">
            <template #button="{ open }">
                <ContextMenuItem @click="open">
                    <template #icon>
                        <IconDuplicatePage class="w-4 h-4" />
                    </template>
                    Duplizieren
                </ContextMenuItem>
            </template>
        </DuplicatePageModal>
        <ContextMenuDivider />
        <ContextMenuItem
            class="hover:bg-red-signal text-red-signal"
            @click="deletePage(page)"
        >
            <template #icon>
                <IconTrash class="origin-left scale-75" />
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
    IconTrash,
    IconMoreHorizontal,
    IconDuplicatePage,
} from '@macramejs/admin-vue3';
import { PropType } from 'vue';
import { Page } from '@admin/types/resources';
import { deletePage } from '@admin/modules/page';
import AddPageModal from './AddPageModal.vue';
import DuplicatePageModal from './DuplicatePageModal.vue';

const props = defineProps({
    page: {
        type: Object as PropType<Page>,
        required: true,
    },
});
</script>
