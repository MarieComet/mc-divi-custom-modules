<?php
// Get parent categories with schema.org data
  function seomix_content_get_category_parents($id, $link = false,$separator = '/',$nicename = false,$visited = array()) {
  $final = '';
  $parent = &get_category($id);
  if (is_wp_error($parent))
    return $parent;
  if ($nicename)
    $name = $parent->name;
  else
    $name = $parent->cat_name;
  if ($parent->parent && ($parent->parent != $parent->term_id ) && !in_array($parent->parent, $visited)) {
    $visited[] = $parent->parent;
    $final .= seomix_content_get_category_parents( $parent->parent, $link, $separator, $nicename, $visited );
  }
  if ($link)
    $final .= '<span typeof="v:Breadcrumb"><a href="' . get_category_link( $parent->term_id ) . '" title="Voir tous les articles de '.$parent->cat_name.'" rel="v:url" property="v:title">'.$name.'</a></span>' . $separator;
  else
    $final .= $name.$separator;
  return $final;
}

  // Breadcrumb
  function seomix_content_breadcrumb() {
  // Global vars
  global $wp_query;
  $paged = get_query_var('paged');
  $sep = ' > ';
  $data = '<span typeof="v:Breadcrumb">';
  $dataend = '</span>';
  $final = '
<div xmlns:v="http://rdf.data-vocabulary.org/#">';  
  $startdefault = $data.'<a title="'. get_bloginfo('name') .'" href="'.home_url().'" rel="v:url" property="v:title">'. get_bloginfo('name') .'</a>'.$dataend;
  $starthome = 'Accueil de '. get_bloginfo('name');

  // Breadcrumb start
  if ( is_front_page() && is_home() ){
    // Default homepage
    if ( $paged >= 1 )    
      $final .= $startdefault;
    else
      $final .= $starthome;
  } elseif ( is_front_page() ){
    //Static homepage
    $final .= $starthome;
  } elseif ( is_home() ){
    //Blog page
    if ( $paged >= 1 ) {   
      $url = get_page_link(get_option('page_for_posts'));  
      $final .= $startdefault.$sep.$data.'<a href="'.$url.'" rel="v:url" property="v:title" title="Les articles">Les articles</a>'.$dataend;}
    else
      $final .= $startdefault.$sep.'Les articles';
  } else {
    //everyting else
    $final .= $startdefault.$sep;}

  // Prevent other code to interfer with static front page et blog page
  if ( is_front_page() && is_home() ){// Default homepage
  } elseif ( is_front_page()){//Static homepage
  } elseif ( is_home()){//Blog page
  }
  //Attachment
  elseif ( is_attachment()){
    global $post;
    $parent = get_post($post->post_parent);
    $id = $parent->ID;
    $category = get_the_category($id);
    $category_id = get_cat_ID( $category[0]->cat_name );
    $permalink = get_permalink( $id );
    $title = $parent->post_title;
    $final .= seomix_content_get_category_parents($category_id,TRUE,$sep).$data."<a href='$permalink' rel='v:url' property='v:title' title='$title'>$title</a>".$dataend.$sep.the_title('','',FALSE);}
  // Post type
  elseif ( is_single() && !is_singular('post')){
     global $post;
     $nom = get_post_type($post);
     $archive = get_post_type_archive_link($nom);
     $mypost = $post->post_title;
     $final .= $data.'<a href="'.$archive.'" rel="v:url" property="v:title" title="'.$nom.'">'.$nom.'</a>'.$dataend.$sep.$mypost;}
  //post
  elseif ( is_single()){
    // Post categories
    $category = get_the_category();
    $category_id = get_cat_ID( $category[0]->cat_name );
    if ($category_id != 0)
      $final .= seomix_content_get_category_parents($category_id,TRUE,$sep);
    elseif ($category_id == 0) {
      $post_type = get_post_type();
      $tata = get_post_type_object( $post_type );
      $titrearchive = $tata->labels->menu_name;
      $urlarchive = get_post_type_archive_link( $post_type );
      $final .= $data.'<a class="breadl" href="'.$urlarchive.'" title="'.$titrearchive.'" rel="v:url" property="v:title">'.$titrearchive.'</a>'.$dataend;}
    // With Comments pages
    $cpage = get_query_var( 'cpage' );
    if (is_single() && $cpage > 0) {
      global $post;
      $permalink = get_permalink( $post->ID );
      $title = $post->post_title;
      $final .= $data."<a href='$permalink' rel='v:url' property='v:title' title='$title'>$title</a>".$dataend;
      $final .= $sep."Commentaires page $cpage";}
    // Without Comments pages
    else
      $final .= the_title('','',FALSE);}
  // Categories
  elseif ( is_category() ) {
    // Vars
    $categoryid       = $GLOBALS['cat'];
    $category         = get_category($categoryid);
    $categoryparent   = get_category($category->parent);
    //Render
    if ($category->parent != 0) 
      $final .= seomix_content_get_category_parents($categoryparent, true, $sep, true);
    if ( $paged <= 1 )
      $final .= single_cat_title("", false);
    else
      $final .= $data.'<a href="' . get_category_link( $category ) . '" title="Voir tous les articles de '.single_cat_title("", false).'" rel="v:url" property="v:title">'.single_cat_title("", false).'</a>'.$dataend;}
  // Page
  elseif ( is_page() && !is_home() ) {
    $post = $wp_query->get_queried_object();
    // Simple page
    if ( $post->post_parent == 0 )
      $final .= the_title('','',FALSE);
    // Page with ancestors
    elseif ( $post->post_parent != 0 ) {
      $title = the_title('','',FALSE);
      $ancestors = array_reverse(get_post_ancestors($post->ID));
      array_push($ancestors, $post->ID);
      $count = count ($ancestors);$i=0;
      foreach ( $ancestors as $ancestor ){
        if( $ancestor != end($ancestors) ){
          $name = strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) );
          $final .= $data.'<a title="'.$name.'" href="'. get_permalink($ancestor) .'" rel="v:url" property="v:title">'.$name.'</a>'.$dataend;
          $i++;
          if ($i < $ancestors)
            $final .= $sep;
        }
        else 
          $final .= strip_tags(apply_filters('single_post_title',get_the_title($ancestor)));
        }}}
  // authors
  elseif ( is_author() ) {
    if(get_query_var('author_name'))
        $curauth = get_user_by('slug', get_query_var('author_name'));
    else
        $curauth = get_userdata(get_query_var('author'));
    $final .= "Articles de l'auteur ".$curauth->nickname;}  
  // tags
  elseif ( is_tag() ){
    $final .= "Articles sur le thème ".single_tag_title("",FALSE);}
  // Search
  elseif ( is_search() ) {
    $final .= "Résultats de votre recherche sur \"".get_search_query()."\"";}    
  // Dates
  elseif ( is_date() ) {
    if ( is_day() ) {
      $year = get_year_link('');
      $final .= $data.'<a title="'.get_query_var("year").'" href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
      $month = get_month_link( get_query_var('year'), get_query_var('monthnum') );
      $final .= $sep.$data.'<a title="'.single_month_title(' ',false).'" href="'.$month.'" rel="v:url" property="v:title">'.single_month_title(' ',false).'</a>'.$dataend;
      $final .= $sep."Archives pour ".get_the_date();}
    elseif ( is_month() ) {
      $year = get_year_link('');
      $final .= $data.'<a title="'.get_query_var("year").'" href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
      $final .= $sep."Archives pour ".single_month_title(' ',false);}
    elseif ( is_year() )
      $final .= "Archives pour ".get_query_var('year');}
  // 404 page
  elseif ( is_404())
    $final .= "404 Page non trouvée";
  // Other Archives
  elseif ( is_archive() ){
    $posttype = get_post_type();
    $posttypeobject = get_post_type_object( $posttype );
    $taxonomie = get_taxonomy( get_query_var( 'taxonomy' ) );
    $titrearchive = $posttypeobject->labels->menu_name;
    if (!empty($taxonomie))
      $final .= $taxonomie->labels->name;
    else
      $final .= $titrearchive;}
  // Pagination
  if ( $paged >= 1 )
    $final .= $sep.'Page '.$paged;
  // The End
  $final .= '</div>';
 return $final;
}