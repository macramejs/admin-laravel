<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <PageSidebar :pages="pages.data" />
        </template>
        <template v-slot:topbar-left>
            <slot name="topbar-left" />
        </template>
        <slot />
    </Admin>
</template>

<script setup lang="ts">
import { watch, ref, PropType } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Admin } from '@admin/layout';
// import { showCreateModal, Create } from './components/Create';
import PageSidebar from './components/PagesSidebar.vue';
import { SidebarSecondary, Button } from '@macramejs/admin-vue3';
import { {{ model }}ListCollectionResource } from '@{{ app }}/types';

const props = defineProps({
    pages: {
        type: Object as PropType<{{ model }}ListCollectionResource>,
        required: true,
    },
});
</script>
