<?php

/**
 * Plugin Name: Mi primer Plugin
 * Descriptiom: Lab2
 * Version: 1.0
 * Author: Juan Luis Navarro Nuñez
 */

function mi_funcion_de_accion()
{
   echo '<p> Hola estoy en el footer</p>';
}
add_action('wp_footer', 'mi_funcion_de_accion');

function mi_funcion_de_filtro($content)
{
   return $content . '</p>Esto esta en todos los contenidos</p>';
}
add_filter('the_content', 'mi_funcion_de_filtro');

function mi_primer_shortcode()
{
   return  '<p>Mi <strong>Shortcode</strong></p>';
}
add_shortcode('mi_shortcode_x', 'mi_primer_shortcode');

function mostrar_lista_de_publicaciones()
{
   $publicaciones = new WP_Query(array('post_type' => 'post'));
   $content = '<ul class="publicaciones">';
   if ($publicaciones->have_posts()) {
      while ($publicaciones->have_posts()) {
         $publicaciones->the_post();
         $content .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
      }
   }
   wp_reset_postdata();
   $content .= '</ul>';

   return $content;
}
add_shortcode('lista_pub', 'mostrar_lista_de_publicaciones');

function mostrar_pokemon()
{
   $url = 'https://pokeapi.co/api/v2/pokemon?limit=151';

   $reponse = wp_remote_get($url);

   if (is_wp_error($reponse)) {
      return $reponse->get_error_message();
   }

   $pokemon = json_decode(wp_remote_retrieve_body($reponse));

   $content = '<ul class="pokemon">';
   foreach ($pokemon->results as $pk) {
      $content .= '<li>' . $pk->name . '</li>';
   }

   $content .= '</ul>';


   return $content;
}
add_shortcode('pokemon', 'mostrar_pokemon');
