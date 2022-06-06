import { Component } from 'vue';

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
