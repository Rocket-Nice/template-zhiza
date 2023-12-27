<?php if ( comments_open() ) : ?>
    <h3 class="comment_block__title">
        Что скажете?
    </h3>
    <?php if ( get_comments_number() !== 0 ) : ?>
        <ul class="comment_list">
            <?php
            function verstaka_comment( $comment, $args, $depth ) {
                $GLOBALS['comment'] = $comment; ?>
                <li id="li-comment-<?php comment_ID() ?>" <?php comment_class( 'comment_item' ); ?>>

                    <div id="comment-<?php comment_ID(); ?>" class="comment_item__container">
                        <?php if ( $comment->comment_approved === '0' ) : ?>
                            <div class="comment_awaiting">
                                <?php _e( 'Your comment is awaiting moderation.' ) ?>
                            </div>
                        <?php endif; ?>
                        <?php if ( $comment->comment_parent != 0 ) {
                            $parent = get_comment( $comment->comment_parent )
                            ?>
                            <div class="comment_parent">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_4059_8391" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="2"
                                          y="2" width="11" height="12">
                                        <path
                                            d="M12.1946 10.4733L9.1413 13.5266C8.8813 13.7866 8.45464 13.7866 8.19463 13.5266C7.93464 13.2666 7.93464 12.84 8.19463 12.58L10.1146 10.6666H3.33464C2.96797 10.6666 2.66797 10.3666 2.66797 9.99996V3.33329C2.66797 2.96663 2.96797 2.66663 3.33464 2.66663C3.7013 2.66663 4.0013 2.96663 4.0013 3.33329V9.33329H10.1146L8.19463 7.41996C7.93464 7.15996 7.93464 6.73329 8.19463 6.47329C8.45464 6.21329 8.8813 6.21329 9.1413 6.47329L12.1946 9.52663C12.4546 9.78663 12.4546 10.2133 12.1946 10.4733Z"
                                            fill="black"/>
                                    </mask>
                                    <g mask="url(#mask0_4059_8391)">
                                        <rect width="16" height="16" fill="#727272"/>
                                    </g>
                                </svg>
                                <span>в ответ</span>
                                <span class="comment_parent__name">
                                    <?= $parent->comment_author ?>
                                </span>
                            </div>
                        <?php } ?>
                        <div class="comment_author vcard">
                            <?php printf( __( '<cite class="comment_author__name">%s</cite>' ), get_comment_author_link() ) ?>

                            <span class="comment_rhombus">
                                <svg width="6" height="6" viewBox="0 0 6 6" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect y="3" width="4" height="4" transform="rotate(-45 0 3)" fill="#DF5B35"/>
                                </svg>
                            </span>

                            <?php printf( __( '<cite class="comment_author__date">%1$s, %2$s</cite>' ), get_comment_date( 'd.m.Y' ), get_comment_time( 'H:i' ) ) ?>
                        </div>

                        <?php comment_text() ?>

                        <div class="comment_reply">
                            <?php
                            comment_reply_link( array_merge( $args, array(
                                'add_below' => 'li-comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth']
                            ) ), get_comment_ID(), get_the_ID() ) ?>
                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php $args = array(
                'reply_text' => 'Ответить',
                'callback'   => 'verstaka_comment'
            );
            wp_list_comments( $args ); ?>
        </ul>
    <?php endif; ?>

    <?php
    $key = get_option( 'sgr_site_key' );
    //
    //    function add_google_recaptcha($submit_field) {
    //        $key = get_option('sgr_site_key');
    //        $submit_field['submit_field'] = '<div class="g-recaptcha" data-sitekey="$key"></div><br>' . $submit_field['submit_field'];
    //        return $submit_field;
    //    }
    //    if (!is_user_logged_in()) {
    //        add_filter('comment_form_defaults','add_google_recaptcha');
    //    }

    $consent = "";

    $fields = array(
        'author'  => '<div class="comment_bot"><p class="comment-form-author"><input class="comment_input" type="text" id="author" name="author" class="author" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="Имя" pattern="[A-Za-zА-Яа-я]{3,}" maxlength="30" autocomplete="on" tabindex="1" required></p>',
        'email'   => '<p class="comment-form-email"><input class="comment_input" type="email" id="email" name="email" class="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="Электронная почта" maxlength="30" autocomplete="on" tabindex="2" required></p></div>',
        "<div class='g-recaptcha' data-sitekey='$key'></div>",
        'cookies' => '<p class="comment-form-cookies-consent comment_consent">
                         <label for="wp-comment-cookies-consent" class="comment_lable">
                             ' . sprintf( '<input id="wp-comment-cookies-consent" class="comment_checkbox" name="wp-comment-cookies-consent" type="checkbox" value="yes" %s />', $consent ) . '
                             <span class="comment_checkbox comment_checkbox__custom"></span> ' . __( 'Save my name, email, and website in this browser for the next time I comment.' ) . '
                         </label>
                    </p>',
        //'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label><input type="url" id="url" name="url" class="site" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="www.example.com" maxlength="30" tabindex="3" autocomplete="on"></p>'
    );

    $args = array(
        'comment_notes_after'  => '',
        'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" class="comment-form" cols="45" rows="8" aria-required="true" placeholder="Поделитесь с нами вашим мнением о статье"></textarea></p>',
        'label_submit'         => 'Отправить',
        'class_submit'         => 'comment_submit',
        'submit_field'         => '<p class="form-submit comment_submit__container">%1$s %2$s</p>',
        'comment_notes_before' => '',
        'title_reply_before'   => '<h3 id="reply-title" class="comment_reply_title">',
        'title_reply'          => '',
        'cancel_reply_link'    => 'Отменить ответ',
        //        'cancel_reply_before' => '<span class="comment_cancel">',
        //        'cancel_reply_after' => '</span>',
        'cancel_reply_before'  => ' <span class="comment_cancel">',
        'cancel_reply_after'   => '</span>',
        'fields'               => apply_filters( 'comment_form_default_fields', $fields )
    );
    comment_form( $args );

    ?>
<?php endif; ?>
