<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property User_model $User_model
 * @property CI_Session $session
 * @property CI_Input $input
 *  @property CI_Form_validation $form_validation
 * @property CI_Output $output
 * @property CI_Lang $lang
 */
class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
public function index()
{
    $lang = $this->input->get("lang");

    if ($lang) {
        $this->session->set_userdata('site_lang', $lang);
    }

    $language = $this->session->userdata('site_lang') ?? "english";

    // FIXED: load correct file
    $this->lang->load('message', $language);

    $data['message'] = $this->lang->line('message');

    $this->load->view('welcome_message', $data);
}


}
