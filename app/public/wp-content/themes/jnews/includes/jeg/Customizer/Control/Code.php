<?php
/**
 * Customizer Control: code.
 *
 * Creates a new custom control.
 * Custom controls accept raw HTML/JS.
 *
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     https://opensource.org/licenses/MIT
 * @author      Aristath
 * @author      Jegtheme
 */
namespace Jeg\Customizer\Control;

/**
 * Adds a "code" control, using CodeMirror.
 */
Class Code extends ControlAbstract {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'jnews-code';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'jnews-code', JEG_URL . '/assets/js/customizer/control-code.js', array( 'jquery', 'codemirror' ), false, true );

		// If we're using html mode, we'll also need to include the multiplex addon
		// as well as dependencies for XML, JS, CSS languages.
		if ( in_array( $this->choices['language'], array( 'html', 'htmlmixed' ) ) ) {
			wp_enqueue_script( 'codemirror-multiplex', JEG_URL . '/assets/js/vendor/codemirror/addon/mode/multiplex.js', array( 'jquery', 'codemirror' ) );
			wp_enqueue_script( 'codemirror-language-xml', JEG_URL . '/assets/js/vendor/codemirror/mode/xml/xml.js', array( 'jquery', 'codemirror' ) );
			wp_enqueue_script( 'codemirror-language-javascript', JEG_URL . '/assets/js/vendor/codemirror/mode/javascript/javascript.js', array( 'jquery', 'codemirror' ) );
			wp_enqueue_script( 'codemirror-language-css', JEG_URL . '/assets/js/vendor/codemirror/mode/css/css.js', array( 'jquery', 'codemirror' ) );
			wp_enqueue_script( 'codemirror-language-htmlmixed', JEG_URL . 'assets/js/vendor/codemirror/mode/htmlmixed/htmlmixed.js', array( 'jquery', 'codemirror', 'codemirror-multiplex', 'codemirror-language-xml', 'codemirror-language-javascript', 'codemirror-language-css' ) );
		} elseif ( 'php' === $this->choices['language'] ) {
			wp_enqueue_script( 'codemirror-language-xml', JEG_URL . '/assets/js/vendor/codemirror/mode/xml/xml.js', array( 'jquery', 'codemirror' ) );
			wp_enqueue_script( 'codemirror-language-php', JEG_URL. '/assets/js/vendor/codemirror/mode/php/php.js', array( 'jquery', 'codemirror' ) );
		} else {
			// Add language script.
			wp_enqueue_script( 'codemirror-language-' . $this->choices['language'], JEG_URL . '/assets/js/vendor/codemirror/mode/' . $this->choices['language'] . '/' . $this->choices['language'] . '.js', array( 'jquery', 'codemirror' ) );
		}

		// Add theme styles.
		wp_enqueue_style( 'codemirror-theme-' . $this->choices['theme'], JEG_URL . '/assets/js/vendor/codemirror/theme/' . $this->choices['theme'] . '.css' );
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<a href="#" class="button edit button-primary">{{ data.choices.label }}</a>
			<textarea class="jnews-codemirror-editor collapsed">{{{ data.value }}}</textarea>
			<a href="#" class="close">
				<span class="dashicons dashicons-no"></span>
				<span class="screen-reader-text">Close</span>
			</a>
		</label>
		<?php
	}
}