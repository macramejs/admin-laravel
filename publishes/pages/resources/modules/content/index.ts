// Components

export { default as SelectImage } from './sections/components/SelectImage.vue';

// Drawers

export { default as DrawerTextFull } from './drawers/DrawerTextFull.vue';
export { default as DrawerTextImage } from './drawers/DrawerTextImage.vue';
export { default as DrawerInfoBox } from './drawers/DrawerInfoBox.vue';

export { default as DrawerImageFull } from './drawers/DrawerImageFull.vue';
export { default as DrawerGallery } from './drawers/DrawerGallery.vue';

export { default as DrawerCards } from './drawers/DrawerCards.vue';
export { default as DrawerCarousel } from './drawers/DrawerCarousel.vue';
export { default as DrawerAccordion } from './drawers/DrawerAccordion.vue';
export { default as DrawerLogoWall } from './drawers/DrawerLogoWall.vue';

// Sections

export { default as SectionTextFull } from './sections/SectionTextFull.vue';
export { default as SectionTextImage } from './sections/SectionTextImage.vue';
export { default as SectionInfoBox } from './sections/SectionInfoBox.vue';
export { default as SectionImageFull } from './sections/SectionImageFull.vue';
export { default as SectionGallery } from './sections/SectionGallery.vue';
export { default as SectionCards } from './sections/SectionCards.vue';
export { default as SectionAccordion } from './sections/SectionAccordion.vue';
export { default as SectionLogoWall } from './sections/SectionLogoWall.vue';
export { default as SectionCarousel } from './sections/SectionCarousel.vue';

import SectionTextFull from './sections/SectionTextFull.vue';
import SectionTextImage from './sections/SectionTextImage.vue';
import SectionInfoBox from './sections/SectionInfoBox.vue';
import SectionImageFull from './sections/SectionImageFull.vue';
import SectionGallery from './sections/SectionGallery.vue';
import SectionCards from './sections/SectionCards.vue';
import SectionAccordion from './sections/SectionAccordion.vue';
import SectionLogoWall from './sections/SectionLogoWall.vue';
import SectionCarousel from './sections/SectionCarousel.vue';

const sections = {
    text_full: SectionTextFull,
    image_full: SectionImageFull,
    carousel: SectionCarousel,
    gallery: SectionGallery,
    info_box: SectionInfoBox,
    cards: SectionCards,
    text_image: SectionTextImage,
    accordion: SectionAccordion,
    logo_wall: SectionLogoWall,
};

export { sections };
