/**
 * Обработка клика по зашлушке ютубовского фрейма на главной странице.
 */

const youtubeFrame = document.querySelectorAll('[data-youtube_frame]');
Array.prototype.slice.call(youtubeFrame).forEach((el) => {
  el.addEventListener('click', (e) => {
    const target = e.currentTarget;

    const frame = document.createElement("iframe");
    frame.setAttribute("src", `https://www.youtube.com/embed/${target.dataset['youtube_video_id']}`);
    frame.setAttribute("frameborder", "0");
    frame.setAttribute("allow", "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture");
    frame.setAttribute("allowfullscreen", "true");
    frame.style.width = "914px";
    frame.style.height = "508px";

    target.innerHTML = '';
    target.classList.remove('youtube-placeholder__play-button');
    target.insertAdjacentElement('afterbegin', frame);
  });
});
