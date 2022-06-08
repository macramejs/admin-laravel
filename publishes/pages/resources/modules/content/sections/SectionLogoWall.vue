<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerLogoWall preview />
        </template>
        <Card class="mb-3">
            <Input v-model="model.headline" label="Überschrift" />
        </Card>
        <div class="pb-6 space-y-3">
            <Draggable
                tag="div"
                class="grid grid-cols-3 gap-5"
                :list="model.items"
                handle=".drag-logo"
                item-key="_draggableKey"
                v-if="model"
            >
                <template #item="{ element, index }">
                    <Card class="mb-3" :key="index">
                        <Header class="mb-6">
                            <div class="flex items-center space-x-4">
                                <InteractionButton
                                    class="cursor-move drag-logo"
                                    gray
                                >
                                    <IconDraggable class="w-2.5 h-2.5" />
                                </InteractionButton>
                                <div class="text-lg font-semibold">
                                    {{ element.name || "Logo" }}
                                </div>
                            </div>
                            <ContextMenu placement="left">
                                <template #button>
                                    <InteractionButton class="cursor-pointer">
                                        <IconMoreHorizontal class="w-4 h-4" />
                                    </InteractionButton>
                                </template>
                                <ContextMenuItem
                                    class="hover:bg-red-signal text-red-signal"
                                    @click="removeItem(index)"
                                >
                                    <template #icon>
                                        <IconTrash
                                            class="origin-left scale-75"
                                        />
                                    </template>
                                    <span>Löschen</span>
                                </ContextMenuItem>
                            </ContextMenu>
                        </Header>
                        <div class="space-y-4">
                            <SelectImage v-model="element.image" />
                            <Input v-model="element.name" label="Name" />
                            <Link v-model="element.link" label="Link" />
                        </div>
                    </Card>
                </template>
            </Draggable>
        </div>
        <div class="flex justify-center">
            <AddItem @click="addItem"> Neues Logo hinzufügen </AddItem>
        </div>
    </BaseSection>
</template>
<script setup lang="ts">
import {
    Card,
    Section as BaseSection,
    InteractionButton,
    IconDraggable,
    IconTrash,
    IconMoreHorizontal,
    Input,
    Header,
    ContextMenu,
    ContextMenuItem,
} from "@macramejs/admin-vue3";
import { watch, reactive } from "vue";
import DrawerLogoWall from "../drawers/DrawerLogoWall.vue";
import AddItem from "./components/AddItem.vue";
import Draggable from "vuedraggable";
import Link from "./components/Link.vue";
import SelectImage from "./components/SelectImage.vue";
import { v4 as uuid } from "uuid";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            headline: "",
            items: [],
        }),
    },
});

const model = reactive({
    headline: props.modelValue.headline,
    items: props.modelValue.items.map((item) => {
        return { ...item, _draggableKey: uuid() };
    }),
});

function addItem() {
    model.items.push({
        name: "",
        _draggableKey: uuid(),
        link: {
            link: "",
            text: "",
            new_tab: false,
        },
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
