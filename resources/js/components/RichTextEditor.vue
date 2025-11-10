<!-- resources/js/Components/RichTextEditor.vue -->
<script setup>
import { ref, onBeforeUnmount, watch } from 'vue';
import { Editor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import TextStyle from '@tiptap/extension-text-style';

// ✅ On utilise Icon de lucide-vue-next
import { Icon } from 'lucide-vue-next';

// --- Props & Événements ---
const props = defineProps({
    modelValue: { type: String, default: '' }
});

const emit = defineEmits(['update:modelValue']);

// --- Extension personnalisée : FontSize ---
const FontSize = TextStyle.extend({
    addGlobalAttributes() {
        return [
            {
                types: this.name,
                attributes: {
                    fontSize: {
                        default: null,
                        renderHTML: attributes => {
                            if (!attributes.fontSize) return {};
                            return { style: `font-size: ${attributes.fontSize}` };
                        },
                        parseHTML: element => ({
                            fontSize: element.style.fontSize.replace(/['"]+/g, '') || null
                        }),
                    },
                },
            },
        ];
    },

    // Méthode pour définir la taille
    addCommands() {
        return {
            setFontSize: size => ({ commands }) => {
                return commands.setMark(this.name, { fontSize: size });
            },
            unsetFontSize: () => ({ chain }) => {
                return chain().setMark(this.name, { fontSize: null }).removeEmptyTextStyle();
            },
        };
    },
});

// --- Initialisation de l'éditeur ---
const editor = ref(null);

editor.value = new Editor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        FontSize.configure(), // ✅ Notre extension perso
    ],
    onUpdate: () => {
        emit('update:modelValue', editor.value.getHTML());
    },
});

// Met à jour si modelValue change depuis l'extérieur
watch(() => props.modelValue, (value) => {
    if (editor.value && editor.value.getHTML() !== value) {
        editor.value.commands.setContent(value, false);
    }
});

// Nettoyage
onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.destroy();
    }
});
</script>

<template>
    <div class="border border-gray-300 rounded-xl overflow-hidden bg-white dark:bg-gray-900">
        <!-- Barre d'outils -->
        <div class="flex flex-wrap gap-1 bg-gray-50 px-2 py-1 border-b">
            <!-- Gras -->
            <button type="button" @click="editor.chain().focus().toggleBold().run()"
                :class="{ 'bg-blue-500': editor.isActive('bold') }" class="p-1 rounded hover:bg-gray-200 transition"
                title="Gras (Ctrl+B)">
                <Icon name="Bold" :size="18" stroke-width="2.5"
                    :class="editor.isActive('bold') ? 'text-white' : 'text-gray-700'" />
            </button>

            <!-- Italique -->
            <button type="button" @click="editor.chain().focus().toggleItalic().run()"
                :class="{ 'bg-blue-500': editor.isActive('italic') }" class="p-1 rounded hover:bg-gray-200 transition"
                title="Italique (Ctrl+I)">
                <Icon name="Italic" :size="18" stroke-width="2.5"
                    :class="editor.isActive('italic') ? 'text-white' : 'text-gray-700'" />
            </button>

            <!-- Souligné -->
            <button type="button" @click="editor.chain().focus().toggleUnderline().run()"
                :class="{ 'bg-blue-500': editor.isActive('underline') }"
                class="p-1 rounded hover:bg-gray-200 transition" title="Souligné (Ctrl+U)">
                <Icon name="Underline" :size="18" stroke-width="2.5"
                    :class="editor.isActive('underline') ? 'text-white' : 'text-gray-700'" />
            </button>

            <!-- Sélecteur de taille -->
            <select @change="editor.chain().focus().setFontSize($event.target.value).run()"
                :value="editor.getAttributes('fontSize').fontSize || ''"
                class="ml-2 text-xs border rounded px-2 py-0.5 bg-white">
                <option value="">A</option>
                <option value="14px">A⁻</option>
                <option value="16px" selected>A</option>
                <option value="18px">A⁺</option>
                <option value="24px">A⁺⁺</option>
            </select>
        </div>

        <!-- Zone d'édition -->
        <EditorContent :editor="editor"
            class="prose prose-sm p-3 min-h-[120px] max-h-[300px] overflow-y-auto leading-snug" />
    </div>
</template>

<style>
.prose {
    @apply max-w-none;
}
</style>