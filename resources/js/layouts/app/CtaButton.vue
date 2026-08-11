<script setup lang="ts">
import { computed } from 'vue';
import { Button } from '@/components/ui/button';

const CONTACT_HREF = '/#contact';

const props = defineProps<{
    label: string;
    variant?: 'default' | 'outline' | 'link';
    size?: 'default' | 'lg';
    testId?: string;
}>();

const parsed = computed(() => {
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
        };
    }

    return {
        text: props.label.trim(),
        href: CONTACT_HREF,
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
            :data-test="testId"
        >
            {{ parsed.text }}
        </a>
    </Button>
</template>
