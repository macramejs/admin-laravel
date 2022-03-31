export { default as CardsSection } from './CardsSection.vue';
export { default as TextSection } from './TextSection.vue';

import CardsSection from './CardsSection.vue';
import TextSection from './TextSection.vue';

const sections = {
    text: TextSection,
    cards: CardsSection,
};

export { sections }