export function RedesignedSubscribeForm() {
  const forms = document.querySelectorAll('[data-form]');
  if (forms) {
    Array.prototype.slice.call(forms).forEach(el => {
      subscribe(el);
    });
  }

  /**
   * @param {Element} el
   */
  function subscribe(el) {
    const form = el.querySelector('form');
    form.addEventListener('submit', submit);

    /**
     * @param {SubmitEvent} e
     */
    async function submit(e) {
      e.preventDefault();
      const formData = Object.fromEntries(new FormData(e.target).entries());
      const submitData = JSON.stringify({
        'email': formData.email,
        'type': 'ZHIZA',
        'source': window.location.href,
      });
      const txtContainer = el.querySelector('.text--container');
      const successContainer = el.querySelector('.success');

      const btn = e.target.querySelector('button');
      try {
        btn.innerHTML = 'Отправляем..';
        e.target.classList.toggle('no-user-select');

        const req = await fetch('https://newsletters.evotor.ru/api/v1/newsletters/subscribe', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: submitData
        });

        if (req.status === 200 || req.status === 204) {
          txtContainer.classList.toggle('hidden');
          successContainer.classList.toggle('hidden');
        } else {
          throw new Error('Status code not 200.');
        }
      } catch (err) {
        console.error('ERR', err);
        const error = e.target.querySelector('.error');
        const parent = e.target.closest('.subscribe--form');
        const policy = parent.querySelector('.policy');
        error.classList.toggle('hidden');
        policy.classList.toggle('hidden');
      } finally {
        e.target.classList.toggle('no-user-select');
        btn.innerHTML = 'Подписаться';
      }
    }
  }
}
