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

type MultiSelectComboboxOption = {
    value: string;
    label: string;
    key?: string;
};

const props = withDefaults(
    defineProps<{
        options: MultiSelectComboboxOption[];
        name: string;
        inputId: string;
        placeholder?: string;
        emptyText?: string;
        dataTest?: string;
    }>(),
    {
        placeholder: 'Search…',
        emptyText: 'No results found.',
        dataTest: 'multi-select-combobox',
    },
);

const selectedValues = ref<string[]>([]);

const selectedOptions = computed(() => {
    return props.options.filter((option) => {
        return selectedValues.value.includes(option.value);
    });
});

function optionKey(option: MultiSelectComboboxOption): string {
    if (option.key !== undefined && option.key !== '') {
        return option.key;
    }

    return option.value;
}

function removeValue(value: string): void {
    selectedValues.value = selectedValues.value.filter((selected) => {
        return selected !== value;
    });
}
</script>

<template>
    <div class="grid gap-2" :data-test="dataTest">
        <input
            v-for="value in selectedValues"
            :key="value"
            type="hidden"
            :name="`${name}[]`"
            :value="value"
        >

        <ComboboxRoot
            v-model="selectedValues"
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
                    v-for="option in selectedOptions"
                    :key="optionKey(option)"
                    type="button"
                    class="inline-flex max-w-full items-center gap-1 rounded-md bg-[#e4ece6] px-2 py-0.5 text-xs font-medium text-[var(--text-primary-on-light)]"
                    :data-test="`${dataTest}-chip-${optionKey(option)}`"
                    @click.stop="removeValue(option.value)"
                >
                    <span class="truncate">{{ option.label }}</span>
                    <X class="size-3 shrink-0 opacity-70" aria-hidden="true" />
                    <span class="sr-only">Remove {{ option.label }}</span>
                </button>

                <ComboboxInput
                    :id="inputId"
                    class="placeholder:text-muted-foreground min-w-[8rem] flex-1 bg-transparent text-base outline-none md:text-sm"
                    :placeholder="placeholder"
                    autocomplete="off"
                    :data-test="`${dataTest}-input`"
                />

                <ComboboxTrigger
                    class="ml-auto inline-flex shrink-0 items-center justify-center text-muted-foreground"
                    :data-test="`${dataTest}-trigger`"
                >
                    <ChevronsUpDown class="size-4 opacity-50" />
                </ComboboxTrigger>
            </ComboboxAnchor>

            <ComboboxPortal>
                <ComboboxContent
                    position="popper"
                    :side-offset="4"
                    class="bg-popover text-popover-foreground data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 relative z-50 w-[var(--reka-combobox-trigger-width)] min-w-[var(--reka-combobox-trigger-width)] overflow-hidden rounded-md border shadow-md"
                    :data-test="`${dataTest}-content`"
                >
                    <ComboboxViewport class="max-h-60 p-1">
                        <ComboboxEmpty class="py-4 text-center text-sm text-muted-foreground">
                            {{ emptyText }}
                        </ComboboxEmpty>

                        <ComboboxItem
                            v-for="option in options"
                            :key="optionKey(option)"
                            :value="option.value"
                            :text-value="option.label"
                            :class="cn(
                                'relative flex w-full cursor-default items-center gap-2 rounded-sm py-1.5 pr-8 pl-2 text-sm outline-hidden select-none',
                                'data-[highlighted]:bg-accent data-[highlighted]:text-accent-foreground',
                                'data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
                            )"
                            :data-test="`${dataTest}-option-${optionKey(option)}`"
                        >
                            <span>{{ option.label }}</span>
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
