<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Elementor_Af_Register_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
      return 'af-register-shortcode';
  }

  public function get_title()
  {
      return esc_html__( 'Open Affiliates - Register Page', 'openaffiliates' );
  }

  public function get_icon()
  {
      return 'fa fa-code';
  }

  protected function render()
  {
      echo esc_af_content('[af-register]');
  }

}
