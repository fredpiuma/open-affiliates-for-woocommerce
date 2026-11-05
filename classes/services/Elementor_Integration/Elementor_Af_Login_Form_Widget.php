<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Elementor_Af_Login_Form_Widget extends \Elementor\Widget_Base
{

  public function get_name()
  {
      return 'af-login-form';
  }

  public function get_title()
  {
      return esc_html__( 'Open Affiliates - Login Page', 'openaffiliates' );
  }

  public function get_icon()
  {
      return 'fa fa-code';
  }

  protected function render()
  {
      echo esc_af_content('[af-login-form]');
  }

}
