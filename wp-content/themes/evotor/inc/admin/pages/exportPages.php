<style>
    .button-wrapper {
        margin-top: 20px;
    }

    .button-wrapper .btn-send {
        padding: 8px 16px;
        border: 1px solid #df5b35;
        color: #df5b35;
        background-color: #fff;
        border-radius: 6px;
        transition: 0.3s ease all;
        cursor: pointer;
    }

    .button-wrapper .btn-send:hover {
        background-color: #df5b35;
        color: white;
    }
    table.striped tbody tr:nth-child(odd){
        background: #F7F7F7;
    }
    table.striped tbody tr:nth-child(even){
        background: #fff;
    }
    table.striped tbody td:empty {
        height: 10px;
    }
</style>

<h1>
    Экспорт статей в маркет
</h1>

<table class="striped widefat fixed" cellspacing="0">
    <thead>
    <tr>
        <th id="cb" class="manage-column column-cb" scope="col" style="width: 8%;">ID</th>
        <th id="columnname" class="manage-column column-columnname" scope="col">Название статьи</th>
        <th id="columnname" class="manage-column column-columnname" scope="col">Ссылка на статью в маркете</th>
        <th id="columnname" class="manage-column column-columnname" scope="col">Статус</th>
    </tr>
    </thead>

    <tbody id="statusTable"></tbody>

    <tfoot>
        <tr>
            <th class="manage-column column-cb" scope="col" style="width: 8%;"></th>
            <th class="manage-column column-columnname" scope="col"></th>
            <th class="manage-column column-columnname" scope="col"></th>
            <th class="manage-column column-columnname" scope="col"></th>
        </tr>
    </tfoot>
</table>


<div class="button-wrapper">
    <button id="startExport" class="btn-send">
        Отправить
    </button>

    <button id="exportNew" class="btn-send">
        Экспортировать новые
    </button>
</div>


