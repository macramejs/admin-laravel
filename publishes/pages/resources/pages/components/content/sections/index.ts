export { default as CardsSection } from './CardsSection.vue';
export { default as TextSection } from './TextSection.vue';

import CardsSection from './CardsSection.vue';
import TextFullSection from './TextFullSection.vue';

const sections = {
    text_full: TextFullSection,
    cards: CardsSection,
};

export { sections }