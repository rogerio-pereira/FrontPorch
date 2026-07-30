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
}>();
</script>

<template>
    <SectionShell
        overline="Questions"
        heading="Good questions, happy to answer"
        light
        wide
        centered
    >
        <Accordion
            type="single"
            collapsible
            class="mx-auto w-full max-w-3xl rounded-xl border border-border-default bg-white px-2"
            data-test="home-faq"
        >
            <AccordionItem
                v-for="(faq, index) in faqs"
                :key="faq.question"
                :value="`faq-${index}`"
                class="border-border-default px-4"
            >
                <AccordionTrigger
                    class="text-left text-base font-semibold text-[var(--text-primary-on-light)]"
                    :data-test="`home-faq-trigger-${index}`"
                >
                    {{ faq.question }}
                </AccordionTrigger>
                <AccordionContent
                    class="text-[var(--text-muted-on-light)]"
                    :data-test="`home-faq-content-${index}`"
                >
                    {{ faq.answer }}
                </AccordionContent>
            </AccordionItem>
        </Accordion>
    </SectionShell>
</template>
