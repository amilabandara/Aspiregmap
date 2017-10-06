<?php
/**
 * Plugin Name: Aspire GMap
 * Plugin URI: http://amila.info/aspire-gmap/
 * Description: Allows users to add flexible Google Maps to post content
 * Version: 1.0.0
 * Author: Amila Bandara
 * Author URI: http://amila.info
 * License: GPL2
 */

//short code and map rendering
//ice-blue, ultra-light, dark-gray,blue-water
function aspire_gmap_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'lat'           => '7.2906',
			'lang'			=> '80.6337',
			'width'             => '100%',
			'height'            => '400px',
			'enablescrollwheel' => 'true',
			'zoom'              => 15,
			'disablecontrols'   => 'true',
			'map_style'			=> 'ice-blue'
		),
		$atts
	);
	//uniquid for map container
	$map_id = uniqid( 'aspire_map_convas_' );
	wp_print_scripts( 'google-maps-api' );
	ob_start(); ?>
	<div class="aspire_map_convas" id="<?php echo $map_id;?>" style="height: <?php echo esc_attr( $atts['height'] ); ?>; width: <?php echo esc_attr( $atts['width'] ); ?>"></div>
	 <script type="text/javascript">
			var map_<?php echo $map_id; ?>;
			function render_map_<?php echo $map_id ; ?>(){
				var location = new google.maps.LatLng("<?php echo esc_attr($atts['lat'])?>", "<?php echo esc_attr($atts['lang'])?>");
				var map_options = {
					zoom: <?php echo esc_attr($atts['zoom']); ?>,
					center: location,
					scrollwheel: <?php echo 'true' === strtolower( esc_attr($atts['enablescrollwheel']) ) ? '1' : '0'; ?>,
					disableDefaultUI: <?php echo 'true' === strtolower( esc_attr($atts['disablecontrols']) ) ? '1' : '0'; ?>,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					styles:<?php echo render_map_styles(esc_attr($atts['map_style'])); ?>
				}
				map_<?php echo $map_id ; ?> = new google.maps.Map(document.getElementById("<?php echo $map_id ; ?>"), map_options);
				var marker = new google.maps.Marker({
				position: location,
				map: map_<?php echo $map_id ; ?>,
				icon: '<?php echo plugin_dir_url( __FILE__ ).'/images/location_marker.png';?>',
				});

				//Resize Function
			google.maps.event.addDomListener(window, "resize", function() {
			var center = map_<?php echo $map_id ; ?>.getCenter();
			google.maps.event.trigger(map_<?php echo $map_id ; ?>, "resize");
			map_<?php echo $map_id ; ?>.setCenter(center);
		});
			}
		google.maps.event.addDomListener(window, 'load', render_map_<?php echo $map_id ; ?>);

		</script>

	<?php 
	return ob_get_clean();
}
add_shortcode( 'aspire_gmap', 'aspire_gmap_shortcode' );

//map styles
function render_map_styles($style){
	switch ($style) {
		case 'ice-blue':
			$style = '[{"stylers": [
            {"hue": "#2c3e50"},
            {"saturation": 250}]},{
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [{"lightness": 50
            },{"visibility": "simplified"}]},{
        "featureType": "road","elementType": "labels",
        "stylers": [{"visibility": "off"}]}]';
			break;
		case 'ultra-light':
			$style = '[
    {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#e9e9e9"
            },
            {
                "lightness": 17
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f5f5f5"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 17
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 29
            },
            {
                "weight": 0.2
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 18
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f5f5f5"
            },
            {
                "lightness": 21
            }
        ]
    },
    {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#dedede"
            },
            {
                "lightness": 21
            }
        ]
    },
    {
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#ffffff"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "saturation": 36
            },
            {
                "color": "#333333"
            },
            {
                "lightness": 40
            }
        ]
    },
    {
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f2f2f2"
            },
            {
                "lightness": 19
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#fefefe"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#fefefe"
            },
            {
                "lightness": 17
            },
            {
                "weight": 1.2
            }
        ]
    }
]';
			break;

	case 'dark-gray':
			$style ='[
    {
        "featureType": "all",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "saturation": 36
            },
            {
                "color": "#000000"
            },
            {
                "lightness": 40
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#000000"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 17
            },
            {
                "weight": 1.2
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 21
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 17
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 29
            },
            {
                "weight": 0.2
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 18
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 19
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#000000"
            },
            {
                "lightness": 17
            }
        ]
    }
]';
break;
case 'blue-water':
		$style = '[
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#46bcec"
            },
            {
                "visibility": "on"
            }
        ]
    }
]';break;
		default:
			# code...
			break;
	}

	return $style;
}

//import Google map API
function load_google_maps(){
	wp_register_script( 'google-maps-api', '//maps.google.com/maps/api/js' );
}
add_action( 'wp_enqueue_scripts', 'load_google_maps' );

function aspire_gmap_css() {
	echo '<style type="text/css">
.aspire_map_convas img {
	max-width: none;
}</style>';
}
add_action( 'wp_head', 'aspire_gmap_css' );