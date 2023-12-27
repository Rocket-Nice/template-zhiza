<?php
the_post();
switch (get_the_ID()){
    case 5:
        get_template_part('page','cart');
        break;
    case 6:
        get_template_part('page','checkout');
        break;
    case 15:
        get_template_part('page','gallery');
        break;
    case 7:
        get_template_part('page','account');
        break;
    default:
        get_template_part('page','default');
        break;
}