<?php
/**
 * The Template for displaying vehicle advanced search form
 *
 * @package ThemesDepot Framework
 */
?>

<section id="advanced-search-form">

	<div class="wrapper widget_tdp_vehicle_search" id="adv-form">
		
		<div class="form-inside">

			<?php
	
				$args = tdp_advanced_search_fields();
				$my_advanced_search = new WP_Advanced_Search($args);
				$my_advanced_search->the_form();
							
			?>

		</div>

	</div>
	
</section>