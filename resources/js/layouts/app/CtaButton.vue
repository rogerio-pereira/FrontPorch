<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Button } from '@/components/ui/button';

const page = usePage();

const props = defineProps<{
    label: string;
    calendarUrl?: string;
    variant?: 'default' | 'outline' | 'link';
    size?: 'default' | 'lg';
    testId?: string;
}>();

const parsed = computed(() => {
    const calendarUrl = props.calendarUrl ?? page.props.site?.calendarUrl ?? '#schedule';
    const anchorMatch = props.label.match(/#([\w-]+)/);
    const text = props.label
        .replace(/\s*→\s*`?#([\w-]+)`?/, '')
        .replace(/`(#([\w-]+))`/, '')
        .replace(/#([\w-]+)/, '')
        .trim();

    if (anchorMatch) {
        return {
            text: text || props.label.trim(),
            href: `#${anchorMatch[1]}`,
            external: false,
        };
    }

    return {
        text: props.label.trim(),
        href: calendarUrl,
        external: calendarUrl.startsWith('http'),
    };
});
</script>

<template>
    <Button
        as-child
        :variant="variant ?? 'default'"
        :size="size ?? 'default'"
    >
        <a
            :href="parsed.href"
            :target="parsed.external ? '_blank' : undefined"
            :rel="parsed.external ? 'noopener noreferrer' : undefined"
            :data-test="testId"
        >
            {{ parsed.text }}
        </a>
    </Button>
</template>
