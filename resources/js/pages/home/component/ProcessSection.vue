<script setup lang="ts">
import SectionShell from '@/layouts/app/SectionShell.vue';
</script>

<template>
    <SectionShell
        overline="How it works"
        heading="Simple steps, no mystery"
        wide
        centered
    >
        <div class="grid gap-4 lg:grid-cols-5">
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-center">
                <div class="mx-auto mb-4 flex size-12 items-center justify-center rounded-full bg-brand-accent text-lg font-bold text-brand-bg">
                    1
                </div>
                <h3 class="font-semibold">
                    Discovery call
                </h3>
                <p class="mt-2 line-clamp-4 text-sm text-[var(--text-muted-on-dark)]">
                    We learn your business, what is working, what is not, and what you want to change.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-center">
                <div class="mx-auto mb-4 flex size-12 items-center justify-center rounded-full bg-brand-accent text-lg font-bold text-brand-bg">
                    2
                </div>
                <h3 class="font-semibold">
                    A clear plan
                </h3>
                <p class="mt-2 line-clamp-4 text-sm text-[var(--text-muted-on-dark)]">
                    A clear proposal covering what we will do, when, and how we will know it works.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-center">
                <div class="mx-auto mb-4 flex size-12 items-center justify-center rounded-full bg-brand-accent text-lg font-bold text-brand-bg">
                    3
                </div>
                <h3 class="font-semibold">
                    Build & launch
                </h3>
                <p class="mt-2 line-clamp-4 text-sm text-[var(--text-muted-on-dark)]">
                    We create, connect, and launch, checking in so nothing feels like a black box.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-center">
                <div class="mx-auto mb-4 flex size-12 items-center justify-center rounded-full bg-brand-accent text-lg font-bold text-brand-bg">
                    4
                </div>
                <h3 class="font-semibold">
                    See what works
                </h3>
                <p class="mt-2 line-clamp-4 text-sm text-[var(--text-muted-on-dark)]">
                    We look at real numbers together and adjust when something needs a tweak.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-center">
                <div class="mx-auto mb-4 flex size-12 items-center justify-center rounded-full bg-brand-accent text-lg font-bold text-brand-bg">
                    5
                </div>
                <h3 class="font-semibold">
                    Keep growing
                </h3>
                <p class="mt-2 line-clamp-4 text-sm text-[var(--text-muted-on-dark)]">
                    As your business changes, we stay available to help you adapt and expand.
                </p>
            </article>
        </div>
    </SectionShell>
</template>
