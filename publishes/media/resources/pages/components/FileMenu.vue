<template>
    <ContextMenu>
        <ContextMenuItem
            class="hover:bg-red-signal text-red-signal"
            @click="deleteFile(props.file)"
        >
            <template #icon>
                <IconTrash class="origin-left scale-75" />
            </template>
            <span>Delete</span>
        </ContextMenuItem>
    </ContextMenu>
</template>

<script lang="ts" setup>
import { Media } from '@admin/types/resources';
import { deleteFile } from '@admin/modules/media';
import { PropType } from 'vue';
import {
    ContextMenu,
    ContextMenuItem,
    ContextMenuDivider,
    IconTrash,
} from '@macramejs/admin-vue3';

const props = defineProps({
    file: {
        type: Object as PropType<Media>,
        required: true,
    },
});
</script>
