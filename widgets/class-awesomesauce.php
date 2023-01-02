<?php
/**
 * Awesomesauce class.
 *
 * @category   Class
 * @package    ElementorAwesomesauce
 * @subpackage WordPress
 * @author     Ben Marshall <me@benmarshall.me>
 * @copyright  2020 Ben Marshall
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://www.benmarshall.me/build-custom-elementor-widgets/,
 *             Build Custom Elementor Widgets)
 * @since      1.0.0
 * php version 7.3.9
 */

namespace ElementorAwesomesauce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Awesomesauce widget class.
 *
 * @since 1.0.0
 */
class Awesomesauce extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'awesomesauce', plugins_url( '/assets/css/custom-video.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
		wp_register_script( 'awesomesauce', plugins_url( '/assets/js/custom-video.js', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Vídeo Customizável';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Vídeo Cutomizável', 'elementor-awesomesauce' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-pencil';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}
	
	/**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array( 'awesomesauce' );
	}

	public function get_script_depends() {
		return array('awesomesauce');
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Content', 'elementor-awesomesauce' ),
			)
		);

		$this->add_control(
			'video-background',
			array(
				'label'   => __( 'Vídeo de fundo:', 'elementor-awesomesauce' ),
				'type'    => Controls_Manager::MEDIA,
				'media_types' => ['video'],
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				],
			)
		);

		$this->add_control(
			'video',
			array(
				'label'   => __( 'Vídeo:', 'elementor-awesomesauce' ),
				'type'    => Controls_Manager::MEDIA,
				'media_types' => ['video'],
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				],
			)
		);

		$this->add_control(
			'timebar',
			array(
				'label'   => __( 'Habilitar barra de tempo:', 'elementor-awesomesauce' ),
				'type'    => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'volume',
			array(
				'label'   => __( 'Habilitar controle de volume:', 'elementor-awesomesauce' ),
				'type'    => Controls_Manager::SWITCHER,
			)
		);



		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'video-background', 'none' );
		$this->add_inline_editing_attributes( 'video', 'none' );
		$this->add_inline_editing_attributes( 'timebar', 'none' );
		$this->add_inline_editing_attributes( 'volume', 'none' );
		?>
		<?php
			if ($settings['timebar']) {
				$timebar = true;
			} else {
				$timebar = false;
			}

			if ($settings['volume']) {
				$volume = true;
			} else {
				$volume = false;
			}
		?>

	<div id='video-wrapper'>
		<video id='custom-video' autoplay muted loop video-url='<?php echo(esc_url( $settings['video']['url'])); ?>' timebar='<?php echo $timebar ?>' volume='<?php echo $volume ?>'>
			<source src="<?php echo(esc_url( $settings['video-background']['url'])); ?>" type="video/mp4">
			<source src="<?php echo(esc_url( $settings['video-background']['url'])); ?>" type="video/ogg">
			<source src="<?php echo(esc_url( $settings['video-background']['url'])); ?>" type="video/mvk">
			Your browser does not support the video tag.
		</video>
		<div id='timebar'></div>
		<div id='custom-video-volume-wrapper'>
			<svg viewBox="0 0 154 234" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M11.6392 172.687H52.1515L134.313 231.478C142.337 237.219 153.492 231.483 153.492 221.616V12.1476C153.492 2.24405 142.264 -3.48304 134.249 2.33204L53.8752 60.6426H11.6392C5.21104 60.6426 0 65.8544 0 72.2836V161.046C0 167.475 5.21104 172.687 11.6392 172.687ZM130.092 34.2078L67.8952 78.8923V155.444L130.092 199.607V34.2078ZM45.1018 83.9246H23.7633V149.89H45.1018V83.9246Z"/>
			</svg>

			<input id='custom-video-volume' type='range' min='0' max='100' step='1' value='50'></input>
		</div>
		<div id='custom-video-popup'>
			<span>Seu vídeo já começou</span>
			<svg viewBox="0 0 250 234" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M11.6392 172.687H52.1515L134.313 231.478C142.337 237.219 153.492 231.483 153.492 221.616V12.1476C153.492 2.24406 142.264 -3.48304 134.249 2.33204L53.8752 60.6426H11.6392C5.21104 60.6426 0 65.8544 0 72.2836V161.046C0 167.475 5.21104 172.687 11.6392 172.687ZM130.092 34.2078L67.8952 78.8924V155.444L130.092 199.607V34.2078ZM45.1018 83.9246H23.7633V149.89H45.1018V83.9246ZM246.591 86.3641C251.136 90.9102 251.136 98.2809 246.591 102.827L232.391 117.029L246.591 131.23C251.136 135.777 251.136 143.147 246.591 147.693C242.046 152.239 234.676 152.239 230.131 147.693L215.931 133.492L201.732 147.693C197.186 152.239 189.817 152.239 185.271 147.693C180.726 143.147 180.726 135.777 185.271 131.23L199.471 117.029L185.271 102.827C180.726 98.2809 180.726 90.9102 185.271 86.3641C189.817 81.818 197.186 81.818 201.732 86.3641L215.931 100.566L230.131 86.3641C234.676 81.818 242.046 81.818 246.591 86.3641Z" fill="black"/>
			</svg>

			<span>Clique para ouvir</span>
		</div>
	</div>


		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		view.addInlineEditingAttributes( 'video-background', 'none' );
		view.addInlineEditingAttributes( 'video', 'none' );
		view.addInlineEditingAttributes( 'timebar', 'none' );
		view.addInlineEditingAttributes( 'volume', 'none' );
		#>
<!-- 		<h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
		<div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>
		<div {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</div> -->
		<?php
	}
}
