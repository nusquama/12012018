<?php
/**
 * Customizer Control: Switcher
 *
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     https://opensource.org/licenses/MIT
 * @author      Aristath
 * @author      Jegtheme
 */
namespace Jeg\Customizer\Control;

/**
 * Switch control (modified checkbox).
 */
Class Switcher extends ControlAbstract {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'jnews-switch';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'jnews-switch', JEG_URL . '/assets/js/customizer-control/control-switch.js', array( 'jquery', 'customize-base' ), null, true );
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
		<style>
		#customize-control-{{ data.id }} .switch label {
			width: calc({{ data.choices['on'].length }}ch + {{ data.choices['off'].length }}ch + 40px);
		}
		#customize-control-{{ data.id }} .switch label:after {
			width: calc({{ data.choices['on'].length }}ch + 10px);
		}
		#customize-control-{{ data.id }} .switch input:checked + label:after {
			left: calc({{ data.choices['on'].length }}ch + 25px);
			width: calc({{ data.choices['off'].length }}ch + 10px);
		}
		</style>
		<div class="switch<# if ( data.choices['round'] ) { #> round<# } #>">
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<input name="switch_{{ data.id }}" id="switch_{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( '1' == data.value ) { #> checked<# } #> />
			<label class="switch-label" for="switch_{{ data.id }}">
				<span class="switch-on">{{ data.choices['on'] }}</span>
				<span class="switch-off">{{ data.choices['off'] }}</span>
			</label>
		</div>
		<?php
	}
}
