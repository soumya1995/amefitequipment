<?php

class gym_packages extends Public_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('gym_packages/gym_packages_model'));
    }

    public function index() {
        $gym_packages_id = (int) @$this->meta_info['entity_id'];

            $this->gym_packages_listing($gym_packages_id);
    }

    public function gym_packages_listing() {
        $data['title'] = "Gym Packages";
        $gym_packages_id = (int) $this->meta_info['entity_id'];
        $condtion_array = array(
            'field' => "*",
            'condition' => "AND gym_packages_id = '$gym_packages_id' AND status='1' ",
            'limit' => 1,//$config['per_page'],
            'offset' => 0,//$offset,
			'order'=>'a.gym_packages_id DESC',
            'debug' => false
        );
        $res_array = $this->gym_packages_model->getgym_packages($condtion_array);
        $data['heading_title'] = 'Gym Packages Lists';
        $data['res'] = $res_array[0];
        $data['unq_section'] = "Gym Packages";
        $this->load->view('gym_packages/view_gym_packages', $data);
    }
}

/* End of file member.php */
/* Location: .application/modules/projects/controllers/projects.php */
