<?php
	
	function londres_print_slider($id, $prlx = null){
		$daslider = get_post_meta($id, 'homepageDefaultSlider_value', true);
		
		if (substr($daslider, 0, 10) === "revSlider_"){
			if (!function_exists('putRevSlider')){
				echo 'Please install the missing plugin - Revolution Slider.';
			} else {
				if ($prlx){ ?>
				<section id="home" class="homepage_parallax parallax">
					<div id="parallax-home" class="parallax" data-stellar-ratio="0.5">
				<?php 
				} ?>
				<section id="home" class="revslider">
					<?php putRevSlider(substr($daslider, 10)); ?>
				</section>
				<?php 
				if ($prlx){ ?>
					</div>
				</section>
				<?php 
				}
			}
		}
		
		if (substr($daslider, 0, 13) === "masterSlider_"){
			if (!function_exists('masterslider')){
				echo 'Please install the missing plugin - MasterSlider.';
			} else {
				if ($prlx){ ?>
				<section id="home" class="homepage_parallax parallax">
					<div id="parallax-home" class="parallax" data-stellar-ratio="0.5">
				<?php 
				} ?>
				<section id="home" class="revslider">
					<?php /* masterslider(substr($daslider, 13)); */ ?>
					<?php echo do_shortcode( '[masterslider alias="'.substr($daslider, 13).'"]' ); ?>
				</section>
				<?php 
				if ($prlx){ ?>
					</div>
				</section>
				<?php 
				}
			}
		}	
	}

?>