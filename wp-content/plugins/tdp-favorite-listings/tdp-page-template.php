<h2><i class="icon-star"></i> <?php _e('Favorites Vehicles','tdp');?></h2>

<table class="shop_table sf-table striped_bordered">
    <thead>
        <tr>
            <th scope="col"><?php _e('Vehicle Name','tdp');?></th>
            <th scope="col"><?php _e('Actions','tdp');?></th>
        </tr>
    </thead>
    <tbody>

<?php
    
    if ($favorite_post_ids) {
		$favorite_post_ids = array_reverse($favorite_post_ids);
        $post_per_page = 9999;
        $page = intval(get_query_var('paged'));

        $qry = array( 'post_type' => 'vehicles', 'post__in' => $favorite_post_ids, 'posts_per_page'=> $post_per_page, 'orderby' => 'post__in', 'paged' => $page);
        query_posts($qry);

        while ( have_posts() ) : the_post(); ?>
                    
                    <tr>
                        <td>
                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                        </td>
                        <td>
                            <?php tdp_remove_favorite_link(get_the_ID()); ?>
                        </td>
                    </tr>
               <?php endwhile;


        wp_reset_query();
    } else {
        _e('No favorites available yet.','tdp');
    }

    ?>
        </tbody>
</table>