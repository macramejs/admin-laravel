<template>
    <DrawerSection title="Text Components">
        <Cabinet>
            <DrawerTextFull :draws="SectionTextFull" v-if="sections.text_full" />
            <DrawerTextImage :draws="SectionTextImage" v-if="sections.text_image" />
            <DrawerInfoBox :draws="SectionInfoBox" v-if="sections.info_box" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Image Components">
        <Cabinet>
            <DrawerImageFull :draws="SectionImageFull" v-if="sections.image_full" />
            <DrawerGallery :draws="SectionGallery" v-if="sections.gallery" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Sections">
        <Cabinet>
            <DrawerCards :draws="SectionCards" v-if="sections.cards" />
            <DrawerLogoWall :draws="SectionLogoWall" v-if="sections.logo_wall" />
            <DrawerAccordion :draws="SectionAccordion" v-if="sections.accordion" />
        </Cabinet>
    </DrawerSection>
    <DrawerSection title="Carousels">
        <Cabinet>
            <DrawerCarousel :draws="SectionCarousel" v-if="sections.carousel" />
        </Cabinet>
    </DrawerSection>
</template>

<script lang="ts" setup>
import { DrawerSection } from '@macramejs/admin-vue3';
import { Cabinet } from '@macramejs/macrame-vue3';

import {
    SectionTextFull,
    SectionCarousel,
    SectionTextImage,
    SectionInfoBox,
    SectionImageFull,
    SectionGallery,
    SectionCards,
    SectionAccordion,
    SectionLogoWall,
} from './index';
import {
    DrawerTextFull,
    DrawerCarousel,
    DrawerTextImage,
    DrawerInfoBox,
    DrawerImageFull,
    DrawerGallery,
    DrawerCards,
    DrawerAccordion,
    DrawerLogoWall,
} from './index';

defineProps({
    sections: {
        type: Object,
        required: true
    }
});
</script>