<template>
    <SidebarSecondarySection>
        <AddCollectionForm class="mb-4" v-if="showForm" />
    </SidebarSecondarySection>
    <SidebarSecondarySection>
        <SidebarLink
            secondary
            :active="!collection"
            class="pr-4"
            href="/admin/media"
            key="all"
        >
            <div class="flex justify-between">
                All
                <span class="text-gray-300"> {{ mediaIndex.totalItems }}</span>
            </div>
        </SidebarLink>
        <SidebarLink
            v-for="c in collections"
            :key="c.id"
            secondary
            :active="c.id == collection?.id"
            class="pr-4"
            :href="
                c.id == collection?.id ? `/admin/media` : `/admin/media/${c.id}`
            "
        >
            <div class="flex justify-between">
                {{ c.title }}
                <span class="text-gray-300"> {{ c.files_count }}</span>
            </div>
        </SidebarLink>
    </SidebarSecondarySection>
</template>

<script lang="ts" setup>
import { SidebarLink, SidebarSecondarySection } from '@macramejs/admin-vue3';
import { PropType } from 'vue';
import { MediaCollection } from '@admin/types';

import { mediaIndex } from '@admin/modules/media';
import AddCollectionForm from './AddCollectionForm.vue';

const props = defineProps({
    collections: {
        type: Array as PropType<MediaCollection[]>,
        required: true,
    },
    collection: {
        type: Object as PropType<MediaCollection>,
        required: false,
    },
    showForm: {
        type: Boolean,
        required: true,
    },
});
</script>
