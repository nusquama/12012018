<?php
/**
 * Customizer Control: multicolor.
 *
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     https://opensource.org/licenses/MIT
 * @author      Aristath
 * @author      Jegtheme
 */
namespace Jeg\Customizer\Control;

/**
 * Multicolor control.
 */
Class Multicolor extends ControlAbstract {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'jnews-multicolor';

	/**
	 * Color Palette.
	 *
	 * @access public
	 * @var bool
	 */
	public $palette = true;

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();
		$this->json['palette']  = $this->palette;
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'jnews-multicolor', JEG_URL . '/assets/js/customizer-control/control-multicolor.js', array( 'jquery', 'customize-base', 'wp-color-picker-alpha' ), null, true );
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<span class="customize-control-title">
			{{{ data.label }}}
		</span>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="multicolor-group-wrapper">
			<# for ( key in data.choices ) { #>
				<div class="multicolor-single-color-wrapper">
					<# if ( data.choices[ key ] ) { #>
						<label for="{{ data.id }}-{{ key }}">{{ data.choices[ key ] }}</label>
					<# } #>
					<input id="{{ data.id }}-{{ key }}" type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default[ key ] }}" data-alpha="true" value="{{ data.value[ key ] }}" class="jnews-color-control color-picker multicolor-index-{{ key }}" />
				</div>
			<# } #>
		</div>
		<div class="iris-target"></div>
		<input type="hidden" value="" {{{ data.link }}} />
		<?php
	}
}
