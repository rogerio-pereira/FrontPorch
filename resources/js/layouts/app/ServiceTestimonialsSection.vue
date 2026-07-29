<script setup lang="ts">
import { Quote } from '@lucide/vue';
import SectionShell from '@/layouts/app/SectionShell.vue';

defineProps<{
    quotes: Array<{ quote: string; attribution: string }>;
}>();
</script>

<template>
    <SectionShell
        v-if="quotes.length > 0"
        overline="Client stories"
        heading="What people say about this work"
        wide
        centered
    >
        <div
            class="grid gap-6 md:grid-cols-2"
            data-test="service-testimonials"
        >
            <blockquote
                v-for="(item, index) in quotes"
                :key="index"
                class="relative rounded-xl border border-border-default bg-surface-raised p-8 text-left"
                :data-test="`service-testimonial-${index}`"
            >
                <Quote class="mb-4 size-8 text-brand-accent/50" />
                <p class="text-lg leading-relaxed">
                    "{{ item.quote }}"
                </p>
                <footer class="mt-4 text-sm text-[var(--text-muted-on-dark)]">
                    - {{ item.attribution }}
                </footer>
            </blockquote>
        </div>
    </SectionShell>
</template>
