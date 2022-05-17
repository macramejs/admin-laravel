import { useIndex, Index } from "@macramejs/macrame-vue3";
import { Media } from "@admin/types/resources";
import { get, post } from "../request";
export { default as MediaUpload } from './MediaUpload.vue';

export type MediaIndex = Index<Media>;

export const useMediaIndex = () => {
    const index = useIndex<Media>({
        route: "/admin/media/items",
        syncUrl: true,
        sortBy: [],
        filters: {
            collection: {
                update(collection) {
                    index.filters.collection.value = collection
                        ? collection.key
                        : null;
                },
                value: null,
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
                value: [],
            },
        },
    });

    index.reloadOnChange(index.filters);

    return index;
};

export const mediaIndex = useMediaIndex();

export const getMediaById = async (id: number) => {
    const { data } = await (await get(`/admin/media/items/${id}`)).json();

    return <Media>data;
};

export const deleteFile = async (file: Media) => {
    await post(`/admin/media/delete/`, {
        body: {
            ids: [file.id],
        },
    });

    mediaIndex.reload();
};
