<script setup lang="ts">
import { Check, ChevronsUpDown, X } from '@lucide/vue';
import {
    ComboboxAnchor,
    ComboboxContent,
    ComboboxEmpty,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxPortal,
    ComboboxRoot,
    ComboboxTrigger,
    ComboboxViewport,
} from 'reka-ui';
import { computed, ref } from 'vue';
import { cn } from '@/lib/utils';

type ServiceOption = {
    slug: string;
    title: string;
};

const props = defineProps<{
    options: ServiceOption[];
}>();

const selectedSlugs = ref<string[]>([]);

const selectedServices = computed(() => {
    return props.options.filter((service) => {
        return selectedSlugs.value.includes(service.slug);
    });
});

function removeService(slug: string): void {
    selectedSlugs.value = selectedSlugs.value.filter((selected) => {
        return selected !== slug;
    });
}
</script>

<template>
    <div class="grid gap-2" data-test="contact-services">
        <input
            v-for="slug in selectedSlugs"
            :key="slug"
            type="hidden"
            name="services[]"
            :value="slug"
        >

        <ComboboxRoot
            v-model="selectedSlugs"
            multiple
            :open-on-click="true"
            :reset-search-term-on-select="true"
            class="w-full"
        >
            <ComboboxAnchor
                :class="cn(
                    'border-input flex min-h-9 w-full flex-wrap items-center gap-1.5 rounded-md border bg-transparent px-3 py-1.5 text-base shadow-xs transition-[color,box-shadow] outline-none md:text-sm',
                    'focus-within:border-ring focus-within:ring-ring/50 focus-within:ring-[3px]',
                )"
            >
                <button
                    v-for="service in selectedServices"
                    :key="service.slug"
                    type="button"
                    class="inline-flex max-w-full items-center gap-1 rounded-md bg-[#e4ece6] px-2 py-0.5 text-xs font-medium text-[var(--text-primary-on-light)]"
                    :data-test="`contact-service-chip-${service.slug}`"
                    @click.stop="removeService(service.slug)"
                >
                    <span class="truncate">{{ service.title }}</span>
                    <X class="size-3 shrink-0 opacity-70" aria-hidden="true" />
                    <span class="sr-only">Remove {{ service.title }}</span>
                </button>

                <ComboboxInput
                    id="contact-services"
                    class="placeholder:text-muted-foreground min-w-[8rem] flex-1 bg-transparent text-base outline-none md:text-sm"
                    placeholder="Search services…"
                    autocomplete="off"
                    data-test="contact-services-input"
                />

                <ComboboxTrigger
                    class="ml-auto inline-flex shrink-0 items-center justify-center text-muted-foreground"
                    data-test="contact-services-trigger"
                >
                    <ChevronsUpDown class="size-4 opacity-50" />
                </ComboboxTrigger>
            </ComboboxAnchor>

            <ComboboxPortal>
                <ComboboxContent
                    position="popper"
                    :side-offset="4"
                    class="bg-popover text-popover-foreground data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 relative z-50 w-[var(--reka-combobox-trigger-width)] min-w-[var(--reka-combobox-trigger-width)] overflow-hidden rounded-md border shadow-md"
                    data-test="contact-services-content"
                >
                    <ComboboxViewport class="max-h-60 p-1">
                        <ComboboxEmpty class="py-4 text-center text-sm text-muted-foreground">
                            No service found.
                        </ComboboxEmpty>

                        <ComboboxItem
                            v-for="service in options"
                            :key="service.slug"
                            :value="service.slug"
                            :text-value="service.title"
                            :class="cn(
                                'relative flex w-full cursor-default items-center gap-2 rounded-sm py-1.5 pr-8 pl-2 text-sm outline-hidden select-none',
                                'data-[highlighted]:bg-accent data-[highlighted]:text-accent-foreground',
                                'data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
                            )"
                            :data-test="`contact-service-option-${service.slug}`"
                        >
                            <span>{{ service.title }}</span>
                            <span class="absolute right-2 flex size-3.5 items-center justify-center">
                                <ComboboxItemIndicator>
                                    <Check class="size-4" />
                                </ComboboxItemIndicator>
                            </span>
                        </ComboboxItem>
                    </ComboboxViewport>
                </ComboboxContent>
            </ComboboxPortal>
        </ComboboxRoot>
    </div>
</template>
