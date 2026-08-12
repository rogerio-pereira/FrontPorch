<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronDown, Menu } from '@lucide/vue';
import { computed, ref } from 'vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import { Button } from '@/components/ui/button';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
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

const page = usePage();

const services = computed(() => page.props.servicesNav);

const mobileOpen = ref(false);
const mobileServicesOpen = ref(false);

const navItems = [
    { label: 'Portfolio', href: '/portfolio', test: 'nav-portfolio' },
    { label: 'Blog', href: '/blog', test: 'nav-blog' },
];
</script>

<template>
    <header class="sticky top-0 z-50 border-b border-border-subtle bg-[#192630]">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <Link href="/" class="flex h-full items-center" data-test="nav-home">
                <img
                    src="/images/branding/logo-horizontal.png"
                    alt="Front Porch Creative"
                    class="h-[95%] w-auto"
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
                                {{ service.title }}
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
                        <Collapsible v-model:open="mobileServicesOpen">
                            <CollapsibleTrigger
                                class="flex w-full items-center justify-between text-sm font-medium"
                                data-test="nav-mobile-services"
                            >
                                Services
                                <ChevronDown
                                    class="size-4 transition-transform duration-200"
                                    :class="{ 'rotate-180': mobileServicesOpen }"
                                />
                            </CollapsibleTrigger>
                            <CollapsibleContent class="mt-3 flex flex-col gap-3 border-l border-border-subtle pl-4">
                                <Link
                                    v-for="service in services"
                                    :key="service.slug"
                                    :href="`/services/${service.slug}`"
                                    class="text-sm font-medium text-[var(--text-muted-on-dark)] hover:text-brand-accent"
                                    :data-test="`nav-mobile-service-${service.slug}`"
                                    @click="mobileOpen = false"
                                >
                                    {{ service.title }}
                                </Link>
                            </CollapsibleContent>
                        </Collapsible>
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
                            test-id="nav-mobile-schedule"
                        />
                    </nav>
                </DialogContent>
            </Dialog>
        </div>
    </header>
</template>
