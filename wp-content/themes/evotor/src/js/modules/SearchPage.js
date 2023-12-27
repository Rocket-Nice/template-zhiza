require('./SearchPagePostsPaginator');
const {moveCursorAtEndOfInput} = require("../helpers");

(function () {
  const input = document.querySelector('.page-search input[name="s"]');
  if (!input) {
    return;
  }

  document.addEventListener('DOMContentLoaded', () => {
    moveCursorAtEndOfInput(input);
  });
})();
