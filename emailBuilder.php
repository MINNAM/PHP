<?php 

	$body = array( 

		'background-image',
		'background-repeat'

	);

	$table = array( 

		'background-image',
		'background-repeat'		
	);

	$td = array( 

		'background-color'  => '',
		'background-image'  => '',
		'background-repeat' => '',
		'display'           => array( "inline", "inline-block", "none" )
		
	);

	$border = array( 

		'border',
		'border-color',
		'border-collapse',
		'border-spacing',
		'border-style',
		'border-width'

	);

	$list = array( 

		'font-family',
		'font-size',
		'font-style',
		'font-variant',
		'font-weight'

	);

	$marginAndPadding = array(

		'margin', // Only works with block
		'padding'

	);

	$text = array( 

		'color',
		'direction',
		'letter-spcaing',
		'line-height',
		'text-align',
		'text-decoration',
		'text-indent',
		'text-transform',
		'word-spacing',
		'white-space'

	);

	$positioning = array(

		'float',
		'vertical-align'
	);

	$dimensions = array(

		'height',
		'width',
		'min-height', //only works with block elements
		'min-width'

	);

	$other = array(

		'empty-cells',
		'outline',
		'overflow'

	);

	$gradient = array(

		'gradient - email background',
		'gradient - button'

	);

	$css3 = array(

		'border-radius',
		'multiple background images'

	);


	ini_set('memory_limit','128M');

	class Selector implements Iterator {

		private $name;
		private $position;
		private $nodes = array();

		public function __construct( $name, $nodes ) {

			$this->name     = $name;
			$this->position = 0;
			$this->nodes 	= $nodes;

		}

		public function rewind() {

			$this->position = 0;

		}

		public function current() {

			return $this->nodes[ $this->position ];

		}

		public function key() {

			return $this->position;
				
		}

		public function next() {

			++$this->position;

		}

		public function valid() {

			return isset( $this->nodes[ $this->position ] );

		}

	}

	class StyleAttribute {

		private $values = array();
		
		public function __construct( $type, $property, $value ) {

			$this->values[ "type" ]     = $type;
			$this->values[ "property" ] = $property;
			$this->values[ "value" ]    = $value;

		}

		public function __get( $key ) {

			return $this->values[ $key ];

		}

		public function __set( $key, $value ) {

			$this->values[ $key ] = $value;

		}

	} 


	$style = new Selector( "name", array( new StyleAttribute( "id", "display", "none" ) )  );

	// foreach( $style as $s ){

	// 	echo $s->type;

	// }

	class Stylesheet{

		private $selector;
		private $content;
		private $styles;
		
		public function __construct( $stylesheet) {

			// $this->selector = Selector

			$this->content = file_get_contents( $stylesheet );			

			$this->sanitize();
			$this->populateStyle();
			
		} 	

		public function sanitize() {

			$pattern       = array(  '/\s+/', '/\n/', '/@(.*)\)([ ]*);/', '/\/\*(.*)\*\//' );
			$replacement   = array( ' ', '', '', '' );
			$this->content = preg_replace( $pattern, $replacement, $this->content );
	
		}

		public function populateStyle() {

			$declaration  = explode( '}', $this->content );			

			foreach( $declaration as $d ){

				/**
				 * 0 => Identifier 
				 * 2 => propeties/values
				 **/
				$vars = explode( '{', $d );

				if( $vars[ 0 ] != '' ){

					echo( $vars[ 0 ] );

					switch( trim( $vars[ 0 ] )[ 0 ] ) {

						case '.' : 

							echo "class";
							break;

						case '#' : 

							echo "id";
							break;

						default : 

							echo "tag";
							break;

					}

					new Selector( $vars[ 0 ], new StyleAttribute( "id", "display", "none" ) );

					// echo( $vars[ 0 ] );

				}				

				// var_dump( explode( '{', $d ) );
				echo "<br>";
				
			}

		}

	}

	$test = new Stylesheet( "./template.css" );

?>