<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerGallery preview />
        </template>
        <Card>
            <Draggable
                tag="div"
                class="grid grid-cols-4 gap-5"
                :list="model.items"
                item-key="_draggableKey"
                v-if="model"
            >
                <template #item="{ element, index }">
                    <SelectImage v-model="element.image" />
                </template>
            </Draggable>
        </Card>
        <div class="flex justify-center mt-6">
            <AddItem @click="addItem"> Bild hinzufügen </AddItem>
        </div>
    </BaseSection>
</template>
<script setup lang="ts">
import Draggable from "vuedraggable";
import { Card, Section as BaseSection } from "@macramejs/admin-vue3";
import { defineProps, watch, defineEmits, reactive } from "vue";
import DrawerGallery from "./../drawers/DrawerGallery.vue";
import SelectImage from "./components/SelectImage.vue";
import AddItem from "./components/AddItem.vue";
import { v4 as uuid } from "uuid";

const emit = defineEmits(["update:modelValue"]);
const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            items: [],
        }),
    },
});

const model = reactive({
    items: props.modelValue.items.map((item) => {
        item._draggableKey = uuid();

        return item;
    }),
});

function addItem() {
    console.log("foo");
    model.items.push({
        name: "",
        link: "",
        _draggableKey: uuid(),
        image: {
            id: null,
            title: "",
            alt: "",
        },
    });
}

function removeItem(index) {
    model.items.splice(index, 1);
}

watch(
    () => model,
    () => {
        let items = JSON.parse(JSON.stringify(model.items)).map((item) => {
            delete item._draggableKey;

            return item;
        });

        emit("update:modelValue", {
            ...model,
            items,
        });
    },
    { deep: true }
);
</script>
