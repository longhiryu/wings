<script>
    tinymce.init({
        height : "680",
        selector: "{{ $element ?? '.tiny-mce' }}",
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        setup: function(editor) {
            editor.on('init change', function() {
                editor.save();
            });
            editor.on('change', function(e) {
                @this.set("{{ $property ?? 'translated.long_description' }}", editor.getContent());
            });
        }
    });
</script>