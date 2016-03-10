<?php
/**
 * 
 * @author: Min Nam
 * Log class read, writes, and output a .log file to HTML Tag.   
 * 
**/

namespace VEC;

class Log{
		
		const PATH_TO_LOG = "./a.log";

		public function read() {

			return file_get_contents( self::PATH_TO_LOG );

		}
		/**
		 * Various validations in case of Proxy.
		**/
		public function write( $from, $descrption = "" ) {

			$date      = date( "Y-m-d\TH:i:s" );
			$clientIP  = "";

			// Possible client ip address
	    	if ( getenv( "HTTP_CLIENT_IP") ) {

	        	$clientIP = getenv( "HTTP_CLIENT_IP" );

	    	} else if( getenv( "HTTP_X_FORWARDED_FOR" ) ) {

	       		$clientIP = getenv( "HTTP_X_FORWARDED_FOR" );

	       	} else if( getenv( "HTTP_X_FORWARDED" ) ){

	        	$clientIP = getenv( "HTTP_X_FORWARDED" );

	        } else if( getenv( "HTTP_FORWARDED_FOR" ) ){

	        	$clientIP = getenv( "HTTP_FORWARDED_FOR" );

	        } else if( getenv( "HTTP_FORWARDED" ) ){

	        	$clientIP = getenv( "HTTP_FORWARDED" );

	        } else if( getenv( "REMOTE_ADDR" ) ) {

	        	$clientIP = getenv( "REMOTE_ADDR" );

	        } else{

	        	$clientIP = "UNDEFINED";

	        }
	        
			$log  = "$date, $clientIP, $from, $descrption\n";
			$log .= $this->read();

			file_put_contents( self::PATH_TO_LOG, $log );

		}

		public function toHTMLTable() {

			$handler = fopen( self::PATH_TO_LOG, "r" );

			if( $handler ) {

				echo "<table id = 'logTable'>";
				echo "<tr>";
				echo "<th>Date</th>";
				echo "<th>Client IP</th>";
				echo "<th>Function</th>";
				echo "<th>Description</th>";
				echo "</tr>";
				
				while( ( $line = fgets( $handler ) ) !== false ) { 

					$cols = explode( ',', $line );

					echo "<tr>";

					foreach( $cols as $col ) {

						echo "<td>$col</td>";
					}

					echo "</tr>";
				}

				echo "</table>";

			} else {

				// Error reading file

			}

		}

}

?>