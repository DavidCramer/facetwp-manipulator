<?php
/**
 * Hook sample code for editor.
 *
 * @package   fwpmanip
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 *
 */
?>
<script type="text/html" id="documentation_viewer">
{{#each this}}
	<div style="margin: -12px; padding: 12px 14px; background: rgb(246, 246, 246) none repeat scroll 0% 0%;"><a href="{{link}}" target="_blank">{{link}}</a></div>
	{{{content.rendered}}}
{{/each}}
</script>


<script type="text/x-php" data-hook="facetwp_index_row">
/**
 * Available Parameters
 * $params | array | An associative array of data to be indexed
 * $class | object | The indexer class (e.g. use $class->insert() to manually add rows)
 */
if ( 'my_date' == $params['facet_name'] ) {
    $raw_value = $params['facet_value'];
    $params['facet_display_value'] = date( 'M j, Y', strtotime( $raw_value ) );
}
return $params;
</script>
<script type="text/x-php" data-hook="facetwp_indexer_query_args">
/**
 * Available Parameters
 * $args | array | An array of WP_Query arguments
 */
$args['post_status'] = array( 'publish', 'inherit' );
return $args;
</script>
<script type="text/x-php" data-hook="facetwp_query_args">
/**
 * Available Parameters
 * $query_args | array | An associative array of query arguments
 * $class | object | The FacetWP_Facet class and all properties (see /includes/class-facet.php)
 */
if ( 'your_template' == $class->ajax_params['template'] ) {
    $query_args['orderby'] = 'title';
    $query_args['order'] = 'asc';
}
return $query_args;
</script>
<script type="text/x-php" data-hook="facetwp_pre_filtered_post_ids">
/**
 * Available Parameters
 * $post_ids | array | An array of post IDs
 * $class | object | The FacetWP_Facet class (see /includes/class-facet.php)
 */
// your own logic to get / remove ids
return $post_ids;
</script>
<script type="text/x-php" data-hook="facetwp_filtered_post_ids">
/**
 * Available Parameters
 * $post_ids | array | An array of post IDs
 * $class | object | The FacetWP_Facet class (see /includes/class-facet.php)
 */
// your own logic to get / remove ids
return $post_ids;
</script>
<script type="text/x-php" data-hook="facetwp_facet_orderby">
/**
 * Available Parameters
 * $orderby | string | The original “ORDER BY”
 * $facet | array | An array of facet properties
 */
if ( 'my_facet' == $facet['name'] ) {
    $orderby = 'f.facet_display_value+0 ASC';
}
return $orderby;
</script>
<script type="text/x-php" data-hook="facetwp_facet_filter_posts">
/**
 * Available Parameters
 * $return | mixed | FALSE (default), or an array of post IDs
 * $params | An associative array of parameters
 */
$selected_values = $params['selected_values'];

if ( 'availability' == $params['facet']['name'] ) {
    $start_date = $selected_values[0];
    $end_date = $selected_values[1];

    // get post IDs of available rooms between these dates
    $post_ids = fake_get_available_rooms( $start_date, $end_date );
    return $post_ids;
}
return $return;
</script>
<script type="text/x-php" data-hook="facetwp_facet_render_args">
/**
 * Available Parameters
 * $args | array | An associative array of facet render arguments
 */
if ( 'model_year' == $args['facet']['name'] ) {
    $args['selected_values'] = array( '2015' );
}
return $args;
</script>
<script type="text/x-php" data-hook="facetwp_is_main_query">
/**
 * Available Parameters
 * $is_main_query | boolean | Whether FacetWP should use the current query
 * $query | object | The WP_Query object
 */
if ( isset( $query->query_vars['facetwp'] ) ) {
    $is_main_query = (bool) $this->query_vars['facetwp'];
}
return $is_main_query;
</script>
<script type="text/x-php" data-hook="facetwp_template_use_archive">
/**
 * Available Parameters
 * $use_archive | boolean | Should FacetWP pre-filter?
 */
 // optionally, your own logic to determine if true or false.
return true;
</script>
<script type="text/x-php" data-hook="facetwp_facet_html">
/**
 * Available Parameters
 * $output | string | The facet HTML
 * $params | array | An associative array of facet settings
 */
if ( 'my_facet' == $params['facet']['name'] ) {
    $output = 'some HTML';
}
return $output;
</script>
<script type="text/x-php" data-hook="facetwp_template_html">
/**
 * Available Parameters
 * $output | mixed | The output HTML (or false to use the default HTML)
 * $class | object | The FacetWP_Facet class and all properties (see /includes/class-facet.php)
 */
global $wp_query;
$wp_query = $class->query;
$output = '';
while ( have_posts() ){
    the_post();
    $output .= '<p><a href="' . get_the_permalink() . '">' . get_the_title(). '</a></p>';
}
return $output;
</script>
<script type="text/x-php" data-hook="facetwp_pager_html">
/**
 * Available Parameters
 * $output | string | The pager HTML
 * $params | array | An associative array of pagination settings
 */
 // your own logic to build the pager HTML
return $output;
</script>
<script type="text/x-php" data-hook="facetwp_per_page_options">
/**
 * Available Parameters
 * $options | array | An associative array of integers
 */
return array( 5, 10, 25, 50, 100, 250 );
</script>
<script type="text/x-php" data-hook="facetwp_result_count">
/**
 * Available Parameters
 * $output | string | The result count HTML
 * $params | array | An associative array of result count settings
 */
$output = $params['lower'] . '-' . $params['upper'] . ' of ' . $params['total'] . ' results';
return $output;
</script>
<script type="text/x-php" data-hook="facetwp_sort_options">
/**
 * Available Parameters
 * $options | array | Options array
 * $params | array | Associative array of extra input variables
 */
// Remove the “Date (Oldest)” sort option
unset( $options['date_asc'] );
// Change the sort label
$options['default']['label'] = 'My sort label';
// Add a “Price (Highest)” sort option
$options['price_desc'] = array(
    'label' => 'Price (Highest)',
    'query_args' => array(
        'orderby' => 'meta_value_num',
        'meta_key' => 'edd_price',
        'order' => 'DESC',
    )
);
return $options;
</script>
<script type="text/x-php" data-hook="facetwp_sort_html">
/**
 * Available Parameters
 * $html | string | The sort box output
 * $params | array | Associative array of extra variables
 */
$html = '<select class="facetwp-sort-select">';
foreach ( $params['sort_options'] as $key => $atts ) {
    $html .= '<option value="' . $key . '">' . $atts['label'] . '</option>';
}
$html .= '</select>';
return $html;
</script>
<script type="text/x-php" data-hook="facetwp_render_output">
/**
 * Available Parameters
 * $output | array | An associative array of output data
 * $params | array | An associative array of input parameters
 */
$output['settings']['price']['start'] = array( 500, 1000 );
return $output;
</script>
<script type="text/x-php" data-hook="facetwp_assets">
/**
 * Available Parameters
 * $assets | array | An associative array of assets to load
 */
// Add your own custom javascript file to facet pages:
$assets['custom.js'] = 'URL/TO/YOUR/custom.js';
// remove an existing file:
unset( $assets['event-manager.js'] );

return $assets;
</script>
<script type="text/x-php" data-hook="facetwp_facet_types">
/**
 * Available Parameters
 * $facet_types | array | An array of facet type objects
 * See: https://facetwp.com/how-to-create-custom-facet-types/
 */
$facet_types['my_custom_facet'] = new \My_Custom_Facet_Type();
return $facet_types;
</script>
<script type="text/x-php" data-hook="facetwp_facet_sources">
/**
 * Available Parameters
 * $sources | array | An associative array of data sources
 */
$sources['custom_fields']['choices']['cf/my_data'] = 'my_data';
return $sources;
</script>
<script type="text/x-php" data-hook="facetwp_facets">
/**
 * Available Parameters
 * $facets | array | An array of existing facets
 */
$facets[] = array(
    'label' => 'My Search',
    'name' => 'my_search',
    'type' => 'search',
    'search_engine' => '',
    'placeholder' => 'Enter keywords',
);
return $facets;
</script>
<script type="text/x-php" data-hook="facetwp_i18n">
/**
 * Available Parameters
 * $string | string | The string to translate
 */
$lang = FWP()->facet->http_params['lang'];

// manual translations
$translations = array();
$translations['es']['Any'] = 'Cualquier';
$translations['de']['Any'] = 'Jeder';
$translations['es']['Enter keywords'] = 'Introduzca las palabras clave';
$translations['de']['Enter keywords'] = 'Geben Sie Schlüsselwörter';

if ( isset( $translations[ $lang ][ $string ] ) ) {
    return $translations[ $lang ][ $string ];
}

return $string;
</script>
