<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const contactEmail = computed(() => page.props.site.footerContactEmail ?? 'contact@example.com');
</script>

<template>
    <footer class="border-t border-border-subtle bg-brand-bg py-12 text-[var(--text-on-dark)]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
                <div class="stack-default max-w-sm">
                    <img
                        src="/images/branding/logo-vertical.png"
                        alt="Front Porch Creative"
                        class="h-24 w-auto"
                    />
                    <p class="text-sm text-[var(--text-muted-on-dark)]">
                        Marketing and technology for small businesses in Central Florida.
                    </p>
                </div>

                <div class="grid gap-8 sm:grid-cols-2">
                    <div class="stack-default">
                        <p class="text-overline text-[var(--text-muted-on-dark)]">
                            Explore
                        </p>
                        <Link href="/portfolio" class="text-sm hover:text-brand-accent" data-test="footer-portfolio">
                            Portfolio
                        </Link>
                        <Link href="/blog" class="text-sm hover:text-brand-accent" data-test="footer-blog">
                            Blog
                        </Link>
                        <Link href="/#contact" class="text-sm hover:text-brand-accent" data-test="footer-contact">
                            Contact
                        </Link>
                    </div>
                    <div class="stack-default">
                        <p class="text-overline text-[var(--text-muted-on-dark)]">
                            Contact
                        </p>
                        <a
                            :href="`mailto:${contactEmail}`"
                            class="text-sm hover:text-brand-accent"
                            data-test="footer-email"
                        >
                            {{ contactEmail }}
                        </a>
                        <p class="text-sm text-[var(--text-muted-on-dark)]">
                            Plant City, Florida · Central Florida service area
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
