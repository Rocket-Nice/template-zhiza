$(document).ready(function() {
  $(".article .cut").on('click', function() {
    $(this).parent().removeClass('article--collapsed');
    $(this).remove();
  });
});
