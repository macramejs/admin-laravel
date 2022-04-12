<template>
    <SidebarSection :expandable="true" title="foo">
        <SidebarLink
            title="Main Navigation"
            href="/{{ app }}/{{ route }}/main"
            secondary
        />
        <SidebarLink
            title="Footer Navigation"
            href="/{{ app }}/{{ route }}/footer"
            secondary
        />
    </SidebarSection>
</template>

<script lang="ts" setup>
import { SidebarLink, SidebarSection } from '@macramejs/admin-vue3';
</script>
