<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('markdown-editor');
    if (!el) return;

    new EasyMDE({
        element: el,
        spellChecker: false,
        autoDownloadFontAwesome: true,
        placeholder: 'Write your article in Markdown...',
        toolbar: [
            'bold', 'italic', 'heading', '|',
            'quote', 'code', 'unordered-list', 'ordered-list', '|',
            'link', 'image', 'table', '|',
            'preview', 'side-by-side', 'fullscreen', '|',
            'guide'
        ],
    });
});
</script>