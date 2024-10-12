// (function($) {
//   'use strict';
//   $(function() {
//     $('.file-upload-browse').on('click', function() {
//       var file = $(this).parent().parent().parent().find('.file-upload-default');
//       file.trigger('click');
//     });
//     $('.file-upload-default').on('change', function() {
//       $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
//     });
//   });
// })(jQuery);

(function($) {
  'use strict';
  $(function() {
    // Trigger file input click when "Browse" button is clicked
    $('.file-upload-browse').on('click', function() {
      var fileInput = $(this).parent().parent().parent().find('.file-upload-default');
      fileInput.trigger('click');
    });

    // Handle file selection and update text input with file names
    $('.file-upload-default').on('change', function() {
      var fileInput = $(this);
      var fileInfo = fileInput.parent().find('.form-control');
      var fileNames = Array.from(fileInput[0].files).map(file => file.name).join(', ');
      fileInfo.val(fileNames);
    });
  });
})(jQuery);
