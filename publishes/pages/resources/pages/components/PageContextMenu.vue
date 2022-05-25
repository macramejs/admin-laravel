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
                        <IconPlus class="w-4 h-4" />
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
        <ContextMenuItem
            class="hover:bg-red-signal text-red-signal"
            @click="deletePage(page)"
        >
            <template #icon>
                <IconTrash class="origin-left scale-75" />
            </template>
            <span>Löschen</span>
        </ContextMenuItem>
    </ContextMenu>
</template>

<script lang="ts" setup>
import {
    ContextMenu,
    ContextMenuItem,
    IconTrash,
    IconMoreHorizontal,
    IconPlus,
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
