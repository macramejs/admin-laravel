import { useForm } from '@macramejs/macrame-vue3';
import { NavItem } from '@admin/types/resources';
import { NavItemForm } from '@admin/types/forms';
import { Inertia } from '@inertiajs/inertia';

export const useNavItemForm = (type: string, options): NavItemForm => {
    const form = useForm<NavItem>({
        route: `/admin/nav/${type}`,
        data: {
            title: '',
            link: '',
        },
        method: 'post',
        ...options,
    });

    return form;
};

export const deleteNavItem = (type, item) => {
    Inertia.delete(`/admin/nav/${type}/${item.id}`);
};