<script>
    const $ = jQuery;
    //
    $(document).on('ready', async function () {
        //
        const env = 'prod'; // prod | test. Определяет, какую среду использовать.
        //
        const testDomain = 'https://market-internal-api-test.evotor.ru';
        const prodDomain = 'https://market-internal-api.evotor.ru';
        //
        let domain = testDomain;
        //
        if (env === 'prod') {
            domain = prodDomain;
        }
        //
        const basicToken = await getBasicToken().then(data => data['token']);
        //
        $('#startExport').on('click', function () {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'getPosts',
                },
                type: 'GET',
            }).then(async function (data) {
                // Пройти по всем постам, полученным в запросе
                for (const el of data) {
                    await exportPost(el['ID'], el['title']);
                }
                alert('Экспорт статей завершен.');
            });
        });

        $('#exportNew').on('click', function() {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'getNewPosts',
                },
                type: 'GET',
            }).then(async function (data) {
                // Пройти по всем постам, полученным в запросе
                for (const el of data) {
                    // Эти статьи временно заблочены таким способом. Их экспорт ненужен, а флаг в адмике не меняется из-за 403 ошибки.
                    if (['3070', '5446'].includes((el.ID))) {
                        continue;
                    }
                    await exportPost(el['ID'], el['title']);
                    // Для купирования возможного наложения асинхронности, сон на 3 секунды.
                    // TODO: Потенциально бесполезная вещь, но для тестирования нужна.
                    await sleep(3000);
                }
                //
                alert('Экспорт статей завершен.');
            });
        });

        async function exportPost(id, postTitle) {
            await $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'getPostData',
                    'ID': id,
                },
                type: 'POST',
            }).then(
                /**
                 * @param data.ID - поста в жизе
                 * @param data.content - html контент
                 * @param data.marketId - id статьи в маркете. Если пустой - создаем статью там, иначе обновляем.
                 * @param data.title - заголовок статьи
                 * @param data.thumbnail.url - ссылка на фото превью статьи
                 * @param data.thumbnail.marketImgId - ID превью-изображения, сохраненное в маркете
                 * @param data.excerpt - краткое описание статьи
                 * @param data.date - дата создания статьи
                 */
                async function (data) {
                    let marketData = data;
                    //
                    const thumbnail = marketData.thumbnail;
                    const previewStatus = await checkAndCreatePostPreview(thumbnail, marketData.ID);
                    marketData.thumbnail.marketImgId = previewStatus.marketImgUrl; // Save link on preview CDN.
                    await writeTable(marketData.ID, marketData.title, previewStatus);
                    // Если мета поле картинки не сохранилась, то и статью не будем создавать.
                    if (previewStatus.success) {
                        // Пост ещё не создан, если нет marketId
                        if (marketData.marketId === '' || marketData.marketId === null) {
                            const statusPostCreate = await createPost(marketData);
                            await writeTable(
                                marketData.ID, marketData.title, statusPostCreate, statusPostCreate.marketPostId
                            );
                        } else {
                            // Код обновления контента статьи
                            const statusPostUpdate = await updatePost(marketData, marketData.marketId);
                            await writeTable(
                                marketData.ID, marketData.title, statusPostUpdate, marketData.marketId
                            );
                        }
                    } else {
                        await writeTable(marketData.ID, marketData.title, previewStatus);
                    }
                    await writeTable('', '', {}); // Создать пустую строку, как разделитель
                }
            );
        }

        /**
         *
         * @param thumbnail.marketImgId
         * @param thumbnail.url
         * @return {Promise<{success: boolean, message: string, marketImgUrl: *}>}
         */
        async function checkAndCreatePostPreview(thumbnail, postId) {
            let status = {
                success: true,
                message: 'Фото превью поста уже создано.',
                marketImgUrl: thumbnail.marketImgId
            }
            // Если превью не было загружено в маркет
            if (thumbnail.marketImgId === '' || thumbnail.marketImgId === null) {
                // Если у статьи нет url, экспорт статьи не продолжится
                if (thumbnail.url === '' || thumbnail.url === null) {
                    status = {
                        success: false,
                        message: 'В данном посте отсутствует превью изображение.',
                        imgIdUrl: null,
                    }
                } else {
                    // Отправить фотку на создание
                    const imgUrl = await getImgFile(thumbnail.url);
                    //
                    if (imgUrl !== null) {
                        const updateStatus = await updatePostMeta(postId, imgUrl, 'url_image_market_post');
                        status = {
                            success: true,
                            message: 'Превью поста создано.',
                            marketImgUrl: imgUrl,
                        }
                    } else {
                        status = {
                            success: false,
                            message: 'Ошибка создания изображения статьи.',
                            imgIdUrl: null,
                        }
                    }
                }
            }

            return status;
        }

        /**
         * Получить базовый токен
         * @returns {Promise} - Объект с параметров token.
         */
        async function getBasicToken() {
            return $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'getBasicToken',
                    'env': env
                },
                type: 'GET',
            });
        }

        async function getBearerToken() {
            let data = null;
            //
            try {
                data = await $.ajax({
                    url: `${domain}/oauth/token`,
                    method: "POST",
                    timeout: 0,
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "Authorization": "Basic " + basicToken
                    },
                    data: {
                        'grant_type': "client_id"
                    }
                });
            } catch (ex) {
                console.log(ex);
                return null;
            }

            return data['access_token']
        }

        /**
         *
         * @param payload
         * @param payload.ID - статьи в жизе
         * @param payload.content - html контент
         * @param payload.date - дата создания статьи на жизе
         * @param payload.excerpt - краткое содержимое статьи
         * @param payload.thumbnail - фото превью
         * @param payload.title - заголовок статьи
         * @param payload.categoryId - id категории на маркете
         * @return {Promise<{success: boolean, message: string, marketPostId: string|null}>}
         */
        async function createPost(payload) {
            let data;
            const bearer = await getBearerToken();
            //
            try {
                const postPayload = {
                    title: payload.title,
                    description: payload.excerpt,
                    categoryId: payload.categoryId,
                    type: 'INTERNAL',
                    accessType: 'PUBLIC',
                    status: 'ACTIVE',
                    buttonTitle: 'Посмотреть',
                    buttonUrl: null,
                    imgUrl: payload.thumbnail.marketImgId,
                    content: payload.content,
                    publicationDate: payload.date
                };
                //
                data = await $.ajax({
                    url: `${domain}/api/v1/feed/feeds`,
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + bearer,
                    },
                    data: JSON.stringify(postPayload),
                });
                //
                console.log('Message from market: => ', data);
                //
                const updateStatus = await updatePostMeta(payload.ID, data.id, 'id_market_post');
                if (updateStatus.status) {
                    return {
                        success: true,
                        message: 'Статья успешно создана. ' + updateStatus.message,
                        marketPostId: data['id'],
                    };
                }
                // Обновление marketID произошло с ошибкой.
                return {
                    success: updateStatus.status,
                    message: updateStatus.message,
                    marketPostId: null,
                };

            } catch (error) {
                console.error(error);
                return {
                    success: false,
                    message: 'Ошибка создания статьи',
                    marketPostId: null,
                };
            }
        }

        /**
         *
         * @param payload
         * @param marketPostId
         * @return {Promise<{success: boolean, message: string, marketPostId: null}>}
         */
        async function updatePost(payload, marketPostId) {
            let data;
            const bearer = await getBearerToken();
            //
            try {
                const postPayload = {
                    title: payload.title,
                    description: payload.excerpt,
                    categoryId: payload.categoryId,
                    type: 'INTERNAL',
                    accessType: 'PUBLIC',
                    status: 'ACTIVE',
                    buttonTitle: 'Посмотреть',
                    buttonUrl: null,
                    imgUrl: payload.thumbnail.marketImgId,
                    content: payload.content,
                    publicationDate: payload.date
                };
                //
                data = await $.ajax({
                    url: `${domain}/api/v1/feed/feeds/${marketPostId}`,
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + bearer,
                    },
                    data: JSON.stringify(postPayload),
                });
                //
                console.log('Message from market: => ', data);
                //
                return {
                    success: true,
                    message: 'Контент статьи успешно обновлен',
                    marketPostId: data['id'],
                };
            } catch (error) {
                console.error(error);
                return {
                    success: false,
                    message: 'Ошибка обновления контента статьи.',
                    marketPostId: null,
                };
            }
        }

        /**
         *
         * @param id
         * @param status
         * @param title
         * @param marketPostId
         * @param status.success
         * @param status.message
         * @return {Promise<string>}
         */
        async function writeTable(id, title, status, marketPostId = null) {
            const color = status.success ? 'green' : 'red';
            //
            const markerPostUrl = marketPostId ?
                `<a href="https://market.evotor.ru/newsletters/all/view/${marketPostId}" target="_blank">${title}</a>` :
                '';
            //
            const row = `
            <tr class="alternate">
                <th class="" style="width: 8%;">${id}</th>
                <td class=""><a href="/?p=${id}" target="_blank">${title}</a></td>
                <td class="">${markerPostUrl}</td>
                <td class="" style="color: ${color}">${status.message ?? ''}</td>
            </tr>
            `;

            document.querySelector('#statusTable').insertAdjacentHTML( 'beforeend', row );
        }

        /**
         * @param postID - ID поста в жизе
         * @param metaValue - значение мета поля. Либо ID поста в маркете либо url до CDN изображения в маркете
         * @param postMetaName - meta поле для обновления.
         */
        async function updatePostMeta(postID, metaValue, postMetaName) {
            const data = await $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: {
                    'action': 'updatePostMeta',
                    'postID': postID,
                    'metaValue': metaValue,
                    'metaName': postMetaName,
                },
                type: 'POST',
            });

            return data;
        }

        /**
         * Запрос в маркет на запись изображение из url в CDN маркета.
         * @param url - адрес изображения на сайте жизы.
         * @return {Promise<null|*>}
         */
        async function getImgFile(url) {
            try {
                const res = await fetch(url, {mode: 'cors'});
                const blob = await res.blob();
                const ext = (url.match(/\.[0-9a-z]{1,5}$/i) || [""])[0].substring(1); // Расширение изображения

                const bearer = await getBearerToken();

                let fd = new FormData();
                // 3 аргумент определяет имя файла в форме. Здесь крайне важно расширение файла
                fd.append('file', blob, `postPreview.${ext}`);
                //
                const img = await $.ajax({
                    url: `${domain}/api/v1/feed/files`,
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    headers: {
                        "Authorization": "Bearer " + bearer,
                    }
                });
                console.log('Фото отправлено в CDN.');

                // Если ответ на создание изображение положительный, вернем полученную ссылку
                return img.imageUrl;
            } catch (ex) {
                console.log('Error upload img');
                console.log(ex);
            }

            return null;
        }

        /**
         * Таймер сна на указанное время в миллисекундах.
         * @param ms
         * @return {Promise<unknown>}
         */
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
    });
</script>
