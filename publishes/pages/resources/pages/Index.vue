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
import { PropType } from 'vue';
import { Admin } from '@admin/layout';
import PageSidebar from './components/PagesSidebar.vue';
import { {{ model }}TreeCollectionResource } from '@{{ app }}/types';

const props = defineProps({
    pages: {
        type: Object as PropType<{{ model }}TreeCollectionResource>,
        required: true,
    },
});
</script>
