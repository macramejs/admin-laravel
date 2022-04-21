<template>
    <DrawerSection title="Text Components">
        <Cabinet>
            <DrawerTextFull :draws="SectionTextFull" />
        </Cabinet>
        <Cabinet>
            <DrawerTextImage :draws="SectionTextImage" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Image Components">
        <Cabinet>
            <DrawerImageFull :draws="SectionImageFull" />
        </Cabinet>
    </DrawerSection>
</template>

<script lang="ts" setup>
import {
    SectionTextFull,
    SectionTextImage,
    SectionImageFull,
} from './content/sections';
import {
    DrawerTextFull,
    DrawerTextImage,
    DrawerImageFull,
} from './content/drawers';
import { DrawerSection } from '@macramejs/admin-vue3';
import { Cabinet } from '@macramejs/macrame-vue3';
</script>
