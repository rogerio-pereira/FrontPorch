<script setup lang="ts">
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';
</script>

<template>
    <SectionShell
        overline="Who we are"
        heading="Glad you pulled up a chair"
        wide
    >
        <template #background>
            <DecorativeBackground variant="glow" />
        </template>

        <div class="grid items-center gap-10 lg:grid-cols-2">
            <VisualFrame
                src="/images/home/founders.png"
                alt="Rogerio and Sarah, founders of Front Porch Creative"
                aspect="portrait"
                data-test="home-about-photo"
            />
            <div class="stack-default">
                <p class="text-body-lg text-[var(--text-muted-on-dark)]">
                    Hi, we are Rogerio and Sarah, founders of Front Porch Creative, based in Plant City. Rogerio handles the technical side and development, more than fifteen years of it. Sarah looks after clients and the creative work. We started this for local small and mid-size businesses: the owners who want real help, not a big agency that feels out of reach.
                </p>
                <p class="text-body-lg text-[var(--text-muted-on-dark)]">
                    Around here, a lot of marketing shops feel built for big projects and distant brands. We care about the opposite, people looking after other people’s brands, one conversation at a time. The kind of working relationship where it starts to feel like you are talking with friends, not vendors who only care about closing a deal.
                </p>
                <p class="text-body-lg text-[var(--text-muted-on-dark)]">
                    We are not interested in pretty words and thin results, or in making you feel like one more ticket that gets delivered and forgotten. We would rather stay in touch, keep showing up, and grow with you.
                </p>
                <p class="text-sm text-brand-accent">
                    Rogerio and Sarah, Plant City, Florida.
                </p>
            </div>
        </div>
    </SectionShell>
</template>
