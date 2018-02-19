<?php

class Minit_Css extends Minit_Assets
{
    /**
     * @var JNews_Speed
     */
	private $plugin;

    /**
     * Last Handle Should be Minit CSS
     * @var string
     */
    private $last_handle = 'minit-css';

    /**
     * Current Handler Counter
     * @var int
     */
    private $index = 0;


	function __construct( $plugin ) {

		$this->plugin = $plugin;

		parent::__construct( wp_styles(), 'css');

	}

	public function init() {

		// Queue all assets
		add_filter( 'print_styles_array', array( $this, 'register' ) );

		// Print our CSS files
		add_filter( 'print_styles_array', array( $this, 'process' ), 20 );

        // Defer CSS
        add_filter('style_loader_tag', array($this, 'loader_tag'), null, 2);
	}

    public function minify( $content )
    {
        $compressor = new CSSmin();
        $compressor->set_memory_limit('256M');
        $compressor->set_max_execution_time(120);
        return $compressor->run($content);
    }


    /** defer style  */
    public function loader_tag($tag, $handle)
    {
        if($this->index === 0) {
            $tag = "<noscript id=\"deferred-styles\">" . $tag;
        }

        if($handle === $this->last_handle) {
            $tag = $tag . "</noscript>" . $this->deferred_defer_style_script();
        }

        $this->index++;

        return $tag;
    }

    /** print defer script */
    public function deferred_defer_style_script()
    {
        // Return null untuk debuging
        if($this->plugin->debug) {
            return null;
        } else {
            return
                "<script>
                var loadDeferredStyles = function() {
                    var addStylesNode = document.getElementById(\"deferred-styles\");
                    var replacement = document.createElement(\"div\");
                    replacement.innerHTML = addStylesNode.textContent;
                        document.body.appendChild(replacement)
                        addStylesNode.parentElement.removeChild(addStylesNode);
                };
                var raf = requestAnimationFrame || mozRequestAnimationFrame ||
                      webkitRequestAnimationFrame || msRequestAnimationFrame;
                if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
                else window.addEventListener('load', loadDeferredStyles);
            </script>";
        }
    }

	function process( $todo ) {

		// Put back handlers that were excluded from Minit
		$todo = array_merge( $todo, $this->queue );
		$handle = 'minit-css';
		$url = $this->minit();

		if ( empty( $url ) ) {
			return $todo;
		}

		wp_enqueue_style( $handle, $url, null, null );

		// Add our Minit style since wp_enqueue_script won't do it at this point
		$todo[] = $handle;

		// Add inline styles for all minited styles
		foreach ( $this->done as $script ) {

			// Can this return an array instead?
			$inline_styles = $this->handler->get_data( $script, 'after' );

			if ( ! empty( $inline_styles ) ) {
				$this->handler->add_inline_style( $handle, implode( "\n", $inline_styles ) );
			}
		}

		return $todo;

	}


	function minit_item( $content, $handle, $src ) {

		if ( empty( $content ) ) {
			return $content;
		}

		// Exclude styles with media queries from being included in Minit
		$content = $this->exclude_with_media_query( $content, $handle, $src );

		// Make all asset URLs absolute
		$content = $this->resolve_urls( $content, $handle, $src );

		// Add support for relative CSS imports
		$content = $this->resolve_imports( $content, $handle, $src );

		return $content;

	}


	private function resolve_urls( $content, $handle, $src )
    {
		if ( ! $content ) {
			return $content;
		}

		// Make all local asset URLs absolute
		$content = preg_replace(
			'/url\(["\' ]?+(?!data:|https?:|\/\/)(.*?)["\' ]?\)/i',
			sprintf( "url('%s/$1')", $this->handler->base_url . dirname( $src ) ),
			$content
		);

		return $content;
	}


	private function resolve_imports( $content, $handle, $src )
    {
		if ( ! $content ) {
			return $content;
		}

		// Make all import asset URLs absolute
		$content = preg_replace(
			'/@import\s+(url\()?["\'](?!https?:|\/\/)(.*?)["\'](\)?)/i',
			sprintf( "@import url('%s/$2')", $this->handler->base_url . dirname( $src ) ),
			$content
		);

		return $content;
	}

	private function exclude_with_media_query( $content, $handle, $src ) {

		if ( ! $content ) {
			return $content;
		}

		$whitelist = array( '', 'all', 'screen' );

		// Exclude from Minit if media query specified
		if ( ! in_array( $this->handler->registered[ $handle ]->args, $whitelist ) ) {
			return false;
		}

		return $content;

	}

}
