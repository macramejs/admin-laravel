<template>
    <SidebarSection :expandable="true" title="foo">
        <SidebarLink title="Main Navigation" href="/admin/nav/main" secondary />
        <SidebarLink
            title="Footer Navigation"
            href="/admin/nav/footer"
            secondary
        />
    </SidebarSection>
</template>

<script lang="ts" setup>
import { SidebarLink, SidebarSection } from '@macramejs/admin-vue3';
</script>
