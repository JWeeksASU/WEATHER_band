<?php
class Bavotasan_Preview_Pro {
	private $theme_url = 'https://themes.bavotasan.com/themes/national/';
	private $theme_name = 'National';

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 999 );
	}

	/**
	 * Add a 'Preview Pro' menu item to the Appearance panel
	 *
	 * This function is attached to the 'admin_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_theme_page( __( 'Upgrade to full version', 'national' ), sprintf( __( 'Upgrade %s', 'national' ), $this->theme_name ), 'edit_theme_options', 'bavotasan_preview_pro', array( $this, 'bavotasan_preview_pro' ) );
	}

	public function bavotasan_preview_pro() {
		?>
		<style>
		.about-wrap h1,
		.about-text {
			margin-right: 0;
		}

		.about-wrap .feature-section img {
			max-width: 65%;
		}

		.about-wrap .feature-section.images-stagger-right img {
			float: right;
			margin: 0 0 12px 2em;
		}

		.about-wrap .feature-section.images-stagger-left img {
			float: left;
			margin: 0 2em 12px 0;
		}

		.about-wrap .feature-section img {
			background: #fff;
			border: 1px #ccc solid;
			-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.3);
			box-shadow: 0 1px 3px rgba(0,0,0,0.3);
			-webkit-corder-radius: 3px;
			border-radius: 3px;
		}

		@media (max-width: 768px) {
			.about-wrap .feature-section img {
				max-width: 100%;
			}
		}
		</style>
		<div class="wrap about-wrap" id="custom-background">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<div class="about-text">
				<?php printf( __( 'Take your site to the next level with the full version of %s. Check out some of the advanced features that\'ll give you more control over your site\'s layout and design.', 'national' ), '<em>' . $this->theme_name . '</em>' ); ?>
			</div>
			<h2 class="nav-tab-wrapper">
				<?php _e( 'Features', 'national' ); ?>
			</h2>

			<div class="changelog">
				<h3><?php _e( 'Content Slider', 'national' ); ?></h3>

				<div class="feature-section images-stagger-right">
					<img alt="" src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/slider.jpg" class="image-66">
					<h4><?php _e( 'Focus on What\'s Important', 'national' ); ?></h4>
					<p><?php printf( __( 'The most important information on your site should be at the top. That\'s why %s offers a featured slider directly below your site title. Get your point across as soon as your site loads.', 'national' ), '<em>' . $this->theme_name . '</em>' ); ?></p>
					<p><?php _e( 'Use the Content Slider admin page to create/edit each custom slide or feature your latest posts by default.', 'national' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Grid Page Template', 'national' ); ?></h3>

				<div class="feature-section images-stagger-left">
					<img alt="" src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/grid-template.jpg" class="image-66">
					<h4><?php _e( 'Line Up Your Posts', 'national' ); ?></h4>
					<p><?php _e( 'Why display your posts in a single column when you can take advantage of the included grid page template?', 'national' );?>
					<p><?php _e( 'Each post will appear as part of the three columns grid.', 'national' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Social Menu', 'national' ); ?></h3>

				<div class="feature-section images-stagger-right">
					<img alt="" src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/social-menu.jpg" class="image-66">
					<h4><?php _e( 'Let\'s Get Social!', 'national' ); ?></h4>
					<p><?php _e( 'Establish your online presense by letting your visitors join your social network. Help them stay up to date on everything you\'re doing', 'national' ); ?></p>
					<p><?php _e( 'Easily add a social menu by creating links to the most popular social media websites.', 'national' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Advanced Color Picker', 'national' ); ?></h3>

				<div class="feature-section images-stagger-left">
					<img alt="" src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/color-picker.jpg" class="image-66">
					<h4><?php _e( 'So Many Colors to Choose From', 'national' ); ?></h4>
					<p><?php printf( __( 'Sometimes the default colors just aren\'t working for you. In %s you can use the advanced color picker to make sure you get the exact colors you want.', 'national' ), '<em>' . $this->theme_name . '</em>' ); ?></p>
					<p><?php _e( 'Easily select one of the eight preset colors or dive even deeper into your customization by using a more specific hex code.', 'national' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Google Fonts Manager', 'national' ); ?></h3>

				<div class="feature-section images-stagger-right">
					<img alt="" src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/google-fonts.jpg" class="image-66">
					<h4><?php _e( 'Use Any Google Font You Want', 'national' ); ?></h4>
					<p><?php _e( 'Web-safe fonts are a thing of the past, so why not try to spice things up a bit?', 'national' ); ?></p>
					<p><?php _e( 'Choose any Google Fonts to improve your site\'s typeface readability and make things look even more amazing.', 'national' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Extended Widgetized Footer', 'national' ); ?></h3>

				<div class="feature-section images-stagger-left">
					<img alt="" src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/extended-footer.jpg" class="image-66">
					<h4><?php _e( 'Add More Widgets', 'national' ); ?></h4>
					<p><?php _e( 'If you need to include more widgets on your site, take advantage of the Extended Footer.', 'national' ); ?></p>
					<p><?php _e( 'Use the Theme Options customizer to set the number of columns you want to appear. You can also customize your site\'s copyright notice.', 'national' ); ?></p>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Even More Theme Options', 'national' ); ?></h3>
				<div class="feature-section col two-col">
					<div>
						<h4><?php _e( 'Full Width Posts/Pages', 'national' ); ?></h4>
						<p><?php _e( 'Each page/post has an option to remove both sidebars so you can use the full width of your site to display whatever you want.', 'national' ); ?></p>

						<h4><?php _e( 'Multiple Sidebar Layouts', 'national' ); ?></h4>
						<p><?php _e( 'Sometimes one sidebar just isn\'t enough, so add a second one and place it where you want.', 'national' ); ?></p>
					</div>

					<div class="last-feature">
						<h4><?php _e( 'Bootstrap Shortcodes', 'national' ); ?></h4>
						<p><?php printf( __( 'Shortcodes are awesome and easy to use. That\'s why %s comes with a bunch, like a slideshow carousel, alert boxes and more.', 'national' ), '<em>' . $this->theme_name . '</em>' ); ?></p>

						<h4><?php _e( 'Import/Export Tool', 'national' ); ?></h4>
						<p><?php _e( 'Once you\'ve set up your site exactly how you want, you can easily export the Theme Options and Custom CSS for safe keeping.', 'national' ); ?></p>
					</div>
				</div>
			</div>

			<p><a href="<?php echo $this->theme_url; ?>" target="_blank" class="button-primary button-large"><?php printf( __( 'Buy %s Now &rarr;', 'national' ), '<strong>' . $this->theme_name . '</strong>' ); ?></a></p>
		</div>
		<?php
	}
}
$bavotasan_preview_pro = new Bavotasan_Preview_Pro;