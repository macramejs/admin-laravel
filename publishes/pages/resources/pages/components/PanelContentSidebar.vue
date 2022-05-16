<template>
    <DrawerSection title="Text Components">
        <Cabinet>
            <DrawerTextFull :draws="SectionTextFull" />
            <DrawerTextImage :draws="SectionTextImage" />
            <DrawerInfoBox :draws="SectionInfoBox" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Image Components">
        <Cabinet>
            <DrawerImageFull :draws="SectionImageFull" />
            <DrawerGallery :draws="SectionGallery" />
            <DrawerLogoWall :draws="SectionLogoWall" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Sections">
        <Cabinet>
            <DrawerCards :draws="SectionCards" />
            <DrawerAccordion :draws="SectionAccordion" />
            <DrawerCarousel :draws="SectionCarousel" />
            <DrawerTabs :draws="SectionTabs" />
            <DrawerMap :draws="SectionMap" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Sliders">
        <Cabinet>
            <DrawerSlider :draws="SectionSlider" />
            <DrawerGallerySlider :draws="SectionGallerySlider" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Misc">
        <Cabinet>
            <DrawerFiles :draws="SectionFiles" />
            <DrawerDivider :draws="SectionDivider" />
            <DrawerVideo :draws="SectionVideo" />
        </Cabinet>
    </DrawerSection>
</template>

<script lang="ts" setup>
import {
    SectionTextFull,
    SectionCarousel,
    SectionTextImage,
    SectionInfoBox,
    SectionImageFull,
    SectionGallery,
    SectionCards,
    SectionAccordion,
    SectionTabs,
    SectionLogoWall,
    SectionMap,
    SectionSlider,
    SectionGallerySlider,
    SectionFiles,
    SectionDivider,
    SectionVideo,
} from './content/sections';
import {
    DrawerTextFull,
    DrawerCarousel,
    DrawerTextImage,
    DrawerInfoBox,
    DrawerImageFull,
    DrawerGallery,
    DrawerCards,
    DrawerAccordion,
    DrawerTabs,
    DrawerLogoWall,
    DrawerMap,
    DrawerSlider,
    DrawerGallerySlider,
    DrawerFiles,
    DrawerDivider,
    DrawerVideo,
} from './content/drawers';
import { DrawerSection } from '@macramejs/admin-vue3';
import { Cabinet } from '@macramejs/macrame-vue3';
</script>
