<script setup lang="ts">
defineProps<{
    overline?: string;
    heading: string;
    intro?: string;
    light?: boolean;
    tight?: boolean;
    id?: string;
    wide?: boolean;
    centered?: boolean;
}>();
</script>

<template>
    <section
        :id="id"
        :class="[
            light ? 'bg-[var(--section-light-bg)] text-[var(--text-primary-on-light)]' : 'bg-brand-bg text-[var(--text-on-dark)]',
            tight ? 'section-y-tight' : 'section-y',
            'relative overflow-hidden',
        ]"
    >
        <slot name="background" />
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                :class="[
                    wide ? 'max-w-7xl' : 'max-w-3xl',
                    centered ? 'mx-auto text-center' : '',
                    'stack-default',
                ]"
            >
                <p
                    v-if="overline"
                    class="text-overline"
                    :class="light ? 'text-[var(--text-muted-on-light)]' : 'text-[var(--text-muted-on-dark)]'"
                >
                    {{ overline }}
                </p>
                <h2 class="text-h2 font-semibold">
                    {{ heading }}
                </h2>
                <p
                    v-if="intro"
                    class="text-body-lg"
                    :class="[
                        light ? 'text-[var(--text-muted-on-light)]' : 'text-[var(--text-muted-on-dark)]',
                        centered ? 'mx-auto max-w-2xl' : '',
                    ]"
                >
                    {{ intro }}
                </p>
            </div>
            <div :class="[wide ? 'mt-10' : 'mx-auto mt-10 max-w-3xl']">
                <slot />
            </div>
        </div>
    </section>
</template>
