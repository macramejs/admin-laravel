import { useIndex, Index } from "@macramejs/macrame-vue3"
import { {{ page }} } from '@{{ app }}/types/resources';
import { get } from "../request";

export type {{ page }}Index = Index<{{ page }}>;

export const use{{ page }}Index = () => {
    const index = useIndex<{{ page }}>({
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

export const {{ name }}Index = use{{ page }}Index();

export const get{{ page }}ById = async (id: number) => {
    const { data } = await (await get(`/{{ app }}/{{ route }}/items/${id}`)).json();

    return <{{ page }}>data;
}