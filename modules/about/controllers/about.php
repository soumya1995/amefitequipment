<?php

class about extends Public_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('about/about_model'));
    }

    public function index() {
        $about_id = (int) @$this->meta_info['entity_id'];

            $this->about_listing($about_id);
    }

    public function about_listing() {
        $data['title'] = "about";
        $about_id = (int) $this->meta_info['entity_id'];
        $condtion_array = array(
            'field' => "*",
            'condition' => "AND about_id = '$about_id' AND status='1' ",
            'limit' => 1,//$config['per_page'],
            'offset' => 0,//$offset,
			'order'=>'a.about_id DESC',
            'debug' => false
        );
        $res_array = $this->about_model->getabout($condtion_array);
        $data['heading_title'] = 'about Lists';
        $data['res'] = $res_array[0];
        $data['unq_section'] = "About";
        $this->load->view('about/view_about', $data);
    }
}

/* End of file member.php */
/* Location: .application/modules/projects/controllers/projects.php */
