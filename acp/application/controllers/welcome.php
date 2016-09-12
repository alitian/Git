<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
    protected $_public_uri = array('welcome:logout', 'welcome:set_pwd');

    public function __construct() {
        parent::__construct();
        header("Content-type: text/html; charset=utf-8");
        session_start();
        $this->load->helper('url');
        $this->load->model('offer_m');
        $this->load->model('Common');
    }

    /**
     * 判断是否登陆
     * 如果未登陆进入登录页面
     */
    public function login() {

        $viewdata = array();

        if ($_POST) {
            # step 1 : 验证用户名密码
            $email = $this->input->post('loginname', true);
            $password = $this->input->post('password', true);

            if (!empty($email) && !empty($password)) {
                $if_login = $this->offer_m->get_admin_user_items($email,$password);             
                if (empty($if_login)) {
                    $error['login_error'] = '*用户名或密码错误，请重新输入';
                    $viewdata['data'] = $_POST;
                    $viewdata['error'] = $error;
                    unset($_POST);
                    $this->load->view('ckad/login', $viewdata);
                } else {
                    
                    $_SESSION['admin_name'] = $if_login['user_name'];
                    $_SESSION['admin_id'] = $if_login['id'];
                    $_SESSION['admin_email'] = $if_login['user_email'];
                    $_SESSION['admin_type'] = $if_login['user_type'];
                    $_SESSION['power_ids'] = ",{$if_login['group_item_ids']},";
                    $_SESSION['power_uri'] = $this->offer_m->md_admin_get_uid($if_login['group_item_ids']);
                    $_SESSION['power_uri'] = array_merge($_SESSION['power_uri'], $this->_public_uri);
                    if (isset($_SESSION['admin_from_url'])) {
                        $from_url = $_SESSION['admin_from_url'];
                        unset($_SESSION['admin_from_url']);
                        redirect($from_url);
                    } else {
                        redirect(base_url().'main/site');
                    }
                }
            } else {
                if (empty($email))
                    $error['username'] = '*请输入用户名';
                if (empty($password))
                    $error['password'] = '*请输入密码';
            }
        }
        else {
            $this->load->view('ckad/login', $viewdata);
        }
    }

    public function index() {
        $user_id = $_SESSION['admin_id'];
        if (empty($user_id)) {
            redirect(base_url().'welcome/login');
        }else{
            redirect(base_url().'main/site');
        }
    }
    
    /**
     * 退出登录
     */
    public function logout(){
        session_destroy();
        unset($_SESSION);
        redirect(base_url().'welcome/login');
    }
    
    /**
     * 重新设置密码
     */
    function set_pwd(){
        $data['error'] = $data['ok'] = '';
        if ($_POST) {
            if ($_POST['new_pwd'] == $_POST['cnew_pwd']) {
                $sql = "SELECT * FROM md_admin WHERE id='{$_SESSION['admin_id']}'";
                $user = $this->db->query($sql)->row_array();
                if (md5($_POST['old_pwd']) == $user['user_password']) {
                    $this->Common->update("md_admin", array('id' => $_SESSION['admin_id']), array('user_password' => md5($_POST['new_pwd'])));
                    $data['ok'] = '修改成功';
                } else {
                    $data['error'] = '原密码错误！';
                }
            } else {
                $data['error'] = '新密码两次输入不一致(⊙o⊙)…';
            }
        }
        $this->load->view('ckad/set_pwd', $data);        
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */