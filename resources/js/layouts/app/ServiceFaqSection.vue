<script setup lang="ts">
import SectionShell from '@/layouts/app/SectionShell.vue';
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';

defineProps<{
    faqs: Array<{ question: string; answer: string }>;
    light?: boolean;
}>();
</script>

<template>
    <SectionShell
        v-if="faqs.length > 0"
        overline="Questions"
        heading="Questions we hear about this service"
        :light="light"
        wide
        centered
    >
        <Accordion
            type="single"
            collapsible
            :class="[
                light ? 'bg-white' : 'bg-surface-raised',
                'mx-auto w-full max-w-3xl rounded-xl border border-border-default px-2',
            ]"
            data-test="service-faq"
        >
            <AccordionItem
                v-for="(faq, index) in faqs"
                :key="faq.question"
                :value="`service-faq-${index}`"
                class="border-border-default px-4"
            >
                <AccordionTrigger
                    :class="[
                        light ? 'text-[var(--text-primary-on-light)]' : 'text-[var(--text-on-dark)]',
                        'text-left text-base font-semibold',
                    ]"
                    :data-test="`service-faq-trigger-${index}`"
                >
                    {{ faq.question }}
                </AccordionTrigger>
                <AccordionContent
                    :class="[
                        light ? 'text-[var(--text-muted-on-light)]' : 'text-[var(--text-muted-on-dark)]',
                        'text-base leading-relaxed',
                    ]"
                    :data-test="`service-faq-content-${index}`"
                >
                    {{ faq.answer }}
                </AccordionContent>
            </AccordionItem>
        </Accordion>
    </SectionShell>
</template>
