<template>
    <{{ namespace }}>
        <div class="flex h-screen">
            <div class="m-auto">
                <h2>Hallo <b>World</b></h2>
            </div>
        </div>
    </{{ namespace }}>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { {{ namespace }} } from '@admin/layout';

export default defineComponent({
    components: { {{ namespace }} },
    props: {
        //
    },
    setup() {
        //
    },
});
</script>
