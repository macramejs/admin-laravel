<template>
    <DrawerSection title="Text Komponenten">
        <Cabinet>
            <TextFullDrawer :draws="TextFullSection" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Other">
        <Cabinet>
            <CardsDrawer :draws="CardsSection" />
        </Cabinet>
    </DrawerSection>
</template>

<script lang="ts" setup>
import { TextFullSection } from './content/sections';
import { TextFullDrawer } from './content/drawers';
import { DrawerSection } from '@macramejs/admin-vue3';
import { Cabinet } from '@macramejs/macrame-vue3';
</script>
