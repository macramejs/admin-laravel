export { default as Drawers } from './Drawers.vue';

// Components
export { default as SelectImage } from './sections/components/SelectImage.vue';

// Drawers
export { default as DrawerAccordion } from './drawers/DrawerAccordion.vue';
export { default as DrawerCards } from './drawers/DrawerCards.vue';
export { default as DrawerGridGallery } from './drawers/DrawerGridGallery.vue';
export { default as DrawerImageCarousel } from './drawers/DrawerImageCarousel.vue';
export { default as DrawerImageFull } from './drawers/DrawerImageFull.vue';
export { default as DrawerInfoBox } from './drawers/DrawerInfoBox.vue';
export { default as DrawerLogoWall } from './drawers/DrawerLogoWall.vue';
export { default as DrawerTextFull } from './drawers/DrawerTextFull.vue';
export { default as DrawerTextImage } from './drawers/DrawerTextImage.vue';

// Sections
export { default as SectionAccordion } from './sections/SectionAccordion.vue';
export { default as SectionCards } from './sections/SectionCards.vue';
export { default as SectionGridGallery } from './sections/SectionGridGallery.vue';
export { default as SectionImageCarousel } from './sections/SectionImageCarousel.vue';
export { default as SectionImageFull } from './sections/SectionImageFull.vue';
export { default as SectionInfoBox } from './sections/SectionInfoBox.vue';
export { default as SectionLogoWall } from './sections/SectionLogoWall.vue';
export { default as SectionTextFull } from './sections/SectionTextFull.vue';
export { default as SectionTextImage } from './sections/SectionTextImage.vue';

import SectionTextFull from './sections/SectionTextFull.vue';
import SectionTextImage from './sections/SectionTextImage.vue';
import SectionInfoBox from './sections/SectionInfoBox.vue';
import SectionImageFull from './sections/SectionImageFull.vue';
import SectionGridGallery from './sections/SectionGridGallery.vue';
import SectionCards from './sections/SectionCards.vue';
import SectionAccordion from './sections/SectionAccordion.vue';
import SectionLogoWall from './sections/SectionLogoWall.vue';
import SectionImageCarousel from './sections/SectionImageCarousel.vue';

const sections = {
    text_full: SectionTextFull,
    image_full: SectionImageFull,
    image_carousel: SectionImageCarousel,
    grid_gallery: SectionGridGallery,
    info_box: SectionInfoBox,
    cards: SectionCards,
    text_image: SectionTextImage,
    accordion: SectionAccordion,
    logo_wall: SectionLogoWall,
};

export { sections };
