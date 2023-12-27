export default function CountsComment() {
    // Изменение количества комментов.
    const pldCommonWrap = document.createElement('div');
    pldCommonWrap.classList.add('pld-common-wrap');

    const imgElement = document.createElement('img');
    imgElement.src = '/wp-content/themes/evotor/assets/images/commentsicon.svg';
    imgElement.setAttribute('loading', 'lazy');
    imgElement.setAttribute('decoding', 'async');

    const countCommentsSpan = document.createElement('span');
    countCommentsSpan.classList.add('pld-count-wrap');

    const commentItems = document.querySelectorAll('.comment_item');
    const commentItemsCount = commentItems.length;

    countCommentsSpan.textContent = commentItemsCount;

    pldCommonWrap.appendChild(imgElement);
    pldCommonWrap.appendChild(countCommentsSpan);

    const likeDislikeWrap = document.querySelector('.pld-like-dislike-wrap');

    if (likeDislikeWrap) {
        likeDislikeWrap.appendChild(pldCommonWrap);
    }
}