import DefaultTemplate from './DefaultTemplate.vue';

const templates = {
    default: DefaultTemplate
};

let templateOptions = [
    {
        label: 'Standard',
        value: 'default',
    },
]
export { DefaultTemplate, templateOptions, templates }