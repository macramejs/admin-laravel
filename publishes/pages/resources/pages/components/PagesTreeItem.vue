<template>
    <Disclosure v-slot="{ open }" defaultOpen>
        <div class="flex items-center justify-between w-full">
            <div
                class="flex justify-between flex-1 pl-3 pr-2 rounded hover:bg-gray-100"
                :class="{
                    'bg-gray-100': isActive
                }"
            >
                <div
                    class="flex items-center pr-3 cursor-move text-gray handle"
                >
                    <svg
                        class="w-2.5 h-2.5 fill-gray"
                        viewBox="0 0 18 9"
                        xmlns="http://www.w3.org/2000/svg"
                        xml:space="preserve"
                    >
                        <path
                            d="M18 7.597a1 1 0 0 0-1-1H1a1 1 0 0 0 0 2h16a1 1 0 0 0 1-1ZM18 1a1 1 0 0 0-1-1H1a1 1 0 0 0 0 2h16a1 1 0 0 0 1-1Z"
                        />
                    </svg>
                </div>
                <div class="flex items-center justify-between flex-1 py-1">
                     <Link
                        class="flex-1 py-1 cursor-pointer"
                        :href="`/{{ app }}/pages/${item.id}`"
                    >
                        {{ item.name }}
                    </Link>
                    <button class="flex items-center justify-center w-6 h-6 bg-transparent rounded hover:bg-gray-800 group hover:text-white">
                        <svg class="w-3 h-3 group-hover:fill-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" ><path style="fill:none" d="M0 0h24v24H0z"/><g transform="translate(.113 -1.351)"><circle cx="4.678" cy="13.351" r="1.475"/><circle cx="4.678" cy="13.351" r="1.475" transform="translate(7.209)"/><circle cx="4.678" cy="13.351" r="1.475" transform="translate(14.418)"/></g></svg>
                    </button>
                </div>
            </div>
            <div class="flex items-center w-8">
                <DisclosureButton
                    class="p-1 hover:bg-gray-400 rounded-xs"
                    :class="{ 'rotate-180': !open }"
                    v-if="children?.items.length > 0"
                >
                    <svg
                        width="24"
                        height="24"
                        stroke-width="1.5"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-3 h-3"
                    >
                        <path
                            d="M6 9L12 15L18 9"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </DisclosureButton>
            </div>
        </div>
        <DisclosurePanel class="pl-6">
            <slot name="disclosure" />
        </DisclosurePanel>
    </Disclosure>
</template>

<script lang="ts" setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { Link } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    children: {
        required: true,
    },
});

const isActive = computed(()=>{
    let pageId: number = props.item.id
    return (`/{{ app }}/pages/${pageId}` == window.location.pathname)
})
</script>
