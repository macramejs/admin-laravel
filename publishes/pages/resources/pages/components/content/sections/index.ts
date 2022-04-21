export { default as SectionTextFull } from './SectionTextFull.vue';
export { default as SectionTextImage } from './SectionTextImage.vue';
export { default as SectionImageFull } from './SectionImageFull.vue';

import SectionTextFull from './SectionTextFull.vue';
import SectionTextImage from './SectionTextImage.vue';
import SectionImageFull from './SectionImageFull.vue';

const sections = {
    text_full: SectionTextFull,
    text_image: SectionTextImage,
    image_full: SectionImageFull,
};

export { sections }