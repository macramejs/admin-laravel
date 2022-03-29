<template>
    <SidebarSection :expandable="true" title="foo">
        <SidebarLink
            title="Main Navigation"
            href="/admin/navigations/main"
            secondary
        />
        <SidebarLink
            title="Footer Navigation"
            href="/admin/navigations/footer"
            secondary
        />
    </SidebarSection>
</template>

<script lang="ts" setup>
import { SidebarLink, SidebarSection } from '@macramejs/admin-vue3';
</script>
