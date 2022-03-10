<template>
    <SidebarSecondary>
        <template v-slot:header>
            <FilesSidebarHeader />
        </template>
        <template v-slot:default>
            <FilesSidebarBody
                :collections="collections"
                :collection="collection"
            />
        </template>
    </SidebarSecondary>
</template>

<script lang="ts" setup>
import { PropType } from 'vue';
import { SidebarSecondary } from '@macramejs/admin-vue3';
import FilesSidebarHeader from './FilesSidebarHeader.vue';
import FilesSidebarBody from './FilesSidebarBody.vue';
import { FileCollection } from '@admin/modules/resources';

const props = defineProps({
    collections: {
        type: Array as PropType<FileCollection[]>,
        required: true,
    },
    collection: {
        type: Object as PropType<FileCollection>,
        required: false,
    },
});
</script>
