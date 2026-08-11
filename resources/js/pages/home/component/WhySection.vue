<script setup lang="ts">
import { Handshake, Layers, Sparkles, Target, Workflow } from '@lucide/vue';
import IconBadge from '@/layouts/app/IconBadge.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
</script>

<template>
    <SectionShell
        overline="Why Front Porch"
        heading="We are here to help you grow, not to overwhelm you"
        intro="A lot of agencies sell one piece at a time. We prefer to look at the whole picture, because your business does not run in separate boxes."
        light
        wide
        centered
    >
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
            <article class="flex flex-col items-center rounded-xl border border-border-default bg-white p-5 text-center">
                <IconBadge :icon="Target" />
                <h3 class="mt-4 font-semibold text-[var(--text-primary-on-light)]">
                    Real results
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-light)]">
                    We care about leads, revenue, and time saved, not vanity metrics.
                </p>
            </article>
            <article class="flex flex-col items-center rounded-xl border border-border-default bg-white p-5 text-center">
                <IconBadge :icon="Sparkles" />
                <h3 class="mt-4 font-semibold text-[var(--text-primary-on-light)]">
                    Built for you
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-light)]">
                    Fits how you work, not a template you have to fight against.
                </p>
            </article>
            <article class="flex flex-col items-center rounded-xl border border-border-default bg-white p-5 text-center">
                <IconBadge :icon="Workflow" />
                <h3 class="mt-4 font-semibold text-[var(--text-primary-on-light)]">
                    Less busywork
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-light)]">
                    Smart automations that give you hours back for work you love.
                </p>
            </article>
            <article class="flex flex-col items-center rounded-xl border border-border-default bg-white p-5 text-center">
                <IconBadge :icon="Handshake" />
                <h3 class="mt-4 font-semibold text-[var(--text-primary-on-light)]">
                    A true partner
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-light)]">
                    We stick around, stay clear, and treat your business like it counts.
                </p>
            </article>
            <article class="flex flex-col items-center rounded-xl border border-border-default bg-white p-5 text-center">
                <IconBadge :icon="Layers" />
                <h3 class="mt-4 font-semibold text-[var(--text-primary-on-light)]">
                    One plan
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-light)]">
                    Website, marketing, and tools that support each other.
                </p>
            </article>
        </div>
    </SectionShell>
</template>
