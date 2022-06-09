<template>
    <div class="flex items-center space-x-6">
        <div class="flex items-center space-x-2">
            <span class="text-xs uppercase">
                <template v-if="!form.is_live">offline</template>
                <template v-else-if="!form.publish_at || hasBeenPublished">online</template>
                <template v-else>geplant</template>
            </span>
            <Toggle :modelValue="form.is_live && (!form.publish_at || hasBeenPublished)" @update:modelValue="() => {
                if(form.publish_at) {
                    publishAt = null;
                } 
                form.is_live = !form.is_live;
            }"/>
        </div>
        <DatePicker
            v-model="publishAt"
            v-slot="{ togglePopover }"
            class="relative"
            is-dark
            color="orange"
            mode="dateTime"
            is24hr
            timezone=""
            :min-date="new Date()"
        >
            <div
                class="relative flex items-center justify-center w-8 h-8 bg-gray-200 rounded cursor-pointer hover:bg-gray-300"
                @click="togglePopover"
            >
                <div
                    class="absolute top-0 right-0 w-3 h-3 -mt-1 -mr-1 border-2 border-gray-100 rounded-full bg-orange"
                    v-if="form.publish_at"
                ></div>
                <svg
                    class="w-4 h-4"
                    width="24"
                    height="24"
                    stroke-width="1.5"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M15 4V2M15 4V6M15 4H10.5M3 10V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V10H3Z"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M3 10V6C3 4.89543 3.89543 4 5 4H7"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M7 2V6"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M21 10V6C21 4.89543 20.1046 4 19 4H18.5"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>
        </DatePicker>

        <TopbarRight />
    </div>
</template>
<script lang="ts" setup>
// imports
import { PropType, ref, watch } from 'vue';
import TopbarRight from '@admin/layout/TopbarRight.vue';
import { Toggle } from '@macramejs/admin-vue3';
import { DatePicker } from 'v-calendar';
import 'v-calendar/dist/style.css';

// types
import { Page } from '@admin/types/resources';
import { PageContentForm } from '@admin/types/forms';

const props = defineProps({
    page: {
        type: Object as PropType<Page>,
        required: true,
    },
    form: {
        type: Object as PropType<PageContentForm>,
        required: true,
    },
});

const hasBeenPublished = ref(props.page.has_been_published);

const publishAt = ref(
    props.page.publish_at
        ? new Date(props.page.publish_at)
        : new Date()
);

watch(
    () => publishAt.value,
    date => {
        props.form.publish_at = date;
        if(date != null) props.form.is_live = true;
        hasBeenPublished.value = false;
    }
);
</script>