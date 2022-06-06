import { Component } from 'vue';
// import { IconDashboard } from '@macramejs/admin-vue3';

type SidebarNavigationLink = {
    title: string;
    href: string;
    icon?: string|Component;
};

export const sidebarLinks = <SidebarNavigationLink[]>[
//     {
//         title: 'Dashboard',
//         href: '/admin',
//         icon: IconDashboard,
//     },
];
