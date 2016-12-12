<?php
/**
 * FWPMANIP Controls - Post Relation
 *
 * @package   controls
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace fwpmanip\ui\control;

/**
 * Standard text input field
 *
 * @since 1.0.0
 */
class post_relation extends \fwpmanip\ui\control {

	/**
	 * The type of object
	 *
	 * @since       1.0.0
	 * @access public
	 * @var         string
	 */
	public $type = 'post_relation';

	/**
	 * Catch the ajax search and push results
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		$defaults = array(
			'add_label' => __( 'Add Related Post', 'fwpmanip' ),
			'config'    => array(
				'limit' => 1,
			),
			'query'     => array(
				'post_type'     => 'any',
				'post_per_page' => 5,
			),
		);

		$this->struct = array_merge( $defaults, $this->struct );

		$data = fwpmanip()->request_vars( 'post' );

		if ( ! empty( $data['fwpmanipId'] ) && $data['fwpmanipId'] === $this->id() ) {
			$this->do_lookup( $data );
		}

	}

	public function do_lookup( $data ) {

		$args = $this->build_args( $data );

		$the_query = new \WP_Query( $args );

		$return = array(
			'html'          => '',
			'found_posts'   => $the_query->found_posts,
			'max_num_pages' => $the_query->max_num_pages,
			'html'          => $this->process_query( $the_query ),
		);

		wp_send_json( $return );
	}

	/**
	 * Builds the query args for the post lookup
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Args for the query
	 */
	public function build_args( $data ) {
		$defaults = array(
			'post_type'      => 'post',
			'posts_per_page' => 10,
			'paged'          => 1,
		);
		if ( ! empty( $data['_value'] ) ) {
			$defaults['s'] = $data['_value'];
		}

		$args = array_merge( $defaults, $this->struct['query'] );

		if ( ! empty( $data['page'] ) ) {
			$args['paged'] = (int) $data['page'];
		}
		if ( ! empty( $data['selected'] ) ) {
			$args['post__not_in'] = explode( ',', $data['selected'] );
		}

		return $args;
	}

	/**
	 * Processes the query and returns the row html
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string HTML of processed results
	 */
	public function process_query( $the_query ) {
		$return = null;
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ){
				$the_query->the_post();
				$return .= '<div class="fwpmanip-post-relation-item"><span class="fwpmanip-post-relation-add dashicons dashicons-plus" data-id="' . esc_html( $this->id() ) . '"></span>';
				$return .= '<span class="fwpmanip-relation-name">' . get_the_title() . '</span>';
				$return .= '<input class="fwpmanip-post-relation-id" type="hidden" name="' . esc_html( $this->name() ) . '[]" value="' . esc_attr( get_the_ID() ) . '" disabled="disabled">';
				$return .= '</div>';
			}
			wp_reset_postdata();
			$return .= '<div class="fwpmanip-post-relation-pager">';
			$return .= $this->pagination( $the_query );
			$return .= '</div>';
		} else {
			$return .= '<div class="fwpmanip-post-relation-no-results">' . esc_html__( 'Nothing found', 'fwpmanip' ) . '</div>';
		}

		return $return;
	}

	/**
	 * Creates the pagination options if there are more entries
	 *
	 * @return string
	 */
	public function pagination( $the_query ) {
		$return = null;
		if ( $the_query->max_num_pages > 1 ) {
			$return .= '<button type="button" class="fwpmanip-post-relation-page button button-small" data-page="' . esc_attr( $the_query->query['paged'] - 1 ) . '">';
			$return .= '<span class="dashicons dashicons-arrow-left-alt2"></span>';
			$return .= '</button>';
			$return .= '<span class="fwpmanip-post-relation-count">' . $the_query->query['paged'] . ' ' . esc_html__( 'of', 'fwpmanip' ) . ' ' . $the_query->max_num_pages . '</span>';
			$return .= '<button type="button" class="fwpmanip-post-relation-page button button-small" data-page="' . esc_attr( $the_query->query['paged'] + 1 ) . '">';
			$return .= '<span class="dashicons dashicons-arrow-right-alt2"></span>';
			$return .= '</button>';
		}

		return $return;
	}

	/**
	 * Gets the classes for the control input
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function classes() {

		return array(
			'fwpmanip-post-relation',
		);

	}

	/**
	 * Returns the main input field for rendering
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 * @return string
	 */
	public function input() {

		$data  = (array) $this->get_value();
		$input = '<div ' . $this->build_attributes() . '>';

		foreach ( $data as $item ) {
			$input .= $this->render_item( $item );
		}

		$input .= '</div>';

		$input .= '<div class="fwpmanip-post-relation-footer"><button class="button button-small fwpmanip-add-relation" type="button">' . esc_html( $this->struct['add_label'] ) . '</button></div>';
		$input .= '<div class="fwpmanip-post-relation-panel"><span class="fwpmanip-post-relation-spinner spinner"></span>';
		$input .= '<input type="search" class="fwpmanip-ajax" data-load-element="_parent" data-delay="250" data-method="POST" data-fwpmanip-id="' . esc_attr( $this->id() ) . '" data-event="input paginate" data-before="fwpmanip_related_post_before" data-callback="fwpmanip_related_post_handler" data-target="#' . esc_attr( $this->id() ) . '-search-results">';
		$input .= '<div class="fwpmanip-post-relation-results" id="' . esc_attr( $this->id() ) . '-search-results">';
		$input .= '</div></div>';

		return $input;
	}

	public function render_item( $item ) {
		$input = null;

		if ( get_post( $item ) ) {

			$input .= '<div class="fwpmanip-post-relation-item">';
			$input .= '<span class="fwpmanip-post-relation-remover dashicons dashicons-no-alt"></span>';
			$input .= '<span class="fwpmanip-relation-name">' . get_the_title( $item ) . '</span>';
			$input .= '<input class="fwpmanip-post-relation-id" type="hidden" name="' . esc_html( $this->name() ) . '[]" value="' . esc_attr( $item ) . '">';
			$input .= '</div>';
		}

		return $input;
	}

	/**
	 * register scritps and styles
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_assets() {

		// Initilize core styles
		$this->assets['style']['post-relation'] = $this->url . 'assets/controls/post-relation/css/post-relation' . FWPMANIP_ASSET_DEBUG . '.css';

		$this->assets['script']['post-relation'] = array(
			'src'       => $this->url . 'assets/controls/post-relation/js/post-relation' . FWPMANIP_ASSET_DEBUG . '.js',
			'in_footer' => true,
		);
		$this->assets['script']['baldrick']      = array(
			'src'  => $this->url . 'assets/js/jquery.baldrick' . FWPMANIP_ASSET_DEBUG . '.js',
			'deps' => array( 'jquery' ),
		);
		$this->assets['script']['fwpmanip-ajax']      = array(
			'src'  => $this->url . 'assets/js/ajax' . FWPMANIP_ASSET_DEBUG . '.js',
			'deps' => array( 'baldrick' ),
		);
		$this->assets['style']['fwpmanip-ajax']       = $this->url . 'assets/css/ajax' . FWPMANIP_ASSET_DEBUG . '.css';

		parent::set_assets();
	}

	/**
	 * Sets styling colors
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function set_active_styles() {

		$style = '.' . $this->id() . ' .fwpmanip-post-relation-item .fwpmanip-post-relation-add:hover{color: ' . $this->base_color() . ';}';
		$style .= '.' . $this->id() . ' .fwpmanip-post-relation-item .fwpmanip-post-relation-remover:hover {color: ' . $this->base_color() . ';}';

		fwpmanip_share()->set_active_styles( $style );
	}

}
