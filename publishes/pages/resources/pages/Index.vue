<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <PageSidebar :pages="pages.data" />
        </template>
        <template v-slot:topbar-left>
            <slot name="topbar-left" />
        </template>
        <template v-slot:topbar-right>
            <slot name="topbar-right" />
        </template>
        <slot />
    </Admin>
</template>

<script setup lang="ts">
import { PropType } from 'vue';
import { Admin } from '@admin/layout';
import PageSidebar from './components/PagesSidebar.vue';
import { PageTreeCollectionResource } from '@admin/types';

const props = defineProps({
    pages: {
        type: Object as PropType<PageTreeCollectionResource>,
        required: true,
    },
});
</script>
