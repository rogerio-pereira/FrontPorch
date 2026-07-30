<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    Briefcase,
    LayoutGrid,
    MessageSquareQuote,
    Newspaper,
    Sparkles,
    Users,
} from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarSeparator,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const crmNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Services',
        href: '/core/services',
        icon: Sparkles,
        separatorBefore: true,
    },
    {
        title: 'FAQs',
        href: '/core/faqs',
        icon: BookOpen,
    },
    {
        title: 'Testimonials',
        href: '/core/testimonials',
        icon: MessageSquareQuote,
    },
    {
        title: 'Case studies',
        href: '/core/case-studies',
        icon: Briefcase,
    },
];

const blogNavItems: NavItem[] = [
    {
        title: 'Blog',
        href: '/core/blog/articles',
        icon: Newspaper,
    },
];

const systemNavItems: NavItem[] = [
    {
        title: 'Users',
        href: '/core/users',
        icon: Users,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent class="overflow-x-hidden overflow-y-auto">
            <NavMain label="CRM" :items="crmNavItems" />
            <SidebarSeparator class="my-2" />
            <NavMain label="Blog" :items="blogNavItems" />
            <SidebarSeparator class="my-2" />
            <NavMain label="System" :items="systemNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
