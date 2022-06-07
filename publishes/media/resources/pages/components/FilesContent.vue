<template>
    <Content>
        <ContentBody topPosition="80">
            <FilesGrid :collection="collection" :collections="collections" />
        </ContentBody>
        <ContentSidebar v-model:open="isSidebarOpen" topPosition="80">
            <FilesFilters />
        </ContentSidebar>
    </Content>
</template>

<script lang="ts" setup>
import { PropType, ref } from 'vue';
import { MediaCollection } from '@admin/types';
import { Content, ContentBody, ContentSidebar } from '@macramejs/admin-vue3';
import FilesGrid from './FilesGrid.vue';
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
