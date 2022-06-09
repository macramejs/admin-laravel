<template>
    <div
        class="relative"
        :class="{
            'overflow-hidden': !overflow,
        }"
    >
        <img
            :src="thumb"
            class="lazyload lazyload-animation w-full object-cover h-auto max-h-full max-w-full"
            :class="{
                'object-cover': cover,
            }"
            data-sizes="auto"
            :data-srcset="srcset"
            :srcset="srcset"
        />
    </div>
</template>

<script lang="ts" setup>
import 'lazysizes';
import { computed, PropType } from 'vue';

const props = defineProps({
    src: {
        type: String,
        required: true,
    },
    sizes: {
        type: Array as PropType<Number[]>,
        default: () => {
            return [10, 300, 500, 900, 1400];
        },
    },
    cover: {
        type: Boolean,
        default: false,
    },
    overflow: {
        type: Boolean,
        default: false,
    },
});

const thumb = computed(() => {
    let w = Math.min.apply(Math, props.sizes);
    return `${props.src}?w=${w}`;
});

const srcset = computed(() => {
    let srcset = '';
    props.sizes.forEach(size => {
        srcset += `${props.src}?w=${size} ${size}w, `;
    });
    return srcset;
});
</script>

<style>
.lazyload,
.lazyloading {
    filter: blur(20px);
}
.lazyloaded {
    filter: blur(0px);
}
.lazyload-animation {
    transition: 0.25s filter ease;
}
</style>
