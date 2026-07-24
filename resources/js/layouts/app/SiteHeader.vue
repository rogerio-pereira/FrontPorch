<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Menu } from '@lucide/vue';
import { ref } from 'vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';

const calendarUrl = '#schedule';

const services = [
    { slug: 'lead-generation', label: 'Lead generation' },
    { slug: 'email-marketing', label: 'Email marketing' },
    { slug: 'website-design-and-development', label: 'Website design & development' },
    { slug: 'business-automations', label: 'Business automations' },
    { slug: 'custom-software-development', label: 'Custom software development' },
];

const mobileOpen = ref(false);

const navItems = [
    { label: 'Portfolio', href: '/portfolio', test: 'nav-portfolio' },
    { label: 'Blog', href: '/blog', test: 'nav-blog' },
    { label: 'Contact', href: '/#contact', test: 'nav-contact' },
];
</script>

<template>
    <header class="sticky top-0 z-50 border-b border-border-subtle bg-brand-bg/95 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <Link href="/" class="flex items-center" data-test="nav-home">
                <img
                    src="/images/branding/logo-horizontal.png"
                    alt="Front Porch Creative"
                    class="h-8 w-auto"
                />
            </Link>

            <nav class="hidden items-center gap-6 lg:flex">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="ghost" data-test="nav-services">
                            Services
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="start">
                        <DropdownMenuItem
                            v-for="service in services"
                            :key="service.slug"
                            as-child
                        >
                            <Link :href="`/services/${service.slug}`" :data-test="`nav-service-${service.slug}`">
                                {{ service.label }}
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>

                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    class="text-sm font-medium text-[var(--text-on-dark)] hover:text-brand-accent"
                    :data-test="item.test"
                >
                    {{ item.label }}
                </Link>

                <CtaButton
                    label="Book a call"
                    :calendar-url="calendarUrl"
                    test-id="nav-schedule"
                />
            </nav>

            <Dialog v-model:open="mobileOpen">
                <DialogTrigger as-child>
                    <Button
                        variant="outline"
                        size="icon"
                        class="lg:hidden"
                        data-test="nav-mobile-menu"
                    >
                        <Menu class="size-5" />
                    </Button>
                </DialogTrigger>
                <DialogContent class="bg-brand-bg text-[var(--text-on-dark)]">
                    <DialogHeader>
                        <DialogTitle>Menu</DialogTitle>
                    </DialogHeader>
                    <nav class="flex flex-col gap-4">
                        <p class="text-overline text-[var(--text-muted-on-dark)]">
                            Services
                        </p>
                        <Link
                            v-for="service in services"
                            :key="service.slug"
                            :href="`/services/${service.slug}`"
                            class="text-sm font-medium"
                            :data-test="`nav-mobile-service-${service.slug}`"
                            @click="mobileOpen = false"
                        >
                            {{ service.label }}
                        </Link>
                        <Link
                            v-for="item in navItems"
                            :key="item.href"
                            :href="item.href"
                            class="text-sm font-medium"
                            :data-test="`nav-mobile-${item.test}`"
                            @click="mobileOpen = false"
                        >
                            {{ item.label }}
                        </Link>
                        <CtaButton
                            label="Book a call"
                            :calendar-url="calendarUrl"
                            test-id="nav-mobile-schedule"
                        />
                    </nav>
                </DialogContent>
            </Dialog>
        </div>
    </header>
</template>
