<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gym_packages_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getgym_packages($opts = array()) {
        $keyword = trim($this->input->get_post('keyword', TRUE));
        $keyword = $this->db->escape_str($keyword);
        $status = $this->db->escape_str($this->input->get_post('status', TRUE));

        if (!array_key_exists('condition', $opts) || $opts['condition'] == '') {
            $opts['condition'] = "status !='2' ";
        } else {
            $opts['condition'] = "status !='2' " . $opts['condition'];
        }

        if ($keyword != '') {
            $opts['condition'].= " AND LOWER(gym_packages_name) like '%" . strtolower($keyword) . "%'";
        }

        if ($status != '') {
            $opts['condition'].= " AND status='$status' ";
        }


		if (!array_key_exists('order', $opts) || $opts['order'] == '') {
            $opts['order'] = "sort_order ASC";
        } else {
            $opts['order'] = $opts['order'];
        }
        $opts['condition'].= " ";

        $fetch_config = array('condition' => $opts['condition'],
            'order' => $opts['order'],
            'return_type' => "array");

        if (array_key_exists('debug', $opts)) {
            $fetch_config['debug'] = $opts['debug'];
        }


        if (array_key_exists('field', $opts) && $opts['field'] != '') {
            $fetch_config['field'] = $opts['field'];
        }

        if (array_key_exists('limit', $opts) && applyFilter('NUMERIC_GT_ZERO', $opts['limit']) > 0) {

            $fetch_config['limit'] = $opts['limit'];
        }
        if (array_key_exists('offset', $opts) && applyFilter('NUMERIC_WT_ZERO', $opts['offset']) != -1) {
            $fetch_config['start'] = $opts['offset'];
        }
        $result = $this->findAll('wl_gym_packages as a', $fetch_config);

        return $result;
    }

    public function get_gym_packages_by_id($id) {
        $id = applyFilter('NUMERIC_GT_ZERO', $id);

        if ($id > 0) {
            $condtion = "status !='2' AND gym_packages_id=$id";
            $fetch_config = array(
                'condition' => $condtion,
                'debug' => FALSE,
                'return_type' => "array"
            );
            $result = $this->find('wl_gym_packages', $fetch_config);
            return $result;
        }
    }

    public function get_featured_gym_packages($parent_id, $limit) {
        $condtion = "status = '1'  AND  parent_id='" . $parent_id . "'";
        $fetch_config = array(
            'fields' => 'cat_name,cat_id',
            'condition' => $condtion,
            'order' => "display_order ASC ",
            'limit' => $limit,
            'start' => '0',
            'debug' => FALSE,
            'return_type' => "array"
        );
        $result = $this->findAll('wl_gym_packages', $fetch_config);
        return $result;
    }

}

// model end here