import { Inertia } from '@inertiajs/inertia';
import { Page } from '@admin/types/resources';

export const deletePage = async (page: Page) => {
    if (confirm(`Are you sure you want to delete Page ${page.name}?`)) {
        Inertia.delete(`/admin/pages/${page.id}`);
    }
};
