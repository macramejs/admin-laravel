import { useIndex, Index } from "@macramejs/macrame-vue3"
import { {{ model }} } from '@{{ app }}/types/resources';

export type {{ model }}Index = Index<{{ model }}>;

export const use{{ model }}Index = () => {
    const index = useIndex<{{ model }}>({
        route: '/{{ app }}/{{ route }}/items',
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

    return index;
}

export const {{ name }}Index = use{{ model }}Index();