import { Inertia } from '@inertiajs/inertia';
import { Page } from '@admin/types/resources';

export const deletePage = async (page: Page) => {
    Inertia.delete(`/admin/pages/${page.id}`);
};
