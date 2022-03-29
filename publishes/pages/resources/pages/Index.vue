<template>
    <{{ namespace }} sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <PageSidebar :pages="pages.data" />
        </template>
        <template v-slot:topbar-left>
            <slot name="topbar-left" />
        </template>
        <slot />
    </{{ namespace }}>
</template>

<script setup lang="ts">
import { watch, ref, PropType } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { {{ namespace }} } from '@{{ app }}/layout';
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
