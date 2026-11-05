<?php
/**
 * Open Affiliates - About & Support screen.
 * Contact card. No external images or scripts are loaded here.
 */
$af_author_links = [
	[ 'label' => esc_html__( 'Talk to me on WhatsApp', 'openaffiliates' ), 'url' => 'https://wa.me/5511914636944', 'class' => 'af-about-btn-whatsapp' ],
	[ 'label' => esc_html__( 'E-mail', 'openaffiliates' ), 'url' => 'mailto:contato@fredericodecastro.com.br', 'class' => 'af-about-btn-email' ],
	[ 'label' => esc_html__( 'Website', 'openaffiliates' ), 'url' => 'https://www.fredericodecastro.com.br/links/', 'class' => 'af-about-btn-site' ],
	[ 'label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/fredericodecastro/', 'class' => 'af-about-btn-linkedin' ],
	[ 'label' => 'Telegram', 'url' => 'https://t.me/fredericomdecastro', 'class' => 'af-about-btn-telegram' ],
];
?>
<div class="af-wrapper">
	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e( 'About Open Affiliates', 'openaffiliates' );?></h3>
		<div class="inside">
			<p>
				<?php
				printf(
					esc_html__( 'Open Affiliates %s is free software released under the GPL-2.0-or-later license. It makes no connection to third-party servers on its own: it never checks licenses, never sends usage data and never calls home.', 'openaffiliates' ),
					esc_html( AF_PLUGIN_VER )
				);
				?>
			</p>
			<p>
				<a href="<?php echo esc_url( AF_REPO_URL );?>" target="_blank" rel="noopener"><?php esc_html_e( 'Source code and issues', 'openaffiliates' );?></a>
				&middot;
				<a href="<?php echo esc_url( AF_DOCS_URL );?>" target="_blank" rel="noopener"><?php esc_html_e( 'Documentation', 'openaffiliates' );?></a>
				&middot;
				<a href="<?php echo esc_url( AF_REPO_URL . '/blob/main/CREDITS.md' );?>" target="_blank" rel="noopener"><?php esc_html_e( 'Credits', 'openaffiliates' );?></a>
			</p>
		</div>
	</div>

	<div class="af-stuffbox">
		<h3 class="af-h3"><?php esc_html_e( 'Need a custom solution for your store?', 'openaffiliates' );?></h3>
		<div class="inside">
			<p><?php esc_html_e( 'I build plugins, integrations and improvements for WordPress and WooCommerce, from checkout to after-sales. Tell me what you need and we will find the best path for your project.', 'openaffiliates' );?></p>
			<p><strong>Frederico de Castro</strong> &middot; Senior Web Developer &amp; Software Architect</p>
			<p class="af-about-buttons">
				<?php foreach ( $af_author_links as $link ):?>
					<a class="af-about-btn <?php echo esc_attr( $link['class'] );?>" href="<?php echo esc_url( $link['url'], [ 'https', 'mailto' ] );?>" target="_blank" rel="noopener"><?php echo esc_html( $link['label'] );?></a>
				<?php endforeach;?>
			</p>
		</div>
	</div>
</div>
