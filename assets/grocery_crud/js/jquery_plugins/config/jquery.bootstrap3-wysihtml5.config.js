$(function () {
    $('textarea.texteditor').wysihtml5({
        toolbar: {
            "font-styles": true,
            "emphasis": true,
            "lists": true,
            "html": true,
            "link": true,
            "image": true,
            "color": false,
            "blockquote": false,
            "outdent": false,
            "indent": false,
            "size": 'sm',
            "fa": true
        }
    });
    $('textarea.mini-texteditor').wysihtml5({
        toolbar: {
            "font-styles": true,
            "emphasis": true,
            "lists": true,
            "html": true,
            "link": true,
            "image": true,
            "color": false,
            "blockquote": false,
            "outdent": false,
            "indent": false,
            "size": 'sm',
            "fa": true
        }
    });
});