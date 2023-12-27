<?php
/*
Template Name: About us
Файл шаблона страницы О нас
*/
get_template_part( 'header_redesign' );

// Основная информация расположенная под заголовком
$mainInfo = get_field('about_us_main_information');
$editorsContent = get_field('about_us_editors');
$editorsTeam = $editorsContent['editors_team'];
//
$togetherWithUs = get_field('about_us_together_with_us');
$togetherTeam = $togetherWithUs['together_with_us_repeater'];
$togetherTeamChunked = array_chunk($togetherTeam, 4);
//
$contacts = get_field('about_us_contacts');
$requisites = get_field('about_us_requisites');
?>

<main class="page-content page-about content-padding">
    <section class="new-wrapper mb-32">
        <div class="wrapper padding-top">
            <?php get_breadcrumb( 'breadcrumb__default-page page-pb-override' ) ?>
        </div>

        <h1 class="page-title f-48 mb-24">
            О проекте
        </h1>

        <div class="short--container about--container">
            <div class="content">
                <?= $mainInfo ?>
            </div>

            <div class="ads--info content">
                <p class="info">
                    По всем вопросам
                    <span>
                         <a href="mailto:zhiza@evotor.ru"> zhiza@evotor.ru</a>
                     </span>
                </p>
                <p class="info">
                    По вопросам рекламы
                    <span class="combined--link">
                         tg: <a href="https://t.me/kabudashka" target="_blank" rel="nofollow noopener">@kabudashka</a>
                     </span>
                </p>
            </div>
        </div>
    </section>

    <section class="new-wrapper mb-32">
        <h2 class="f-32 mb-24">
            <?= $editorsContent['editors_title'] ?>
        </h2>

        <div class="short--container content">
            <?= $editorsContent['editors_text-content'] ?>
        </div>

        <ul class="team">
            <?php foreach ($editorsTeam as $editor):

            $alt = $editor['editor_team_member_photo']['alt'];
            $name = '';
            $position = 'редактор';
            $link = null;
            $image = null;
            if ($editor['redactor_has_page']) {
                $author = $editor['select_redactor_page'];
                $name = $author->name;
                $link = '/o-proekte/' . $author->slug;
                $photo = get_field('author_image', $author);
                if (!empty($photo)) {
                    $image = wp_get_attachment_image_src($photo['ID'], 'collection_circle');
                }
            } else {
                $mem = $editor['no_page_redactor'];
                $name = $mem['editor_team_member_name'];
                $position = $mem['editor_team_member_position'];
                if (!empty($mem['editor_team_member_photo'])) {
                    $image = wp_get_attachment_image_src($mem['editor_team_member_photo']['ID'], 'collection_circle');
                }
            }
            ?>
                <li>
                    <img src="<?= $image[0] ?>"
                         alt="<?= $alt ?: $editor['editor_team_member_name'] ?>"
                         title="<?= $alt ?: $editor['editor_team_member_name'] ?>"
                         width="64" height="64" loading="lazy" decoding="async"
                    />
                    <div class="name-block">
                        <?php if (isset($link)): ?>
                            <a href="<?= $link ?>"><strong><?= $name ?></strong></a>
                        <?php else : ?>
                            <strong><?= $name ?></strong>
                        <?php endif; ?>
                        <p><?= $position ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="new-wrapper mb-40">
        <h2 class="f-32 mb-24">
            Вместе с нами
        </h2>

        <div class="together-with-us togetherSlider owl-carousel new-slider-nav">
            <?php foreach ($togetherTeamChunked as $chunk): ?>
            <div class="sliderItem">
            <?php foreach ($chunk as $member):
                $name = '';
                $position = 'автор';
                $link = null;
                if ($member['author_have_page']) {
                    $author = $member['author_page'];
                    $name = $author->name;
                    $link = '/o-proekte/' . $author->slug;
                } else {
                    $mem = $member['no_page_wrapper'];
                    $name = $mem['name'];
                    $position = $mem['position'];
                }
            ?>

                <?php if ($link): ?>
                <div class="name-block">
                    <a href="<?= $link ?>"><strong><?= $name ?></strong></a>
                    <p><?= $position ?></p>
                </div>
                <?php else: ?>
                <div class="name-block">
                    <strong><?= $name ?></strong>
                    <p><?= $position ?></p>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="new-wrapper mb-32 contacts-block">
        <h2 class="f-32 mb-24">
            <?= $contacts['contacts_title'] ?>
        </h2>

        <div class="short--container">
            <div class="content">
                <?= $contacts['contacts_content'] ?>
            </div>
        </div>
    </section>

    <section class="new-wrapper mb-32 requisites">
        <h2 class="f-32 mb-24">
            <?= $requisites['requisites_title'] ?>
        </h2>

        <div class="short--container">
            <div class="content">
                <?= $requisites['requisites_content'] ?>
            </div>
        </div>

        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Organization",
                "name": "«Жиза» — бизнес-блог для предпринимателей",
                "url": "https://zhiza.evotor.ru",
                "email": "zhiza@evotor.ru",
                "logo": "https://zhiza.evotor.ru/wp-content/themes/evotor/logo.png",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "Москва",
                    "postalCode": "119021",
                    "streetAddress": "ул. Тимура Фрунзе, д. 24, этаж 6"
                }
            }
        </script>
    </section>
</main>

<?php
get_template_part( 'footer_redesign' );
?>
