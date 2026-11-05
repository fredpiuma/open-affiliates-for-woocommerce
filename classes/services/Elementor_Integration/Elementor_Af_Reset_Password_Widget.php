<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Elementor_Af_Reset_Password_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
      return 'af-reset-password';
  }

  public function get_title()
  {
      return esc_html__( 'Open Affiliates - Reset Password', 'openaffiliates' );
  }

  public function get_icon(){
      return 'fa fa-code';
  }

  protected function render(){
      echo esc_af_content('[af-reset-password]');
  }


}
