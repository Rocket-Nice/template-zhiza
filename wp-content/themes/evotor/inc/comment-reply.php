<?php

function enqueue_comment_reply() {
    if( is_singular() )
        wp_enqueue_script('comment-reply');
}
add_action( 'wp_enqueue_scripts', 'enqueue_comment_reply' );

function zhiza_comment_reply_link_args_filter( $args, $comment, $post ){
    $args["reply_to_text"] = "Ответ на комментарий %s";
    return $args;
}

add_filter( 'comment_reply_link_args', 'zhiza_comment_reply_link_args_filter', 10, 3 );
