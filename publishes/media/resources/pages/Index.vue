<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <FilesSidebar
                :collections="collections.data"
                :collection="collection?.data"
            />
        </template>
        <template v-slot:topbar-left> Topbar Left </template>
        <template v-slot:topbar-right>
            <FilesTopbarRight />
        </template>
        <slot>
            <FilesTabs />
        </slot>
    </Admin>
</template>

<script lang="ts" setup>
import { PropType, watch } from 'vue';
import { Admin } from '@admin/layout';
import { index } from './modules';
import {
    FileCollectionCollectionResource,
    FileCollectionResource,
} from '@admin/modules/resources';
import FilesSidebar from './components/FilesSidebar.vue';
import FilesTopbarRight from './components/FilesTopbarRight.vue';
import FilesTabs from './components/FilesTabs.vue';

const props = defineProps({
    collections: {
        type: Object as PropType<FileCollectionCollectionResource>,
        requried: true,
    },
    collection: {
        type: Object as PropType<FileCollectionResource>,
        requried: false,
    },
});

index.filters.collection.update(props.collection?.data);
watch(
    props.collection,
    () => index.filters.collection.update(props.collection?.data),
    { immediate: true }
);

// initially load files.
index.loadItems();
</script>
