<template>
    <ContentSidebar v-model:open="isOpen">
        <Drawers :sections="drawsSections" />
    </ContentSidebar>
</template>

<script lang="ts" setup>
import { Drawers, sections } from "@admin/modules/content";
import { Cabinet } from "@macramejs/macrame-vue3";
import { ContentSidebar, DrawerSection } from "@macramejs/admin-vue3";

import { ref } from "vue";

// allow drawing all registered sections
let drawsSections = {};
for (let key in sections) drawsSections[key] = true;

const isOpen = ref(true);
</script>
