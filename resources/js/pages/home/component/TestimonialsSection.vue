<script setup lang="ts">
import { Quote } from '@lucide/vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
defineProps<{
    // TODO: remove demo testimonials in HomeController once real quotes are stored
    quotes: Array<{ quote: string; attribution: string }>;
}>();
</script>

<template>
    <SectionShell
        overline="Client stories"
        heading="Real stories on the way"
        intro="We are just getting started collecting client stories. Until then, here is what we aim for in every engagement."
        light
        wide
        centered
    >
        <div class="grid gap-6 md:grid-cols-2">
            <blockquote
                v-for="(item, index) in quotes"
                :key="index"
                class="relative rounded-xl border border-border-default bg-white p-8 text-left"
            >
                <Quote class="mb-4 size-8 text-brand-accent/50" />
                <p class="text-lg leading-relaxed text-[var(--text-primary-on-light)]">
                    "{{ item.quote }}"
                </p>
                <footer class="mt-4 text-sm text-[var(--text-muted-on-light)]">
                    - {{ item.attribution }}
                </footer>
            </blockquote>
        </div>
        <p class="mt-8 text-center text-sm text-[var(--text-muted-on-light)]">
            Named testimonials will appear here as projects wrap up.
        </p>
    </SectionShell>
</template>
