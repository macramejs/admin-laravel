<template>
    <Layout>
        <div class="flex h-screen">
            <div class="m-auto">
                <h2>Hallo <b>World</b></h2>
            </div>
        </div>
    </Layout>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Layout } from '@admin/layout';

export default defineComponent({
    components: { Layout },
    props: {},
    setup() {
        //
    },
});
</script>
