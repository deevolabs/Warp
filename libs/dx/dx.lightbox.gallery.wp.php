<?php 
#-----------------------------------------------------------------#
# Lightbox Gallery
#-----------------------------------------------------------------#
function addLightboxGallery(){

  ob_start();
  ?>
  <div class='lightbox_gallery_component'>
    <div class='lightbox_overlay'></div>
    <div class='lightbox_container'>
      <a href='#' class='btClose'><span class="icon-cross"></span></a>

      <div class='lightbox_content'>      

        <div class="flexcolumn">          
          
          <div class="main_painel flexrow">
            <div class="projectInfo">
            <div class="content">
              
              <h2>Titulo</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem assumenda labore quia nobis nihil tempora praesentium distinctio, id, quibusdam est.</p>
            </div>  

            </div>
            <div class="imageBox">
              <div class="content"></div>         
            </div>
          </div>
          
          <div class="bottom_painel flexrow">
              <div class="thumbscroller horizontal">
                <ul>
                </ul>
              </div>
          </div> 
        
        </div>


        </div>


    </div>
  </div>
  <?php
  $output = ob_get_contents();
  ob_end_clean();

  echo $output;

}
add_action('wp_footer', 'addLightboxGallery',30);


function LightboxGalleryloadScripts(){
  wp_register_style('dx.lightbox.gallery',get_template_directory_uri() . '/libs/dx/dx.lightbox.gallery.css');
  wp_register_script('dx.lightbox.gallery',get_template_directory_uri() . '/libs/dx/dx.lightbox.gallery.js', 'jquery'
    );

  wp_enqueue_style( 'dx.lightbox.gallery' );
  wp_enqueue_script( 'slick' );       
  wp_enqueue_style( 'slick' );       
  wp_enqueue_style( 'slick-theme' );       
  wp_enqueue_script( 'dx.lightbox.gallery' );       
}

add_action('wp_enqueue_scripts', 'LightboxGalleryloadScripts');


?>