import { Inertia } from '@inertiajs/inertia';
import { Page } from '@admin/types/resources';
import { del } from '../request';

export const deletePage = async (page: Page) => {
    await del(`/admin/pages/${page.id}`);

    Inertia.visit(`/admin/pages`);
};
