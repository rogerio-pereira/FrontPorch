<script setup lang="ts">
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import Placeholder from '@tiptap/extension-placeholder';
import StarterKit from '@tiptap/starter-kit';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import { TableKit } from '@tiptap/extension-table';
import TaskItem from '@tiptap/extension-task-item';
import TaskList from '@tiptap/extension-task-list';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import { EditorContent, useEditor } from '@tiptap/vue-3';
import {
    AlignCenter,
    AlignJustify,
    AlignLeft,
    AlignRight,
    Bold,
    ChevronDown,
    Code,
    CodeXml,
    FileCode2,
    Heading,
    Image as ImageIcon,
    Italic,
    Link as LinkIcon,
    List,
    ListOrdered,
    ListTodo,
    Minus,
    Quote,
    SquareCode,
    Strikethrough,
    Subscript as SubscriptIcon,
    Superscript as SuperscriptIcon,
    Table,
    Underline as UnderlineIcon,
} from '@lucide/vue';
import { computed, nextTick, onMounted, ref, watch } from 'vue';
import { toast } from 'vue-sonner';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Label } from '@/components/ui/label';
import { getXsrfToken } from '@/lib/xsrf';

type HeadingLevel = 1 | 2 | 3 | 4 | 5 | 6;
type TextAlignment = 'left' | 'center' | 'right' | 'justify';

const props = withDefaults(
    defineProps<{
        id?: string;
        name?: string;
        defaultValue?: string;
        directory: 'blog' | 'case-studies';
        required?: boolean;
        placeholder?: string;
    }>(),
    {
        id: undefined,
        name: 'content',
        defaultValue: '',
        required: false,
        placeholder: 'Write the article body…',
    },
);

const hiddenInput = ref<HTMLInputElement | null>(null);
const imageInput = ref<HTMLInputElement | null>(null);
const uploading = ref(false);
const linkDialogOpen = ref(false);
const linkUrl = ref('');
const htmlMode = ref(false);
const htmlSource = ref('');
const tableMenuOpen = ref(false);
const tableHoverRows = ref(0);
const tableHoverCols = ref(0);

const headingLevels: HeadingLevel[] = [1, 2, 3, 4, 5, 6];
const tableMaxRows = 10;
const tableMaxCols = 10;

const editor = useEditor({
    extensions: [
        StarterKit.configure({
            heading: {
                levels: headingLevels,
            },
        }),
        Underline,
        Subscript,
        Superscript,
        Link.configure({
            openOnClick: false,
            HTMLAttributes: {
                rel: 'noopener noreferrer',
                target: '_blank',
            },
        }),
        Image.configure({
            allowBase64: false,
        }),
        TaskList,
        TaskItem.configure({
            nested: true,
        }),
        TableKit.configure({
            table: {
                resizable: true,
            },
        }),
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
        Placeholder.configure({
            placeholder: props.placeholder,
        }),
    ],
    content: props.defaultValue,
    editorProps: {
        attributes: {
            class: 'rich-text-editor-prose px-3 py-2 outline-none',
            'data-test': 'rich-text-editor-content',
        },
    },
    onUpdate: () => {
        void nextTick(() => {
            syncHiddenInput();
        });
    },
    onCreate: () => {
        void nextTick(() => {
            syncHiddenInput();
        });
    },
});

const editorReady = computed(() => {
    return editor.value !== undefined && editor.value !== null;
});

const visualModeEnabled = computed(() => {
    return editorReady.value && !htmlMode.value;
});

const activeHeadingLabel = computed(() => {
    for (const level of headingLevels) {
        if (isActive('heading', { level })) {
            return `H${level}`;
        }
    }

    return 'Heading';
});

watch(
    () => props.defaultValue,
    (value) => {
        if (!editorReady.value) {
            return;
        }

        if (htmlMode.value) {
            htmlSource.value = value ?? '';
            syncHiddenInput();

            return;
        }

        const current = editor.value!.getHTML();

        if (value === current) {
            return;
        }

        if (value === '' && editor.value!.isEmpty) {
            return;
        }

        editor.value!.commands.setContent(value ?? '', {
            emitUpdate: false,
        });
        syncHiddenInput();
    },
);

onMounted(() => {
    syncHiddenInput();
});

function syncHiddenInput(): void {
    if (hiddenInput.value === null) {
        return;
    }

    if (htmlMode.value) {
        hiddenInput.value.value = htmlSource.value.trim();

        return;
    }

    if (!editorReady.value) {
        return;
    }

    if (editor.value!.isEmpty) {
        hiddenInput.value.value = '';

        return;
    }

    hiddenInput.value.value = editor.value!.getHTML();
}

function isActive(name: string, attributes: Record<string, unknown> = {}): boolean {
    if (!editorReady.value) {
        return false;
    }

    return editor.value!.isActive(name, attributes);
}

function toolbarButtonClass(active: boolean): string {
    if (active) {
        return 'bg-brand-accent/15 text-brand-accent';
    }

    return '';
}

function toggleBold(): void {
    editor.value?.chain().focus().toggleBold().run();
}

function toggleItalic(): void {
    editor.value?.chain().focus().toggleItalic().run();
}

function toggleUnderline(): void {
    editor.value?.chain().focus().toggleUnderline().run();
}

function toggleStrike(): void {
    editor.value?.chain().focus().toggleStrike().run();
}

function toggleHeading(level: HeadingLevel): void {
    editor.value?.chain().focus().toggleHeading({ level }).run();
}

function setParagraph(): void {
    editor.value?.chain().focus().setParagraph().run();
}

function toggleBulletList(): void {
    editor.value?.chain().focus().toggleBulletList().run();
}

function toggleOrderedList(): void {
    editor.value?.chain().focus().toggleOrderedList().run();
}

function toggleTaskList(): void {
    editor.value?.chain().focus().toggleTaskList().run();
}

function toggleBlockquote(): void {
    editor.value?.chain().focus().toggleBlockquote().run();
}

function toggleCode(): void {
    editor.value?.chain().focus().toggleCode().run();
}

function toggleCodeBlock(): void {
    editor.value?.chain().focus().toggleCodeBlock().run();
}

function toggleSubscript(): void {
    editor.value?.chain().focus().toggleSubscript().run();
}

function toggleSuperscript(): void {
    editor.value?.chain().focus().toggleSuperscript().run();
}

function setAlignment(alignment: TextAlignment): void {
    editor.value?.chain().focus().setTextAlign(alignment).run();
}

function insertHorizontalRule(): void {
    editor.value?.chain().focus().setHorizontalRule().run();
}

function insertTable(rows: number, cols: number): void {
    if (rows < 1 || cols < 1) {
        return;
    }

    editor.value
        ?.chain()
        .focus()
        .insertTable({
            rows,
            cols,
            withHeaderRow: true,
        })
        .run();

    tableMenuOpen.value = false;
    tableHoverRows.value = 0;
    tableHoverCols.value = 0;
}

function onTableCellHover(rows: number, cols: number): void {
    tableHoverRows.value = rows;
    tableHoverCols.value = cols;
}

function resetTableHover(): void {
    tableHoverRows.value = 0;
    tableHoverCols.value = 0;
}

function isTableCellSelected(row: number, col: number): boolean {
    return row <= tableHoverRows.value && col <= tableHoverCols.value;
}

const tableSizeLabel = computed(() => {
    if (tableHoverRows.value < 1 || tableHoverCols.value < 1) {
        return 'Insert table';
    }

    return `${tableHoverRows.value} × ${tableHoverCols.value}`;
});

const tablePickerCells = computed(() => {
    const cells: Array<{ row: number; col: number }> = [];

    for (let row = 1; row <= tableMaxRows; row += 1) {
        for (let col = 1; col <= tableMaxCols; col += 1) {
            cells.push({ row, col });
        }
    }

    return cells;
});

function openLinkDialog(): void {
    const previous = editor.value?.getAttributes('link').href;

    if (typeof previous === 'string') {
        linkUrl.value = previous;
    } else {
        linkUrl.value = '';
    }

    linkDialogOpen.value = true;
}

function applyLink(): void {
    const url = linkUrl.value.trim();

    if (url === '') {
        editor.value?.chain().focus().extendMarkRange('link').unsetLink().run();
        linkDialogOpen.value = false;

        return;
    }

    editor.value
        ?.chain()
        .focus()
        .extendMarkRange('link')
        .setLink({ href: url })
        .run();

    linkDialogOpen.value = false;
}

function removeLink(): void {
    editor.value?.chain().focus().extendMarkRange('link').unsetLink().run();
    linkDialogOpen.value = false;
}

function openImagePicker(): void {
    imageInput.value?.click();
}

async function onImageSelected(event: Event): Promise<void> {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    target.value = '';

    if (file === undefined) {
        return;
    }

    uploading.value = true;

    try {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('directory', props.directory);

        const response = await fetch('/core/media', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-XSRF-TOKEN': getXsrfToken(),
            },
            credentials: 'same-origin',
            body: formData,
        });

        if (!response.ok) {
            toast.error('Unable to upload the image.');

            return;
        }

        const payload = (await response.json()) as { url?: string };

        if (typeof payload.url !== 'string' || payload.url === '') {
            toast.error('Unable to upload the image.');

            return;
        }

        if (htmlMode.value) {
            const imageTag = `<img src="${payload.url}" alt="">`;
            htmlSource.value = `${htmlSource.value}${imageTag}`;
            syncHiddenInput();

            return;
        }

        editor.value
            ?.chain()
            .focus()
            .setImage({ src: payload.url })
            .run();
    } catch {
        toast.error('Unable to upload the image.');
    } finally {
        uploading.value = false;
    }
}

function toggleHtmlMode(): void {
    if (!editorReady.value) {
        return;
    }

    if (htmlMode.value) {
        editor.value!.commands.setContent(htmlSource.value, {
            emitUpdate: false,
        });
        htmlMode.value = false;
        syncHiddenInput();

        return;
    }

    if (editor.value!.isEmpty) {
        htmlSource.value = '';
    } else {
        htmlSource.value = editor.value!.getHTML();
    }

    htmlMode.value = true;
    syncHiddenInput();
}

function onHtmlSourceInput(): void {
    syncHiddenInput();
}

function isAligned(alignment: TextAlignment): boolean {
    if (!editorReady.value) {
        return false;
    }

    return editor.value!.isActive({ textAlign: alignment });
}

function isListMenuActive(): boolean {
    return (
        isActive('bulletList')
        || isActive('orderedList')
        || isActive('taskList')
    );
}

function isHeadingMenuActive(): boolean {
    for (const level of headingLevels) {
        if (isActive('heading', { level })) {
            return true;
        }
    }

    return false;
}
</script>

<template>
    <div
        :id="id"
        class="overflow-hidden rounded-md border border-input shadow-xs"
        data-test="rich-text-editor"
    >
        <input
            ref="hiddenInput"
            type="hidden"
            :name="name"
            :required="required"
            data-test="rich-text-content-input"
        />

        <input
            ref="imageInput"
            type="file"
            accept="image/*"
            class="hidden"
            data-test="rich-text-image-input"
            @change="onImageSelected"
        />

        <div
            class="flex flex-wrap items-center gap-1 border-b border-input bg-muted/40 p-2"
            data-test="rich-text-toolbar"
        >
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('bold'))"
                :disabled="!visualModeEnabled"
                aria-label="Bold"
                data-test="rich-text-bold"
                @click="toggleBold"
            >
                <Bold />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('italic'))"
                :disabled="!visualModeEnabled"
                aria-label="Italic"
                data-test="rich-text-italic"
                @click="toggleItalic"
            >
                <Italic />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('underline'))"
                :disabled="!visualModeEnabled"
                aria-label="Underline"
                data-test="rich-text-underline"
                @click="toggleUnderline"
            >
                <UnderlineIcon />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('strike'))"
                :disabled="!visualModeEnabled"
                aria-label="Strikethrough"
                data-test="rich-text-strike"
                @click="toggleStrike"
            >
                <Strikethrough />
            </Button>

            <span
                class="mx-1 h-5 w-px shrink-0 bg-border"
                aria-hidden="true"
                data-test="rich-text-separator-marks"
            />

            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button
                        type="button"
                        variant="ghost"
                        size="sm"
                        class="gap-1 px-2"
                        :class="toolbarButtonClass(isHeadingMenuActive())"
                        :disabled="!visualModeEnabled"
                        aria-label="Heading"
                        data-test="rich-text-heading"
                    >
                        <Heading class="size-4" />
                        <span class="text-xs">{{ activeHeadingLabel }}</span>
                        <ChevronDown class="size-3.5 opacity-60" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="start">
                    <DropdownMenuItem
                        data-test="rich-text-heading-paragraph"
                        @click="setParagraph"
                    >
                        Paragraph
                    </DropdownMenuItem>
                    <DropdownMenuItem
                        v-for="level in headingLevels"
                        :key="level"
                        :data-test="`rich-text-heading-${level}`"
                        @click="toggleHeading(level)"
                    >
                        Heading {{ level }}
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>

            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button
                        type="button"
                        variant="ghost"
                        size="sm"
                        class="gap-1 px-2"
                        :class="toolbarButtonClass(isListMenuActive())"
                        :disabled="!visualModeEnabled"
                        aria-label="Lists"
                        data-test="rich-text-lists"
                    >
                        <List class="size-4" />
                        <span class="text-xs">Lists</span>
                        <ChevronDown class="size-3.5 opacity-60" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="start">
                    <DropdownMenuItem
                        data-test="rich-text-bullet-list"
                        @click="toggleBulletList"
                    >
                        <List class="size-4" />
                        Bullet list
                    </DropdownMenuItem>
                    <DropdownMenuItem
                        data-test="rich-text-ordered-list"
                        @click="toggleOrderedList"
                    >
                        <ListOrdered class="size-4" />
                        Ordered list
                    </DropdownMenuItem>
                    <DropdownMenuItem
                        data-test="rich-text-task-list"
                        @click="toggleTaskList"
                    >
                        <ListTodo class="size-4" />
                        Task list
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>

            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('blockquote'))"
                :disabled="!visualModeEnabled"
                aria-label="Blockquote"
                data-test="rich-text-blockquote"
                @click="toggleBlockquote"
            >
                <Quote />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('code'))"
                :disabled="!visualModeEnabled"
                aria-label="Inline code"
                data-test="rich-text-code"
                @click="toggleCode"
            >
                <Code />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('codeBlock'))"
                :disabled="!visualModeEnabled"
                aria-label="Code block"
                data-test="rich-text-code-block"
                @click="toggleCodeBlock"
            >
                <SquareCode />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('superscript'))"
                :disabled="!visualModeEnabled"
                aria-label="Superscript"
                data-test="rich-text-superscript"
                @click="toggleSuperscript"
            >
                <SubscriptIcon />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('subscript'))"
                :disabled="!visualModeEnabled"
                aria-label="Subscript"
                data-test="rich-text-subscript"
                @click="toggleSubscript"
            >
                <SuperscriptIcon />
            </Button>

            <span
                class="mx-1 h-5 w-px shrink-0 bg-border"
                aria-hidden="true"
                data-test="rich-text-separator-blocks"
            />

            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isActive('link'))"
                :disabled="!visualModeEnabled"
                aria-label="Link"
                data-test="rich-text-link"
                @click="openLinkDialog"
            >
                <LinkIcon />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :disabled="!editorReady || uploading"
                aria-label="Upload image"
                data-test="rich-text-image"
                @click="openImagePicker"
            >
                <ImageIcon />
            </Button>
            <DropdownMenu v-model:open="tableMenuOpen">
                <DropdownMenuTrigger as-child>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon-sm"
                        :disabled="!visualModeEnabled"
                        aria-label="Insert table"
                        data-test="rich-text-table"
                    >
                        <Table />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    align="start"
                    class="p-3"
                    data-test="rich-text-table-picker"
                    @mouseleave="resetTableHover"
                >
                    <p class="mb-2 text-center text-xs text-muted-foreground">
                        {{ tableSizeLabel }}
                    </p>
                    <div
                        class="grid gap-1"
                        :style="{
                            gridTemplateColumns: `repeat(${tableMaxCols}, minmax(0, 1fr))`,
                        }"
                    >
                        <button
                            v-for="cell in tablePickerCells"
                            :key="`${cell.row}-${cell.col}`"
                            type="button"
                            class="size-4 rounded-sm border border-border transition-colors"
                            :class="
                                isTableCellSelected(cell.row, cell.col)
                                    ? 'border-brand-accent bg-brand-accent/30'
                                    : 'bg-background hover:border-brand-accent/60'
                            "
                            :data-test="`rich-text-table-cell-${cell.row}-${cell.col}`"
                            @mouseenter="onTableCellHover(cell.row, cell.col)"
                            @click="insertTable(cell.row, cell.col)"
                        />
                    </div>
                </DropdownMenuContent>
            </DropdownMenu>

            <span
                class="mx-1 h-5 w-px shrink-0 bg-border"
                aria-hidden="true"
                data-test="rich-text-separator-media"
            />

            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isAligned('left'))"
                :disabled="!visualModeEnabled"
                aria-label="Align left"
                data-test="rich-text-align-left"
                @click="setAlignment('left')"
            >
                <AlignLeft />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isAligned('center'))"
                :disabled="!visualModeEnabled"
                aria-label="Align center"
                data-test="rich-text-align-center"
                @click="setAlignment('center')"
            >
                <AlignCenter />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isAligned('right'))"
                :disabled="!visualModeEnabled"
                aria-label="Align right"
                data-test="rich-text-align-right"
                @click="setAlignment('right')"
            >
                <AlignRight />
            </Button>
            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :class="toolbarButtonClass(isAligned('justify'))"
                :disabled="!visualModeEnabled"
                aria-label="Align justify"
                data-test="rich-text-align-justify"
                @click="setAlignment('justify')"
            >
                <AlignJustify />
            </Button>

            <span
                class="mx-1 h-5 w-px shrink-0 bg-border"
                aria-hidden="true"
                data-test="rich-text-separator-align"
            />

            <Button
                type="button"
                variant="ghost"
                size="icon-sm"
                :disabled="!visualModeEnabled"
                aria-label="Horizontal rule"
                data-test="rich-text-horizontal-rule"
                @click="insertHorizontalRule"
            >
                <Minus />
            </Button>

            <span
                class="mx-1 h-5 w-px shrink-0 bg-border"
                aria-hidden="true"
                data-test="rich-text-separator-hr"
            />

            <Button
                type="button"
                variant="ghost"
                size="sm"
                class="gap-1 px-2"
                :class="toolbarButtonClass(htmlMode)"
                :disabled="!editorReady"
                aria-label="Toggle HTML mode"
                data-test="rich-text-html-toggle"
                @click="toggleHtmlMode"
            >
                <CodeXml v-if="!htmlMode" class="size-4" />
                <FileCode2 v-else class="size-4" />
                <span class="text-xs">{{ htmlMode ? 'Visual' : 'HTML' }}</span>
            </Button>
        </div>

        <div
            class="rich-text-editor-scroll max-h-96 min-h-64 overflow-y-auto"
            data-test="rich-text-scroll"
        >
            <textarea
                v-if="htmlMode"
                v-model="htmlSource"
                class="h-full min-h-64 w-full resize-none border-0 bg-transparent px-3 py-2 font-mono text-sm outline-none focus-visible:ring-0"
                data-test="rich-text-html-source"
                @input="onHtmlSourceInput"
            />
            <EditorContent
                v-show="!htmlMode"
                :editor="editor"
            />
        </div>
    </div>

    <Dialog v-model:open="linkDialogOpen">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Insert link</DialogTitle>
                <DialogDescription>
                    Paste a URL. Leave empty and apply to remove the link from the selection.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-2">
                <Label for="rich-text-link-url">URL</Label>
                <input
                    id="rich-text-link-url"
                    v-model="linkUrl"
                    type="url"
                    placeholder="https://example.com"
                    class="border-input h-9 w-full rounded-md border bg-transparent px-3 py-1 text-sm shadow-xs outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]"
                    data-test="rich-text-link-url"
                />
            </div>
            <DialogFooter class="gap-2 sm:gap-0">
                <Button
                    type="button"
                    variant="ghost"
                    data-test="rich-text-link-remove"
                    @click="removeLink"
                >
                    Remove
                </Button>
                <Button
                    type="button"
                    data-test="rich-text-link-apply"
                    @click="applyLink"
                >
                    Apply
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style>
.rich-text-editor-scroll .tiptap,
.rich-text-editor-scroll .ProseMirror {
    min-height: 16rem;
}

.rich-text-editor-prose h1 {
    margin: 0.9rem 0 0.5rem;
    font-size: 1.5rem;
    font-weight: 700;
}

.rich-text-editor-prose h2 {
    margin: 0.75rem 0 0.5rem;
    font-size: 1.25rem;
    font-weight: 600;
}

.rich-text-editor-prose h3 {
    margin: 0.75rem 0 0.5rem;
    font-size: 1.1rem;
    font-weight: 600;
}

.rich-text-editor-prose h4,
.rich-text-editor-prose h5,
.rich-text-editor-prose h6 {
    margin: 0.65rem 0 0.4rem;
    font-size: 1rem;
    font-weight: 600;
}

.rich-text-editor-prose p {
    margin: 0.5rem 0;
}

.rich-text-editor-prose ul {
    margin: 0.5rem 0;
    list-style: disc;
    padding-left: 1.25rem;
}

.rich-text-editor-prose ol {
    margin: 0.5rem 0;
    list-style: decimal;
    padding-left: 1.25rem;
}

.rich-text-editor-prose ul[data-type='taskList'] {
    list-style: none;
    padding-left: 0;
}

.rich-text-editor-prose ul[data-type='taskList'] li {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.rich-text-editor-prose ul[data-type='taskList'] li > label {
    margin-top: 0.2rem;
}

.rich-text-editor-prose blockquote {
    margin: 0.75rem 0;
    border-left: 3px solid var(--border);
    padding-left: 0.75rem;
    color: var(--muted-foreground);
}

.rich-text-editor-prose code {
    border-radius: 0.25rem;
    background: var(--muted);
    padding: 0.1rem 0.35rem;
    font-size: 0.875em;
}

.rich-text-editor-prose pre {
    margin: 0.75rem 0;
    overflow-x: auto;
    border-radius: 0.375rem;
    background: var(--muted);
    padding: 0.75rem 1rem;
}

.rich-text-editor-prose pre code {
    background: transparent;
    padding: 0;
}

.rich-text-editor-prose img {
    margin: 0.75rem 0;
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
}

.rich-text-editor-prose a {
    color: var(--brand-accent, #72887b);
    text-decoration: underline;
}

.rich-text-editor-prose hr {
    margin: 1rem 0;
    border: 0;
    border-top: 1px solid var(--border);
}

.rich-text-editor-prose table {
    margin: 0.75rem 0;
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.rich-text-editor-prose th,
.rich-text-editor-prose td {
    border: 1px solid var(--border);
    padding: 0.4rem 0.55rem;
    vertical-align: top;
}

.rich-text-editor-prose th {
    background: var(--muted);
    font-weight: 600;
}

.rich-text-editor-prose p.is-editor-empty:first-child::before {
    float: left;
    height: 0;
    color: var(--muted-foreground);
    content: attr(data-placeholder);
    pointer-events: none;
}
</style>
