<template>
    <ContentBody>
        <div class="space-y-2">
            <div v-for="audit in audits" class="px-4 py-2 bg-white rounded">
                <div class="flex justify-between">
                    <div class="col-span-9">
                        <div class="text-xs text-gray">
                            {{ audit.created_at }}
                        </div>
                        <div>{{ audit.event }}</div>
                    </div>
                    <div
                        class="flex items-center justify-end col-span-3 space-x-4 text-sm text-gray"
                    >
                        <div>
                            {{ audit.user.name }}
                        </div>
                        <div>
                            <ContextMenu placement="left">
                                <template #button>
                                    <InteractionButton
                                        class="cursor-pointer"
                                        gray
                                    >
                                        <IconMoreHorizontal class="w-4 h-4" />
                                    </InteractionButton>
                                </template>
                                <ContextMenuItem
                                    class="hover:bg-red-signal"
                                    @click="rollback(audit)"
                                >
                                    <template #icon>
                                        <svg
                                            class="w-4 h-4"
                                            width="24"
                                            height="24"
                                            stroke-width="1.5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M4 6V12C4 12 4 15 11 15C18 15 18 12 18 12V6"
                                                stroke="currentColor"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                            <path
                                                d="M11 3C18 3 18 6 18 6C18 6 18 9 11 9C4 9 4 6 4 6C4 6 4 3 11 3Z"
                                                stroke="currentColor"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                            <path
                                                d="M11 21C4 21 4 18 4 18V12"
                                                stroke="currentColor"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                            <path
                                                d="M19 22V16M19 16L22 19M19 16L16 19"
                                                stroke="currentColor"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </template>
                                    <span>Version wiederherstellen</span>
                                </ContextMenuItem>
                            </ContextMenu>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 my-2 text-xs">
                    <pre class="p-3 bg-gray-900 rounded text-green">{{
                        audit.old_values
                    }}</pre>
                    <pre class="p-3 bg-gray-900 rounded text-green">{{
                        audit.new_values
                    }}</pre>
                </div>
            </div>
        </div>
    </ContentBody>
</template>

<script lang="ts" setup>
import { PropType } from 'vue';
import { PageResource, PageAudit } from '@admin/types/resources';
import {
    ContentBody,
    ContextMenu,
    ContextMenuItem,
    IconMoreHorizontal,
    InteractionButton,
} from '@macramejs/admin-vue3';
import { Inertia, Method } from '@inertiajs/inertia';

const props = defineProps({
    page: {
        type: Object as PropType<PageResource>,
        required: true,
    },
    audits: {
        type: Array as PropType<PageAudit[]>,
        required: true,
    },
});

const rollback = async (audit: PageAudit) => {
    await Inertia.visit(
        `/admin/pages/${props.page.data.id}/rollback/${audit.id}`,
        {
            method: Method.POST,
            onSuccess: () => {
                Inertia.visit(`/admin/pages/${props.page.data.id}`);
            },
        }
    );
};
</script>
