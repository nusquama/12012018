<?php
/**
 * Customizer Control: Alert
 *
 * @author      Jegtheme
 * @license     https://opensource.org/licenses/MIT
 */
namespace Jeg\Customizer\Control;

/**
 * Create a simple number control
 */
Class Alert extends ControlAbstract {

    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'jnews-alert';

    /**
     * Renders the control wrapper and calls $this->render_content() for the internals.
     */
    protected function render() {
        $id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
        $class = 'customize-control-jnews customize-control-' . $this->type . ' customize-alert customize-alert-' . $this->value();
        ?><li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
        <?php $this->render_content(); ?>
        </li><?php
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
        <label>
            <# if ( data.label ) { #>
                <strong class="customize-control-title">{{{ data.label }}}</strong>
            <# } #>
            <# if ( data.description ) { #>
                <div class="description customize-control-description">{{{ data.description }}}</div>
            <# } #>
        </label>
        <?php
    }
}
