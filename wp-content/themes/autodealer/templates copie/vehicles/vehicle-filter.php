<?php
/**
 * Load vehicle filter template
*/

$active_option = null;
if( isset( $_GET[ 'vehicle_order' ] ) ) {  
    $active_option = $_GET[ 'vehicle_order' ];  
} else {
	$active_option = null;
} 

$active_view = null;
if( isset( $_GET[ 'vehicle_view' ] ) ) {  
    $active_view = $_GET[ 'vehicle_view' ];  
} else {
	$active_view = null;
}

?>

<?php if(get_field('display_vehicles_view_filter','option')) { ?>
	
	<section id="vehicle-filter" class="block">
			
		<div class="one_half">
			<?php if(get_field('display_advanced_search_form_in_taxonomy','option')) {?>
			<a href="#" id="display-advanced-form" class="btn small white"><i class="icon-search-1"></i> <?php _e('Display Advanced Search Filter &raquo;','framework');?></a>
			<?php } ?>
			<h6><i class="icon-list"></i> <?php printf( __( '%d vehicles matching your criteria.', 'framework' ), $wp_query->found_posts, $the_tax->labels->name );  ?></h6>
		</div>

		<div class="one_half last">

			<form id="vehicle-filter-form">

				<label><?php _e('Sort By:','framework');?></label>
				<select class="filter-select">
					<option value="<?php echo add_query_arg( 'vehicle_order', 'last' );?>" <?php if($active_option == '' || $active_option == 'last') { echo 'selected="selected" '; } ?>><?php _e('Last Added','framework');?></option>
					<option value="<?php echo add_query_arg( 'vehicle_order', 'price_high' );?>" <?php echo $active_option == 'price_high' ? 'selected="selected" ' : ''; ?>><?php _e('Price High-Low','framework');?></option>
					<option value="<?php echo add_query_arg( 'vehicle_order', 'price_low' );?>" <?php echo $active_option == 'price_low' ? 'selected="selected" ' : ''; ?>><?php _e('Price Low-High','framework');?></option>
					<option value="<?php echo add_query_arg( 'vehicle_order', 'names_az' );?>" <?php echo $active_option == 'names_az' ? 'selected="selected" ' : ''; ?>><?php _e('Name A-Z','framework');?></option>
					<option value="<?php echo add_query_arg( 'vehicle_order', 'names_za' );?>" <?php echo $active_option == 'names_za' ? 'selected="selected" ' : ''; ?>><?php _e('Name Z-A','framework');?></option>
				</select>


				<div id="view-filter" class="filter-select">

					<a title="<?php _e('Display Vehicles In A List','framework');?>" href="<?php echo add_query_arg( 'vehicle_view', 'list' );?>" <?php if($active_view == '' || $active_view == 'list') { echo 'class="active" '; } ?> ><i class="icon-th-list" title="<?php _e('List View','framework');?>"></i></a>
					<a title="<?php _e('Display Vehicles In A Grid','framework');?>" href="<?php echo add_query_arg( 'vehicle_view', 'grid' );?>" <?php echo $active_view == 'grid' ? 'class="active" ' : ''; ?> ><i class="icon-th" title="<?php _e('Grid View','framework');?>"></i></a>
					
					<?php if(get_field('enable_map_system','option')) : ?>
					<a title="<?php _e('Display Vehicles In A Map','framework');?>" href="<?php echo add_query_arg( 'vehicle_view', 'map' );?>" <?php echo $active_view == 'map' ? 'class="active" ' : ''; ?> ><i class="icon-location" title="<?php _e('Location View','framework');?>"></i></a>
					<?php endif; ?>
				</div>


			</form>

		</div>

		<div class="clear"></div>

	</section>

	<script>
        var getElementsByClassName=function(a,b,c){if(document.getElementsByClassName){getElementsByClassName=function(a,b,c){c=c||document;var d=c.getElementsByClassName(a),e=b?new RegExp("\\b"+b+"\\b","i"):null,f=[],g;for(var h=0,i=d.length;h<i;h+=1){g=d[h];if(!e||e.test(g.nodeName)){f.push(g)}}return f}}else if(document.evaluate){getElementsByClassName=function(a,b,c){b=b||"*";c=c||document;var d=a.split(" "),e="",f="http://www.w3.org/1999/xhtml",g=document.documentElement.namespaceURI===f?f:null,h=[],i,j;for(var k=0,l=d.length;k<l;k+=1){e+="[contains(concat(' ', @class, ' '), ' "+d[k]+" ')]"}try{i=document.evaluate(".//"+b+e,c,g,0,null)}catch(m){i=document.evaluate(".//"+b+e,c,null,0,null)}while(j=i.iterateNext()){h.push(j)}return h}}else{getElementsByClassName=function(a,b,c){b=b||"*";c=c||document;var d=a.split(" "),e=[],f=b==="*"&&c.all?c.all:c.getElementsByTagName(b),g,h=[],i;for(var j=0,k=d.length;j<k;j+=1){e.push(new RegExp("(^|\\s)"+d[j]+"(\\s|$)"))}for(var l=0,m=f.length;l<m;l+=1){g=f[l];i=false;for(var n=0,o=e.length;n<o;n+=1){i=e[n].test(g.className);if(!i){break}}if(i){h.push(g)}}return h}}return getElementsByClassName(a,b,c)},
            dropdowns = document.getElementsByTagName( 'select' );
        for ( i=0; i<dropdowns.length; i++ )
            if ( dropdowns[i].className.match( 'filter-select' ) ) dropdowns[i].onchange = function(){ if ( this.value != '' ) window.location.href = this.value; }
    </script>

<?php } ?>