<script setup lang="ts">
import { Handshake, Layers, Sparkles, Target, Workflow } from '@lucide/vue';
import IconBadge from '@/layouts/app/IconBadge.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';

const icons = [Target, Sparkles, Workflow, Handshake, Layers];

const bullets = [
    {
        title: 'Real results',
        description: 'We care about leads, revenue, and time saved, not vanity metrics.',
    },
    {
        title: 'Built for you',
        description: 'Fits how you work, not a template you have to fight against.',
    },
    {
        title: 'Less busywork',
        description: 'Smart automations that give you hours back for work you love.',
    },
    {
        title: 'A true partner',
        description: 'We stick around, stay clear, and treat your business like it counts.',
    },
    {
        title: 'One plan',
        description: 'Website, marketing, and tools that support each other.',
    },
];
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
            <article
                v-for="(bullet, index) in bullets"
                :key="bullet.title"
                class="flex flex-col items-center rounded-xl border border-border-default bg-white p-5 text-center"
            >
                <IconBadge :icon="icons[index] ?? Target" />
                <h3 class="mt-4 font-semibold text-[var(--text-primary-on-light)]">
                    {{ bullet.title }}
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-light)]">
                    {{ bullet.description }}
                </p>
            </article>
        </div>
    </SectionShell>
</template>
