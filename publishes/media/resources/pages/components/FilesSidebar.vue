<template>
    <SidebarSecondary>
        <template v-slot:header>
            <FilesSidebarHeader v-model:showForm="showForm" />
        </template>
        <template v-slot:default>
            <FilesSidebarBody
                :collections="collections"
                :collection="collection"
                :show-form="showForm"
            />
        </template>
    </SidebarSecondary>
</template>

<script lang="ts" setup>
import { PropType, ref } from 'vue';
import {
    SidebarSecondary,
    SidebarSecondarySection,
} from '@macramejs/admin-vue3';
import FilesSidebarHeader from './FilesSidebarHeader.vue';
import FilesSidebarBody from './FilesSidebarBody.vue';
import { MediaCollection } from '@admin/types';

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

const showForm = ref(false);
</script>
