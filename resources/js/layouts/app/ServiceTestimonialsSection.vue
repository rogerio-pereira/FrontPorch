<script setup lang="ts">
import { Quote } from '@lucide/vue';
import SectionShell from '@/layouts/app/SectionShell.vue';

defineProps<{
    testimonials: Array<{ testimonial: string; person: string }>;
    light?: boolean;
}>();
</script>

<template>
    <SectionShell
        v-if="testimonials.length > 0"
        overline="Client stories"
        heading="What people say about this work"
        :light="light"
        wide
        centered
    >
        <div
            class="grid gap-6 md:grid-cols-2"
            data-test="service-testimonials"
        >
            <blockquote
                v-for="(item, index) in testimonials"
                :key="index"
                :class="[
                    light ? 'bg-white' : 'bg-surface-raised',
                    'relative rounded-xl border border-border-default p-8 text-left',
                ]"
                :data-test="`service-testimonial-${index}`"
            >
                <Quote class="mb-4 size-8 text-brand-accent/50" />
                <p
                    :class="[
                        light ? 'text-[var(--text-primary-on-light)]' : 'text-[var(--text-on-dark)]',
                        'text-lg leading-relaxed',
                    ]"
                >
                    "{{ item.testimonial }}"
                </p>
                <footer
                    :class="[
                        light ? 'text-[var(--text-muted-on-light)]' : 'text-[var(--text-muted-on-dark)]',
                        'mt-4 text-sm',
                    ]"
                >
                    - {{ item.person }}
                </footer>
            </blockquote>
        </div>
    </SectionShell>
</template>
