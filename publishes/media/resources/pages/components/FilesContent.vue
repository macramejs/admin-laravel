<template>
    <Content>
        <ContentBody>
            <FilesTabs :collection="collection" :collections="collections" />
        </ContentBody>
        <ContentSidebar v-model:open="isSidebarOpen">
            <FilesFilters />
        </ContentSidebar>
    </Content>
</template>

<script lang="ts" setup>
import { PropType, ref } from 'vue';
import { MediaCollection } from '@admin/types';
import { Content, ContentBody, ContentSidebar } from '@macramejs/admin-vue3';
import FilesTabs from './FilesTabs.vue';
import FilesFilters from './FilesFilters.vue';

const props = defineProps({
    collections: {
        type: Array as PropType<MediaCollection[]>,
        required: true,
    },
    collection: {
        type: Object as PropType<MediaCollection>,
        required: false,
    },
});

const isSidebarOpen = ref(true);
</script>
