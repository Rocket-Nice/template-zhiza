export default function toTopScrollButton() {
  const toTopBtn = document.querySelector('.to_top');

  function checkedScroll() {
    const heightW = Number.isNaN(window.innerHeight) ? window.clientHeight : window.innerHeight;
    if (window.pageYOffset < heightW) {
      toTopBtn.classList.add('disabled');
    } else {
      toTopBtn.classList.remove('disabled');
    }
  }

  if (toTopBtn) {
    checkedScroll();
    window.addEventListener('scroll', () => {
      checkedScroll();
    });
    toTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
}
