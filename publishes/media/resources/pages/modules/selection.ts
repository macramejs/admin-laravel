import { {{ page }}, {{ page }}Collection } from '@admin/types';
import { Inertia } from '@inertiajs/inertia';
import { reactive, ref, watch } from 'vue'
import { post } from '@admin/modules/request';

interface Selection {
    files: {{ page }}[],
    addToCollection: (collection: {{ page }}Collection) => void,
    delete: () => void
}

const selection = reactive<Selection>({
    files: [],
    addToCollection(collection) {
        if(this.files.length == 0) {
            return;
        }

        return Inertia.post(`/{{ app }}/{{ route }}/${collection.id}/add`, { 
            ids: this.files.map((file) => file.id)
        });
    },
    delete() {
        return Inertia.post(`/{{ app }}/{{ route }}/delete`, { 
            ids: this.files.map((file) => file.id)
        });
    }
});

export { selection };