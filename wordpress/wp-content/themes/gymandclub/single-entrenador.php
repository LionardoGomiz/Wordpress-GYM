<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package GymAndClub
 */

get_header();
?>
    <div id="primary" class="content-area col-md-12">
	<main id="primary" class="site-main">

<article id="post-<?php the_ID(); ?> <?php post_class();?>">
  <div class="row">
    <div class="col-md-5">
   <img src="<?php echo get_template_directory_uri() .'/img/imagen.png' ?>"/>
   <i class="fab fa-facebook-square fa-2x"></i>
   <i class="fab fa-twitter-square fa-2x"></i>
   <i class="fab fa-pinterest-square fa-2x"></i>
   <i class="fab fa-youtube-square fa-2x"></i>
   <i class="fab fa-linkedin-square fa-2x"></i>
    </div>
  </div>

<div class="col-md-4">
  <img src="<?php echo get_template_directory_uri() . '/'?>" alt="">
</div>


    <div class="col-md-8 detalle_entrenador">
      <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' );?>

      </header>
      <?php the_field('biografia'); ?>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
<h3>Perfil del entrenador><?php the_field('titulo_perfil_del_entrenador'); ?></h3>
<span>Nombre:</span> Bill Gates <br/>
<span>Edad:</span> 70 años <br/>
<?php
$date = get_field('edad',false, false);
$date = new DateTime($date);
echo $date->format('j/m/v');
?>
<span>Email:</span><?php the_field('email'); ?><br/>
<span>Especialidades:</span> Funk giu <br/>
<em>hp</em>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
        <h3 class="entry-title">Habilidades</h3>
    </div>
  </div>

    <div class="row">
      <div class="col-md-12">
        <p>Funk giu</p>
      <div class="progress">
    <div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">85%</div>
  </div>
</div>
    </div>
       </article>

<?php

get_footer();
