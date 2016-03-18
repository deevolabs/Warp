<?php 

#-----------------------------------------------------------------#
/*
Picture Gallery Component Rendering
Este componente pode ser renderizado de várias formas:
1) Manualmente, com HTML hardcoded
2) Através do editor de galeria de imagem nativo do wordpress.
3) Em forma de componente do visual composer 

TODO: Adaptar o código abaixo aos cenários acima. Hoje ele funciona no cenário 2)  
*/ 
#-----------------------------------------------------------------#

remove_shortcode('gallery');
add_shortcode('gallery', 'parse_gallery_shortcode');
function parse_gallery_shortcode($atts) {

    global $post;

    if ( ! empty( $atts['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $atts['orderby'] ) )
            $atts['orderby'] = 'post__in';
        $atts['include'] = $atts['ids'];
    }

    extract(shortcode_atts(array(
        'orderby' => 'menu_order ASC, ID ASC',
        'include' => '',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'link' => 'file'
    ), $atts));


    $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'post_mime_type' => 'image',
        'orderby' => $orderby
    );

    if ( !empty($include) )
        $args['include'] = $include;
    else {
        $args['post_parent'] = $id;
        $args['numberposts'] = -1;
    }

    $images = get_posts($args);


    

    $i = 1;
    $gallery = '';

 
    foreach ( $images as $image ) {
        $caption = $image->post_excerpt;
        $description = $image->post_content;
        if($description == '') $description = $image->post_title;

        $image_alt = get_post_meta($image->ID,'_wp_attachment_image_alt', true);

        // render your gallery here
        $thumbUrl = wp_get_attachment_image_src($image->ID, 'thumbnail');
        $mediumUrl = wp_get_attachment_image_src($image->ID, 'medium');
        $largeUrl = wp_get_attachment_image_src($image->ID, 'large');
        $fullUrl = wp_get_attachment_image_src($image->ID, 'full');



        if($fullUrl[1]>$fullUrl[2]){ //landscape
          $class="landscape";
        }else{$class="portrait";}
        //$gallery .=  '<li data-caption="'.$caption.'" data-format="'. $class .'" data-id="'.$i.'" data-url-medium="'.$mediumUrl[0].'" data-url-large="'.$largeUrl[0].'" data-url-full="'.$fullUrl[0].'"><img src="'.$thumbUrl[0].'" alt="" /></li>';
   

        $gallery .= '<li>
                        <div class="post">                      
                            <div class="post-thumb">
                                <a href="'.$largeUrl[0].'" class="" title="" data-large-img="'.$largeUrl[0].'" data-caption="'.$caption.'">
                                    <img alt="" src="'.$thumbUrl[0].'">
                                </a>
                            </div>
                        </div>
                    </li>';
        $i++;
    }



    $firstImage = $images[0];
    $firstImageSrc = wp_get_attachment_image_src($firstImage->ID, 'large');


    $viewport = '<div class="gallery">
                    <div class="viewport">
                        <div class="preloader"></div>
                        <img src="'.$firstImageSrc[0].'" data-id="1" />
                        <a class="navigation nav-prev icon-arrow-left3 vertical_center" href="#"></a>
                        <a class="navigation nav-next icon-arrow-right3 vertical_center" href="#"></a>
                    </div>';


    $ts1 = '<div class="post_scroller" data-mode="horizontal" data-per-view="6" data-interval="0">  
                <div class="wrapper">       
                    <div class="scroller_wrapper">          
                        <ul>';
    $ts2 = '</ul></div></div></div><div class="legenda">'.$caption .'</div></div>';

    return $viewport.$ts1.$gallery.$ts2;
}











 ?>