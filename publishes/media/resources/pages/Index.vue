<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <FilesSidebar
                :collections="collections.data"
                :collection="collection?.data"
            />
        </template>
        <template v-slot:topbar-left>
            <FilesTopbarLeft />
        </template>
        <template v-slot:topbar-right>
            <FilesTopbarRight :collections="collections.data" />
        </template>
        <slot>
            <FilesContent
                :collections="collections.data"
                :collection="collection?.data"
            />
        </slot>
    </Admin>
</template>

<script lang="ts" setup>
import { onMounted, PropType, watch } from 'vue';
import { Admin } from '@admin/layout';
import { mediaIndex } from '@admin/modules/media';
import {
    MediaCollectionCollectionResource,
    MediaCollectionResource,
} from '@admin/types';
import { Content, ContentSidebar, ContentBody } from '@macramejs/admin-vue3';
import FilesSidebar from './components/FilesSidebar.vue';
import FilesTopbarLeft from './components/FilesTopbarLeft.vue';
import FilesTopbarRight from './components/FilesTopbarRight.vue';
import FilesContent from './components/FilesContent.vue';
// import FilesFilters from './components/FilesFilters.vue';

const props = defineProps({
    collections: {
        type: Object as PropType<MediaCollectionCollectionResource>,
        requried: true,
    },
    collection: {
        type: Object as PropType<MediaCollectionResource>,
        requried: false,
    },
});

mediaIndex.filters.collection.update(props.collection?.data);

watch(
    props.collection,
    () => mediaIndex.filters.collection.update(props.collection?.data),
    { immediate: true }
);

// initially load files.
mediaIndex.loadItems();
</script>
