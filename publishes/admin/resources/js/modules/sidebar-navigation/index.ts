import { IconDashboard } from '@macramejs/admin-vue3';

type SidebarNavigationLink = {
    title: string;
    href: string;
    icon?: string;
};

export const sidebarLinks = <SidebarNavigationLink[]>[
    {
        title: 'Dashboard',
        href: '/admin',
        icon: IconDashboard,
    },
];
