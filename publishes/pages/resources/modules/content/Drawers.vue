<template>
    <DrawerSection title="Inhalt">
        <Cabinet>
            <DrawerTextFull
                :draws="SectionTextFull"
                v-if="sections.text_full"
            />
            <DrawerTextImage
                :draws="SectionTextImage"
                v-if="sections.text_image"
            />
            <DrawerInfoBox :draws="SectionInfoBox" v-if="sections.info_box" />
            <DrawerImageFull
                :draws="SectionImageFull"
                v-if="sections.image_full"
            />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Bildgalerien">
        <Cabinet>
            <DrawerGridGallery
                :draws="SectionGridGallery"
                v-if="sections.grid_gallery"
            />
            <DrawerImageCarousel
                :draws="SectionImageCarousel"
                v-if="sections.image_carousel"
            />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Abschnitte">
        <Cabinet>
            <DrawerCards :draws="SectionCards" v-if="sections.cards" />
            <DrawerLogoWall
                :draws="SectionLogoWall"
                v-if="sections.logo_wall"
            />
            <DrawerAccordion
                :draws="SectionAccordion"
                v-if="sections.accordion"
            />
        </Cabinet>
    </DrawerSection>
</template>

<script lang="ts" setup>
import { DrawerSection } from '@macramejs/admin-vue3';
import { Cabinet } from '@macramejs/macrame-vue3';

import {
    SectionTextFull,
    SectionImageCarousel,
    SectionTextImage,
    SectionInfoBox,
    SectionImageFull,
    SectionGridGallery,
    SectionCards,
    SectionAccordion,
    SectionLogoWall,
} from './index';
import {
    DrawerTextFull,
    DrawerImageCarousel,
    DrawerTextImage,
    DrawerInfoBox,
    DrawerImageFull,
    DrawerGridGallery,
    DrawerCards,
    DrawerAccordion,
    DrawerLogoWall,
} from './index';

defineProps({
    sections: {
        type: Object,
        required: true,
    },
});
</script>
