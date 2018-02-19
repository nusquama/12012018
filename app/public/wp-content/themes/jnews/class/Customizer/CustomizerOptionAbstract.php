<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

use Jeg\Customizer;

/**
 * Class Theme JNews Customizer
 */
abstract Class CustomizerOptionAbstract
{
    /**
     * @var Customizer
     */
    protected $customizer;

    protected $id;

    public function __construct($customizer, $id)
    {
        $this->id = $id;
        $this->customizer = $customizer;
        $this->set_option();
    }

    abstract public function set_option();
}
