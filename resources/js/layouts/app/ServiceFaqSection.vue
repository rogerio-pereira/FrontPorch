<script setup lang="ts">
import SectionShell from '@/layouts/app/SectionShell.vue';
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';

defineProps<{
    items: Array<{ question: string; answer: string }>;
}>();
</script>

<template>
    <SectionShell
        v-if="items.length > 0"
        overline="Questions"
        heading="Questions we hear about this service"
        light
        wide
        centered
    >
        <Accordion
            type="single"
            collapsible
            class="mx-auto w-full max-w-3xl rounded-xl border border-border-default bg-white px-2"
            data-test="service-faq"
        >
            <AccordionItem
                v-for="(item, index) in items"
                :key="item.question"
                :value="`service-faq-${index}`"
                class="border-border-default px-4"
            >
                <AccordionTrigger
                    class="text-left text-base font-semibold text-[var(--text-primary-on-light)]"
                    :data-test="`service-faq-trigger-${index}`"
                >
                    {{ item.question }}
                </AccordionTrigger>
                <AccordionContent
                    class="text-[var(--text-muted-on-light)]"
                    :data-test="`service-faq-content-${index}`"
                >
                    {{ item.answer }}
                </AccordionContent>
            </AccordionItem>
        </Accordion>
    </SectionShell>
</template>
