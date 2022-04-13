import { useForm } from '@macramejs/macrame-vue3';
import { NavItem, NavItemForm } from '@admin/types/forms';

export const useNavItemForm  = (type: string, options): NavItemForm => {
    const form = useForm<NavItem>({
        route: `/admin/nav/${type}`,
        data: {
            title: '',
            route: '',
        },
        method: 'post',
        ...options,
    });

    return form;
}