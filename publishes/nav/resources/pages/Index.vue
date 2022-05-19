<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <NavSidebar />
        </template>
        <template v-slot:topbar-left>
            <slot name="topbar-left" />
        </template>
    </Admin>
</template>

<script setup lang="ts">
import { {{ namespace }} } from '@{{ app }}/layout';
import NavSidebar from './components/NavSidebar.vue';
</script>
