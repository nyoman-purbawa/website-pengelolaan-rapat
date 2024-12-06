$(function () {
  // Summernote
  $("#summernote").summernote({
    height: 300, // Tinggi editor
    toolbar: [
      // Toolbar yang ditampilkan
      ["style", ["bold", "italic", "underline", "clear"]],
      ["font", ["strikethrough", "superscript", "subscript"]],
      ["fontsize", ["fontsize"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
      ["insert", ["picture", "link", "video"]],
      ["view", ["fullscreen", "codeview", "help"]],
    ],
  });

  // CodeMirror
  CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
    mode: "htmlmixed",
    theme: "monokai",
  });
});
