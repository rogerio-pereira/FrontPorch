<script setup lang="ts">
import { computed, ref } from 'vue';
import { ChevronLeft, ChevronRight } from '@lucide/vue';

export interface StudyCaseSolutionImage {
    src: string;
    alt: string;
}

const props = defineProps<{
    images: StudyCaseSolutionImage[];
}>();

const activeIndex = ref(0);

const activeImage = computed(() => props.images[activeIndex.value]);

const canNavigate = computed(() => props.images.length > 1);

function goTo(index: number): void {
    if (index < 0 || index >= props.images.length) {
        return;
    }

    activeIndex.value = index;
}

function previous(): void {
    if (activeIndex.value === 0) {
        activeIndex.value = props.images.length - 1;

        return;
    }

    activeIndex.value -= 1;
}

function next(): void {
    if (activeIndex.value === props.images.length - 1) {
        activeIndex.value = 0;

        return;
    }

    activeIndex.value += 1;
}
</script>

<template>
    <div
        v-if="images.length > 0"
        class="stack-default"
        data-test="study-case-carousel"
    >
        <div class="relative overflow-hidden rounded-xl border border-brand-accent/25 bg-surface-raised shadow-[0_0_60px_rgba(114,136,123,0.12)]">
            <div class="aspect-video">
                <img
                    :src="activeImage.src"
                    :alt="activeImage.alt"
                    class="size-full object-cover"
                    data-test="study-case-carousel-image"
                />
            </div>

            <template v-if="canNavigate">
                <button
                    type="button"
                    class="absolute top-1/2 left-3 flex size-10 -translate-y-1/2 items-center justify-center rounded-full border border-brand-accent/40 bg-brand-bg/80 text-[var(--text-on-dark)] backdrop-blur-sm transition hover:bg-brand-accent/20"
                    aria-label="Previous image"
                    data-test="study-case-carousel-prev"
                    @click="previous"
                >
                    <ChevronLeft class="size-5" />
                </button>
                <button
                    type="button"
                    class="absolute top-1/2 right-3 flex size-10 -translate-y-1/2 items-center justify-center rounded-full border border-brand-accent/40 bg-brand-bg/80 text-[var(--text-on-dark)] backdrop-blur-sm transition hover:bg-brand-accent/20"
                    aria-label="Next image"
                    data-test="study-case-carousel-next"
                    @click="next"
                >
                    <ChevronRight class="size-5" />
                </button>
            </template>
        </div>

        <div
            v-if="canNavigate"
            class="flex items-center justify-center gap-2"
        >
            <button
                v-for="(image, index) in images"
                :key="`${image.src}-${index}`"
                type="button"
                class="size-2.5 rounded-full transition"
                :class="
                    index === activeIndex
                        ? 'bg-brand-accent'
                        : 'bg-brand-accent/30 hover:bg-brand-accent/50'
                "
                :aria-label="`Show image ${index + 1}`"
                :aria-current="index === activeIndex ? 'true' : undefined"
                :data-test="`study-case-carousel-dot-${index}`"
                @click="goTo(index)"
            />
        </div>
    </div>
</template>
