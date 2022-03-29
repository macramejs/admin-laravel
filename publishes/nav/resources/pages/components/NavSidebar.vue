<template>
    <SidebarSecondary>
        <template v-slot:header>
            <NavSidebarHeader />
        </template>
        <template v-slot:default>
            <NavSidebarBody />
        </template>
    </SidebarSecondary>
</template>

<script lang="ts" setup>
import { SidebarSecondary } from '@macramejs/admin-vue3';
import NavSidebarHeader from './NavSidebarHeader.vue';
import NavSidebarBody from './NavSidebarBody.vue';
</script>
