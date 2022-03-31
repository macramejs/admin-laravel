<template>
    <DrawerSection title="Text Komponenten">
        <Cabinet>
            <TextDrawer :draws="TextSection" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Other">
        <Cabinet>
            <CardsDrawer :draws="CardsSection" />
        </Cabinet>
    </DrawerSection>
</template>

<script lang="ts" setup>
import { TextSection, CardsSection } from './content/sections';
import { CardsDrawer, TextDrawer } from './content/drawers';
import { DrawerSection } from '@macramejs/admin-vue3';
import { Cabinet } from '@macramejs/macrame-vue3';
</script>
