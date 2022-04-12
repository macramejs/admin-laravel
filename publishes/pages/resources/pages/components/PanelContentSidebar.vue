<template>
    <DrawerSection title="Text Components">
        <Cabinet>
            <DrawerTextFull :draws="SectionTextFull" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Image Components">
        <Cabinet>
            <DrawerImageFull :draws="SectionImageFull" />
        </Cabinet>
    </DrawerSection>
</template>

<script lang="ts" setup>
import { SectionTextFull, SectionImageFull } from './content/sections';
import { DrawerTextFull, DrawerImageFull } from './content/drawers';
import { DrawerSection } from '@macramejs/admin-vue3';
import { Cabinet } from '@macramejs/macrame-vue3';
</script>
