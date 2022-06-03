<template>
    <SidebarSecondarySection>
        <SidebarLink title="Main Navigation" href="/admin/nav/main" secondary />
        <SidebarLink
            class="flex-1 py-1 cursor-pointer"
            title="Footer Navigation"
            href="/admin/nav/footer"
            secondary
        />
    </SidebarSecondarySection>
</template>

<script lang="ts" setup>
import { SidebarLink, SidebarSecondarySection } from '@macramejs/admin-vue3';
</script>
