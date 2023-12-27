export function Accord() {
  const accordsHead = document.querySelectorAll('.accord .accord_head');

  accordsHead.forEach((accordHead) => {
    accordHead.addEventListener('click', (e) => {
      const accord = accordHead.closest('.accord')
      const accordBody = accord.querySelector('.accord_body')
      if (accord.classList.contains('accord__open') && accordBody) {
        CloseAccords();
      } else {
        accord.classList.add('accord__open')
        const bodyElems = accordBody.children;
        let bodyWidth = 0
        for (const bodyElem of bodyElems) {
          bodyWidth += bodyElem.offsetHeight;
        }
        accordBody.style.height = bodyWidth + 'px'
      }
    })
  })
}

export function CloseAccords() {
  const accords = document.querySelectorAll('.accord.accord__open');
  accords.forEach((accord) => {
    accord.classList.remove('accord__open')
    const accordBody = accord.querySelector('.accord_body')
    accordBody.style.height = ''
  })

}
