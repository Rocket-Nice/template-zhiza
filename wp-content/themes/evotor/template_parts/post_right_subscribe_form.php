<div class="top_sbs">
    <form class="new_subscribe_post" method="POST">
        <textarea id="textarea"
                  placeholder="Оставьте почту — пришлем ссылку на статью"
                  name="mail"
                  inputmode="email"></textarea>
        <input type="submit" value="Хочу статью на почту!">
    </form>
    <div class="sbs_info">
        <p>
            Нажимая кнопку, вы соглашаетесь <br/>
            <a href="https://evotor.ru/legal/pers-data/"
               target="_blank">
                с политикой персональных данных
            </a>
        </p>
        <p class="post_sbs_error">
            Опечатка, бывает. Проверьте<br/> адрес и попробуйте снова
        </p>
    </div>
</div>
<div class="sbs_succes">
    <p>Статья на почте. Но вы все <br/>равно ее не прочитаете, <br/>знаем мы вас</p>
</div>
<script>
    $(document).ready(function () {
        textarea.addEventListener('input', function (e) {
            textarea.value = textarea.value.replace(/(\r\n|\n|\r)/gm, "");
        })

        $("#textarea").keyup(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                $(".new_subscribe_post").submit()
            }
        });
    });
</script>
