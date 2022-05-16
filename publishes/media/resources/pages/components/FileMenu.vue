<template>
    <ContextMenu>
        <ContextMenuItem
            class="hover:bg-red-signal text-red-signal"
            @click="deleteFile(props.file)"
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
import { Media } from "@admin/types/resources";
import { deleteFile } from "@admin/modules/media";
import { PropType } from "vue";
import {
    ContextMenu,
    ContextMenuItem,
    ContextMenuDivider,
} from "@macramejs/admin-vue3";

const props = defineProps({
    file: {
        type: Object as PropType<Media>,
        required: true,
    },
});
</script>
