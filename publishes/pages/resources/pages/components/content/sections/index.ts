export { default as SectionTextFull } from './SectionTextFull.vue';
export { default as SectionTextImage } from './SectionTextImage.vue';
export { default as SectionInfoBox } from './SectionInfoBox.vue';
export { default as SectionImageFull } from './SectionImageFull.vue';
export { default as SectionGallery } from './SectionGallery.vue';
export { default as SectionCards } from './SectionCards.vue';
export { default as SectionAccordion } from './SectionAccordion.vue';
export { default as SectionLogoWall } from './SectionLogoWall.vue';
export { default as SectionCarousel } from './SectionCarousel.vue';

import SectionTextFull from './SectionTextFull.vue';
import SectionTextImage from './SectionTextImage.vue';
import SectionInfoBox from './SectionInfoBox.vue';
import SectionImageFull from './SectionImageFull.vue';
import SectionGallery from './SectionGallery.vue';
import SectionCards from './SectionCards.vue';
import SectionAccordion from './SectionAccordion.vue';
import SectionLogoWall from './SectionLogoWall.vue';
import SectionCarousel from './SectionCarousel.vue';

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
