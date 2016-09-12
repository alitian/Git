<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_manage extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct() {
        parent::__construct();
        header("Content-type: text/html; charset=utf-8");
        session_start();
        $this->load->helper('url');
        $this->load->model('offer_m');
        $this->load->model('Common');
        $this->load->model('Admin_m');
        $this->load->library('pagination');     
    }

    /**
     * 权限项管理
     */
    function admin_about() {
        if ($_POST && isset($_POST['name']) && $_POST['name']) {
            $insert_data = array('pid' => $_POST['pid'], 'name' => $_POST['name'], 'controller' => $_POST['controller'], 'action' => $_POST['action'], 'plus_uri' => $_POST['plus_uri']);
            if (isset($_POST['if_show'])) {
                $insert_data['if_show'] = 1;
            } else {
                $insert_data['if_show'] = 0;
            }
            if ($_GET['edit']) {
                $this->Common->update("md_admin_power_item", array('id' => $_GET['edit']), $insert_data);
            } else {
                $insert_id = $this->Common->add("md_admin_power_item", $insert_data);
            }
            redirect(base_url().'admin_manage/admin_about');
        }
        if ($_GET['del']) {
            $this->db->delete('md_admin_power_item', array('id' => $_GET['del']));
            redirect(base_url().'admin_manage/admin_about');
        }
        
        $sql = "SELECT * FROM md_admin_power_item WHERE pid=0";
        $data['list'] = $this->db->query($sql)->result_array();

        if (isset($_GET['edit'])) {
            $_GET['edit'] = intval($_GET['edit']);
            $sql = "SELECT * FROM md_admin_power_item WHERE id={$_GET['edit']}";
            $data['edit_data'] = $this->db->query($sql)->row_array();
        }
        $this->load->view('admin/admin_about', $data);
    }

    /**
     * 权限组管理
     */
    function admin_group_manage() {
        if ($_POST && isset($_POST['name']) && $_POST['name']) {
            $insert_data = array('group_name' => $_POST['name'], 'group_item_ids' => $_POST['item_ids']);
            if ($_GET['edit']) {               
                $this->Common->update("md_admin_group", array('id' => $_GET['edit']), $insert_data);
            } else {
                $insert_data['if_show'] = 1;
                $insert_id = $this->Common->add("md_admin_group", $insert_data);
            }
            redirect(base_url().'admin_manage/admin_group_manage');
        }
        if (isset($_GET['edit'])) {
            $_GET['edit'] = intval($_GET['edit']);
            $sql = "SELECT * FROM md_admin_group WHERE id={$_GET['edit']}";
            $data['edit_data'] = $this->db->query($sql)->row_array();
        }
        if (isset($_GET['del'])) {
            $_GET['del'] = intval($_GET['del']);
            $sql = "DELETE FROM md_admin_group WHERE id={$_GET['del']}";
            $this->db->query($sql);
            redirect(base_url().'admin_manage/admin_group_manage');
        }
        $group_sql = "SELECT *,(SELECT count(1) FROM md_admin ad_usr WHERE ad_usr.admin_group=ad_grp.id AND if_show=1) as usr_count FROM md_admin_group ad_grp";
        $group_mes = $this->db->query($group_sql)->result_array();
        $data['group_mes'] = $group_mes;
        $this->load->view('admin/admin_group', $data);
    }
    
    public function ajax_pw_tree() {
        $ids = array();
        if ($_GET['edit']) {
            $sql = "SELECT * FROM md_admin_group WHERE id={$_GET['edit']}";
            $edit_data = $this->db->query($sql)->row_array();
        }
        $menu_mes = $this->offer_m->md_admin_menu(0, $edit_data['group_item_ids']);
        foreach($menu_mes as $k=>$row){
            $menu_mes[$k]['text'] = $menu_mes[$k]['name'];
        }
        //print_r($menu_mes);
        echo json_encode($menu_mes);
    }
    /**
     * 管理者列表
     * 查看/修改/添加
     */
    function user_group_manage() {
        if(empty($_SESSION['admin_id'])){
            redirect(base_url().'welcome/login');
        }
        # 1 查询所有管理员信息
        $where['if_show'] = 1;
        $total_rows = $this->Admin_m->get_multiple_count('md_admin', $where);
        $per_page = 15;
        $config = array(
            'uri_segment' => 3,
            'base_url' => site_url('admin_manage/user_group_manage'),
            'per_page' => $per_page,
            'total_rows' => $total_rows,
        );
        $config['num_links'] = 20;
        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
        $orderby = 'ctime DESC';
        $data = $this->Admin_m->get_multiple('md_admin', $where, $start, $per_page, $orderby);

        $viewdata['pagination'] = $pagination;
        $viewdata['data'] = $data;
        $this->load->view('admin/user_list', $viewdata);
    }

    /**
     * 添加新的管理员
     */
    function create_useradmin() {
        if(empty($_SESSION['admin_id'])){
            redirect(base_url().'welcome/login');
        }
        if ($_POST) {
            # 验证必填项
            $error = array();
            $data['user_name'] = $this->input->post('name', true);
            $data['user_password'] = $this->input->post('password', true);
            $data['user_email'] = $this->input->post('email', true);
            $type = $this->input->post('type', true);
            $data['user_type'] = $type[0];
            $data['admin_group'] = $this->input->post('group', true);
            $data['edit_type'] = '1';
            $error = $this->_validate_admin($data);

            if (empty($error)) {
                #保存
                $data['user_password'] = md5($data['user_password']);
                unset($data['edit_type']);
                $result = $this->Admin_m->save('md_admin', $data);
                $_SESSION['save_message'] = '添加成功';
                redirect(base_url().'admin_manage/user_group_manage');
            }else {
                $group = $this->Admin_m->get_admin_group();
                $viewdata['group'] = $group;
                $viewdata['error'] = $error;
                $viewdata['data'] = $data;
                $this->load->view('admin/user_create', $viewdata);
            }
        }
        $group = $this->Admin_m->get_admin_group();
        $viewdata['group'] = $group;
        $this->load->view('admin/user_create', $viewdata);
    }
    
    /**
     * 删除管理员
     * @param type $admin_id
     */
    function user_delete($admin_id=0){
        if(empty($_SESSION['admin_id'])){
            redirect(base_url().'welcome/login');
        }
        $res = $this->Admin_m->delete('md_admin', $admin_id);
        $_SESSION['save_message'] = '删除成功';
        redirect(base_url().'admin_manage/user_group_manage');
    }
    
    /**
     * 管理员编辑
     * @param type $admin_id
     */
    function user_edit($admin_id = 0) {
        if(empty($_SESSION['admin_id'])){
            redirect(base_url().'welcome/login');
        }
        # 1 查询detail
        $data = $this->Admin_m->get_single_record('md_admin', array('id' => $admin_id, 'if_show' => 1));
        $viewdata['id'] = $admin_id;
        $viewdata['data'] = $data;
        $group = $this->Admin_m->get_admin_group();
        $viewdata['group'] = $group;
        if ($_POST) {
            # 验证必填项
            $error = array();
            $data['user_name'] = $this->input->post('name', true);
            $data['user_email'] = $this->input->post('email', true);
            $type = $this->input->post('type', true);
            $data['user_type'] = $type[0];
            $data['admin_group'] = $this->input->post('group', true);
            $admin_id = $this->input->post('admin_id', true);
            $data['edit_type'] = '2';
            $error = $this->_validate_admin($data);
            if (empty($error)) {
                #保存
                unset($data['edit_type']);
                $result = $this->Admin_m->update('md_admin', $admin_id, $data);
                $_SESSION['save_message'] = '修改成功';
                redirect(base_url().'admin_manage/user_group_manage');
            }else {
                $group = $this->Admin_m->get_admin_group();
                $viewdata['group'] = $group;
                $viewdata['error'] = $error;
                $viewdata['data'] = $data;
                $this->load->view('admin/user_edit', $viewdata);
            }
        } 
        $this->load->view('admin/user_edit', $viewdata);
    }

    /*
     * 错误信息判断
     */
    function _validate_admin($data = array()) {
        $error = array();
        if (empty($data['user_name'])){
            $error['user_name'] = '*请输入用户名';
        }elseif (mb_strlen($data['user_name']) > 30){
            $error['user_name'] = '*用户名超过30个字符';
        }
        if (empty($data['user_email'])){
            $error['user_email'] = '*请输入邮箱';
        }elseif (!preg_match('/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/', $data['user_email'])){
            $error['user_email'] = '*邮箱格式有误';
        }
        if (1 == $data['edit_type']) {
            if (empty($data['user_password'])) {
                $error['user_password'] = '*请输入密码';
            } elseif (strlen($data['user_password']) < 6) {
                $error['user_password'] = '*密码最少为6位';
            } elseif (strlen($data['user_password']) > 16) {
                $error['user_password'] = '*密码不能超过16位';
            }
            $if_have = $this->Admin_m->get_single_record('md_admin', array('user_email' => $data['user_email'], 'if_show' => 1));
            if(!empty($if_have)){
                $error['if_have'] = '*该邮箱用户已经存在';
            }
        }

        if (empty($data['user_type'])){
            $error['user_type'] = '*请选择管理员类型';
        }
        if (empty($data['admin_group'])){
            $error['admin_group'] = '*请选择管理员权限组';
        }
        
        return $error;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */