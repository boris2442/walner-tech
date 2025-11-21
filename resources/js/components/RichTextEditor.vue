<!-- RichTextEditor.vue -->
<script setup lang="ts">
import Color from '@tiptap/extension-color';
import Highlight from '@tiptap/extension-highlight';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import StarterKit from '@tiptap/starter-kit';
import { EditorContent, useEditor } from '@tiptap/vue-3';

const props = withDefaults(
    defineProps<{
        modelValue?: string;
        placeholder?: string;
    }>(),
    {
        modelValue: '',
        placeholder: 'Écrivez ici...',
    },
);

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        Underline,
        Highlight,
        Color,
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
    ],
    editorProps: {
        attributes: {
            class: 'focus:outline-none min-h-[200px] p-4 text-[17px] leading-relaxed',
            'data-placeholder': props.placeholder,
        },
    },
    onUpdate({ editor }) {
        emit('update:modelValue', editor.getHTML());
    },
    immediatelyRender: false,
});
</script>

<template>
    <div class="tiptap-editor rounded-lg border bg-white dark:bg-gray-900">
        <!-- TOOLBAR -->
        <div class="flex flex-wrap items-center gap-2 border-b bg-gray-50 p-2 dark:bg-gray-800">
            <!-- Gras -->
            <button @click="editor?.chain().focus().toggleBold().run()" :class="editor?.isActive('bold') ? 'active-btn' : 'btn'">
                <strong>B</strong>
            </button>

            <!-- Italique -->
            <button @click="editor?.chain().focus().toggleItalic().run()" :class="editor?.isActive('italic') ? 'active-btn' : 'btn'">
                <em>I</em>
            </button>

            <!-- Souligné -->
            <button @click="editor?.chain().focus().toggleUnderline().run()" :class="editor?.isActive('underline') ? 'active-btn' : 'btn'">
                <u>U</u>
            </button>

            <!-- Barré -->
            <button @click="editor?.chain().focus().toggleStrike().run()" :class="editor?.isActive('strike') ? 'active-btn' : 'btn'">
                <s>S</s>
            </button>

            <!-- Surlignage -->
            <button @click="editor?.chain().focus().toggleHighlight().run()" :class="editor?.isActive('highlight') ? 'active-btn' : 'btn'">
                <span class="bg-yellow-300 px-1">HL</span>
            </button>

            <!-- Couleur du texte -->
            <input type="color" @input="editor?.chain().focus().setColor($event.target.value).run()" />

            <!-- Titres -->
            <button
                @click="editor?.chain().focus().toggleHeading({ level: 1 }).run()"
                :class="editor?.isActive('heading', { level: 1 }) ? 'active-btn' : 'btn'"
            >
                H1
            </button>

            <button
                @click="editor?.chain().focus().toggleHeading({ level: 2 }).run()"
                :class="editor?.isActive('heading', { level: 2 }) ? 'active-btn' : 'btn'"
            >
                H2
            </button>

            <button
                @click="editor?.chain().focus().toggleHeading({ level: 3 }).run()"
                :class="editor?.isActive('heading', { level: 3 }) ? 'active-btn' : 'btn'"
            >
                H3
            </button>

            <!-- Alignements -->
            <button @click="editor?.chain().focus().setTextAlign('left').run()" class="btn">↤</button>
            <button @click="editor?.chain().focus().setTextAlign('center').run()" class="btn">↔</button>
            <button @click="editor?.chain().focus().setTextAlign('right').run()" class="btn">↦</button>
            <button @click="editor?.chain().focus().setTextAlign('justify').run()" class="btn">≋</button>

            <!-- Listes -->
            <button @click="editor?.chain().focus().toggleBulletList().run()" :class="editor?.isActive('bulletList') ? 'active-btn' : 'btn'">
                •
            </button>

            <button @click="editor?.chain().focus().toggleOrderedList().run()" :class="editor?.isActive('orderedList') ? 'active-btn' : 'btn'">
                1.
            </button>

            <!-- Code -->
            <button @click="editor?.chain().focus().toggleCode().run()" :class="editor?.isActive('code') ? 'active-btn' : 'btn'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 18l6-6-6-6M8 6l-6 6 6 6" />
                </svg>
            </button>

            <!-- Undo/Redo -->
            <button @click="editor?.chain().focus().undo().run()" class="btn">↩</button>
            <button @click="editor?.chain().focus().redo().run()" class="btn">↪</button>
        </div>

        <!-- CONTENU -->
        <EditorContent :editor="editor" class="prose dark:prose-invert max-w-none" />
    </div>
</template>

<style lang="postcss">
.btn {
    @apply rounded px-2 py-1 transition hover:bg-gray-200 dark:hover:bg-gray-700;
}
.active-btn {
    @apply rounded bg-blue-200 px-2 py-1 dark:bg-blue-900;
}

/* Placeholder TipTap */
.ProseMirror p.is-empty::before {
    content: attr(data-placeholder);
    float: left;
    color: #9ca3af;
    pointer-events: none;
    height: 0;
}
</style>
