export { default as SectionTextFull } from './SectionTextFull.vue';
export { default as SectionImageFull } from './SectionImageFull.vue';
export { default as SectionCards } from './SectionCards.vue';

import SectionTextFull from './SectionTextFull.vue';
import SectionImageFull from './SectionImageFull.vue';
import SectionCards from './SectionCards.vue';

const sections = {
    text_full: SectionTextFull,
    image_full: SectionImageFull,
    cards: SectionCards,
};

export { sections }