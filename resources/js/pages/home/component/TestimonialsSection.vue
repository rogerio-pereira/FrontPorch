<script setup lang="ts">
import { Quote } from '@lucide/vue';
import SectionShell from '@/layouts/app/SectionShell.vue';

defineProps<{
    testimonials: Array<{ testimonial: string; person: string }>;
}>();
</script>

<template>
    <SectionShell
        v-if="testimonials.length > 0"
        overline="Client stories"
        heading="What people say about working with us"
        light
        wide
        centered
    >
        <div
            class="grid gap-6 md:grid-cols-2"
            data-test="home-testimonials"
        >
            <blockquote
                v-for="(item, index) in testimonials"
                :key="index"
                class="relative rounded-xl border border-border-default bg-white p-8 text-left"
                :data-test="`home-testimonial-${index}`"
            >
                <Quote class="mb-4 size-8 text-brand-accent/50" />
                <p class="text-lg leading-relaxed text-[var(--text-primary-on-light)]">
                    "{{ item.testimonial }}"
                </p>
                <footer class="mt-4 text-sm text-[var(--text-muted-on-light)]">
                    - {{ item.person }}
                </footer>
            </blockquote>
        </div>
    </SectionShell>
</template>
