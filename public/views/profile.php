<?php $data['template_with_cols'] = array('af-register-6', 'af-register-11', 'af-register-12', 'af-register-13');?>
<div class="af-register-form  <?php echo esc_attr($data['template']);?>">

	<?php if (!empty($data['css'])):
						wp_register_style( 'dummy-handle', false );
						wp_enqueue_style( 'dummy-handle' );
						wp_add_inline_style( 'dummy-handle', stripslashes($data['css']) );
	 endif; ?>

	<form action="<?php echo (isset($data['action'])) ? $data['action'] : '';?>" method="post" name="<?php echo esc_attr($data['form_name']);?>" id="<?php echo esc_attr($data['form_id']);?>" class="af-form-create-edit" enctype="multipart/form-data"  >

		<?php do_action('af_profile_form_before_form_fields');?>

		<?php if (!empty($data['form_fields'])):
				$i = 0;
				$stop = 0;
				if(isset($data['count_register_fields'])){
					$stop = ceil($data['count_register_fields']/2);
				}


		?>
			<?php foreach ($data['form_fields'] as $form_field): ?>
				<?php
					if (empty($form_field)){
						continue;
					}
					$i++;
					if (in_array($data['template'], $data['template_with_cols']) ):
						if ($i==1):?>
							<div class="af-register-col">
						<?php endif;
						if ($i-1==$stop):	?>
							</div><div class="af-register-col">
						<?php endif;?>
					<?php endif;?>
					<?php echo esc_af_content($form_field);?>
			<?php endforeach;?>
		<?php endif;?>
		<?php if (in_array($data['template'], $data['template_with_cols']) ):?>
			</div>
		<?php endif;?>
		<?php if ($data['template']=='af-register-7'):?>
			<div class="af-temp7-row">
		<?php endif;?>
		<?php if (!empty($data['hiddens'])):?>
			<?php foreach ($data['hiddens'] as $value): ?>
				<?php echo esc_af_content($value);?>
			<?php endforeach;?>
		<?php endif;?>

		<?php do_action('af_profile_form_before_submit_button');?>

		<?php if ($data['template']=='af-register-14'):?>
        	<div class="af-register-row-left">
        <?php endif;?>

		<div class="af-submit-form">
			<?php echo esc_af_content($data['submit_button']);?>
		</div>

        <?php if ($data['template']=='af-register-14' && is_user_logged_in() == false):?>
        	</div>
            <div class="af-register-row-right">
            <?php
				$pag_id = get_option('af_general_login_default_page');
				if($pag_id!==FALSE){
					$login_page = get_permalink( $pag_id );
					if (!$login_page){
						 $login_page = get_home_url();
					}
					echo esc_af_content('<div class="af-login-link"><a href="'.$login_page.'">'.esc_html__('LogIn', 'openaffiliates').'</a></div>');
				}
			?>
            </div>
            <div class="af-clear"></div>
        <?php endif;?>

		<?php if ($data['template']=='af-register-7'):?>
		</div>
		<?php endif;?>

		<?php do_action('af_profile_form_after_form_fields');?>

	</form>
</div>

<?php if (!empty($data['js'])): ?>
	<?php
			wp_register_script( 'af-public-dynamic', AF_URL . 'assets/js/public.js', ['jquery'], '9.4' );
			wp_add_inline_script( 'af-public-dynamic', $data['js'] );
			wp_enqueue_script( 'af-public-dynamic' );
	?>
<?php endif;?>
