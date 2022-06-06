import { Media, MediaCollection } from '@admin/types';
import { Inertia } from '@inertiajs/inertia';
import { reactive } from 'vue';
import { mediaIndex } from '@admin/modules/media';

export interface Selection {
    files: Media[];
    addToCollection: (collection: MediaCollection) => void;
    delete: () => void;
}

const useSelection = function (files: Media[]) {
    const sel = reactive<Selection>({
        files,
        addToCollection() {},
        delete() {},
    });

    sel.addToCollection = collection => {
        if (sel.files.length == 0) {
            return;
        }

        return Inertia.post(
            `/admin/media/${collection.id}/add`,
            {
                ids: sel.files.map(file => file.id),
            },
            {
                onSuccess() {
                    sel.files = [];
                },
            }
        );
    };

    sel.delete = () => {
        return Inertia.post(
            `/admin/media/delete`,
            {
                ids: sel.files.map(file => file.id),
            },
            {
                onSuccess() {
                    mediaIndex.reload();
                },
            }
        );
    };

    return sel;
};

const selection = useSelection([]);

export { selection, useSelection };
