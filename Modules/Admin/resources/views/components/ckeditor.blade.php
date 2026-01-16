@props(['id','label' => null, 'placeholder' => ''])
@once
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        /* Custom lại chiều cao CKEditor cho đẹp */
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
@endonce
<div wire:ignore class="w-full">
    @if ($label)
        <label class="block text-sm font-medium leading-6 text-gray-900 mb-2">
            {{ $label }}
        </label>
    @endif

    <div x-data="{
        init() {
            if (typeof ClassicEditor === 'undefined') {
                console.error('CKEditor chưa được load');
                return;
            }

            ClassicEditor
                .create(this.$refs.editor, {
                    placeholder: '{{ $placeholder }}',
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
                })
                .then(editor => {
                    // 1. Lấy tên biến wire:model từ attributes
                    // Ví dụ: wire:model='description' -> variableName = 'description'
                    let variableName = '{{ $attributes->wire('model')->value() }}';

                    // 2. Load dữ liệu ban đầu
                    let initialData = $wire.get(variableName);
                    if (initialData) editor.setData(initialData);

                    // 3. Sync dữ liệu khi gõ
                    editor.model.document.on('change:data', () => {
                        $wire.set(variableName, editor.getData(), false);
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }">
        <textarea x-ref="editor" {{ $attributes->whereDoesntStartWith('wire:model') }}></textarea>
    </div>
</div>
