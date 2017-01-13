<?php
/**
 * Config Array for General
 *
 * @package   evenotebuilder
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */

return array(
	'label' => __( 'General', 'facetwp-manipulator' ),
	'grid'  => array(
		'id'  => 'gen_config',
		'row' => array(
			array(
				'column' => array(
					array(
						'size'    => 'col-xs-4',
						'control' => array(
							'event' => array(
								'label'       => __( 'FacetWP Filter', 'facetwp-manipulator' ),
								'description' => __( 'View Documentation', 'facetwp-manipulator' ),
								'type'        => 'select',
								'attributes'  => array(
									'class'        => 'hook-selector',
									'data-confirm' => __( 'This will overwrite the code you already have, continue?', 'facetwp-manipulator' ),
								),
								'choices'     => array(
									'facetwp_index_row'                      => 'facetwp_index_row',
									'facetwp_indexer_query_args'             => 'facetwp_indexer_query_args',
									'facetwp_query_args'                     => 'facetwp_query_args',
									'facetwp_pre_filtered_post_ids'          => 'facetwp_pre_filtered_post_ids',
									'facetwp_filtered_post_ids'              => 'facetwp_filtered_post_ids',
									'facetwp_facet_orderby'                  => 'facetwp_facet_orderby',
									'facetwp_facet_filter_posts'             => 'facetwp_facet_filter_posts',
									'facetwp_facet_render_args'              => 'facetwp_facet_render_args',
									'facetwp_is_main_query'                  => 'facetwp_is_main_query',
									'facetwp_template_use_archive'           => 'facetwp_template_use_archive',
									'facetwp_facet_html'                     => 'facetwp_facet_html',
									'facetwp_template_html'                  => 'facetwp_template_html',
									'facetwp_pager_html'                     => 'facetwp_pager_html',
									'facetwp_per_page_options'               => 'facetwp_per_page_options',
									'facetwp_result_count'                   => 'facetwp_result_count',
									'facetwp_sort_options'                   => 'facetwp_sort_options',
									'facetwp_sort_html'                      => 'facetwp_sort_html',
									'facetwp_render_output'                  => 'facetwp_render_output',
									'facetwp_assets'                         => 'facetwp_assets',
									'facetwp_facet_types'                    => 'facetwp_facet_types',
									'facetwp_facet_sources'                  => 'facetwp_facet_sources',
									'facetwp_facets'                         => 'facetwp_facets',
									'facetwp_i18n'                           => 'facetwp_i18n',
									'facetwp_proximity_radius_options'       => 'facetwp_proximity_radius_options',
									'facetwp_proximity_autocomplete_options' => 'facetwp_proximity_autocomplete_options',
								),
							),
						),
					),
					array(
						'size'    => 'col-xs-2',
						'control' => array(
							'description' => array(
								'label'      => __( 'Load Sample', 'facetwp-manipulator' ),
								'type'       => 'button',
								'attributes' => array(
									'class' => 'button facetwp-sample-code',
									'type'  => 'button',
								),
							),
						),
					),
					array(
						'size'    => 'col-xs-6',
						'control' => array(
							'description' => array(
								'label'       => __( 'Description', 'facetwp-manipulator' ),
								'description' => __( 'Admin note on the purpose of this manipulation.', 'facetwp-manipulator' ),
								'type'        => 'text',
							),
						),
					),
					array(
						'size'    => 'col-xs-12',
						'control' => array(
							'code' => array(
								'type' => 'codemirror',
								'rows' => 9,
							),
						),
					),
					array(
						'size'    => 'col-xs-12',
						'control' => array(
							'status' => array(
								'label'       => __( 'Manipulator Active', 'facetwp-manipulator' ),
								'description' => __( 'Enable this manipulator', 'facetwp-manipulator' ),
								'type'        => 'toggle',
							),
						),
					),
				),
			),
		),
	),
);
