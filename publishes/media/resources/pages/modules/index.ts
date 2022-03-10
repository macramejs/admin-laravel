import { useIndex, Index } from '@macramejs/macrame-vue3';
import { File } from '@admin/modules/resources';
import { reactive, ref, watch } from 'vue'
import axios from 'axios'

export type FileIndex = Index<File>;

export const index = useIndex<File>({
    route: '/admin/files/items',
    syncUrl: true,
    sortBy: [],
    filters: {
        collection: {
            update(collection) {
                index.filters.collection.value = collection 
                    ? collection.key 
                    : null;
            },
            value: null
        },
        types: {
            toggle(type) {
                let i = index.filters.types.value.indexOf(type);
                if (i !== -1) {
                    index.filters.types.value.splice(i, 1);
                } else {
                    index.filters.types.value.push(type);
                }
            },
            value: []
        }
    }
});

index.reloadOnChange(index.filters);

export const selectedFiles = ref<File[]>([]);