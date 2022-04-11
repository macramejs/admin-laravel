<template>
    <{{ namespace }} sidebar-secondary>
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
    </{{ namespace }}>
</template>

<script lang="ts" setup>
import { PropType, watch } from 'vue';
import { {{ namespace }} } from '@{{ app }}/layout';
import { mediaIndex } from './{{ app }}/modules/{{ name }}';
import {
    {{ page }}CollectionCollectionResource,
    {{ page }}CollectionResource,
} from '@{{ app }}/types';
import FilesSidebar from './components/FilesSidebar.vue';
import FilesTopbarRight from './components/FilesTopbarRight.vue';
import FilesTabs from './components/FilesTabs.vue';

const props = defineProps({
    collections: {
        type: Object as PropType<{{ page }}CollectionCollectionResource>,
        requried: true,
    },
    collection: {
        type: Object as PropType<{{ page }}CollectionResource>,
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
