<template>
    <BaseSection>
        Carousel

        <template v-if="!busy">
            <div v-for="(item, key) in model.items" :key="key">
                <img
                    :src="model.items[key].selectedImage?.url"
                    v-if="model.items[key].selectedImage"
                />
                <SelectImageModal
                    v-model="model.items[key].selectedImage"
                    v-if="model.items[key]"
                />
                <Button sm square @click="removeItem(key)">-</Button>
            </div>
        </template>

        <Button sm square @click="addItem">+</Button>
    </BaseSection>
</template>
<script setup lang="ts">
import { Button, Section as BaseSection } from '@macramejs/admin-vue3';
import {
    defineProps,
    watch,
    defineEmits,
    reactive,
    ref,
    onBeforeMount,
} from 'vue';
import { getMediaById } from '@admin/modules/media';
import SelectImageModal from './SelectImageModal.vue';
import { v4 as uuid } from 'uuid';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            items: [],
        }),
    },
});

const model = reactive(props.modelValue);
const busy = ref<boolean>(true);

function addItem() {
    model.items.push({
        selectedImage: {},
        image: '',
        title: '',
        text: '',
    });
}

function removeItem(index) {
    model.items.splice(index, 1);
}

onBeforeMount(async () => {
    for (let i = 0; i < model.items.length; i++) {
        model.items[i].selectedImage = model.items[i].image
            ? await getMediaById(model.items[i].image)
            : null;
    }

    busy.value = false;
});

emit('update:modelValue', model);

watch(
    () => model,
    () => {
        let m = JSON.parse(JSON.stringify(model));

        for (let i = 0; i < model.items.length; i++) {
            m.items[i].image = m.items[i].selectedImage?.id;
            delete m.items[i].selectedImage;
        }

        emit('update:modelValue', m);
    },
    { deep: true }
);
</script>
