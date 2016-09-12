<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Operator_manage extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        header("Content-type: text/html; charset=utf-8");
        session_start();
        $this->load->helper('url');
        $this->load->model('offer_m');
        $this->load->model('Common');
        $this->load->model('Admin_m');
        $this->load->model('Operator_m');   
    }
    
    /**
     * 创建添加
     * 新的渠道
     */
    function create_oper(){
        if(empty($_SESSION['admin_id'])){
            redirect(base_url().'welcome/login');
        }
        if ($_POST) {
            # 验证必填项
            $error = array();
            $data['id'] = $this->input->post('oper_id', true);
            $data['name'] = $this->input->post('oper_name', true);
            $data['weight'] = isset($_POST['oper_weight'])?$_POST['oper_weight']:'5';
            $data['pre_weight'] = isset($_POST['oper_weight'])?$_POST['oper_weight']:'25';
            $data['cap'] = $this->input->post('oper_cap', true); 
            $data['sinstall'] = $this->input->post('oper_sinstall', true);
            $error = $this->_validate_operator($data);
            if (empty($error)) {
                #保存
                $data['status'] = 0;
                $data['createdate'] = date('Y-m-d H:i:s');
                $data['updatedate'] = date('Y-m-d H:i:s');
                $insert_id = $this->Common->add("o_provider", $data);
                redirect(base_url().'operator_manage/show_oper');
            }else {
                $viewdata['data'] = $data;
                $viewdata['error'] = $error;
                $this->load->view('operator_manage/create_operator', $viewdata);
            }
        }else{
            $viewdata = array();
            $this->load->view('operator_manage/create_operator', $viewdata);
        }
        
    }
    
    function _validate_operator($data,$limit=0){
        $error = array();
        if ($limit = 0) {
            if (empty($data['id'])) {
                $error['id'] = '*请给一个联盟id';
            } else {
                if (!is_numeric($data['id'])) {
                    $error['id'] = '*所填不合法，请填写数字';
                } else {
                    if ($data['id'] <= 0) {
                        $error['id'] = '*联盟id不能为负';
                    }
                }
            }
            $if_have_sql = "SELECT * FROM o_provider WHERE id='" . $data['id'] . "' ";
            $if_have = $this->db->query($if_have_sql)->row_array();
            if (!empty($if_have)) {
                $error['if_have'] = '*这个联盟已经存在';
            }
        }
        if (empty($data['name'])){
            $error['name'] = '*请输入用户名';
        }

        if (empty($data['cap'])){
            $error['cap'] = '*请给一个安装限制数';
        }  else {
            if (!is_int($data['cap'])) {
                $error['cap'] = '*所填不合法，请填写数字';
            }  else {
                if ($data['cap'] > 100 || $data['cap'] <= 0) {
                    $error['cap'] = '*安装限制在1-100之间';
                }
            }
        }
        if(empty($data['weight'])){
            $error['weight'] = '*请给一个权重数';
        }else{
            if(!is_int($data['weight'])){
                $error['weight'] = '*填写不合法，请填写数字';
            }else{
                if ($data['weight'] <= 0) {
                    $error['weight'] = '*权重不能为负';
                }
            }
        }
        if(empty($data['pre_weight'])){
            $error['pre_weight'] = '*请给一个预权重数';
        }else{
            if(!is_int($data['pre_weight'])){
                $error['pre_weight'] = '*填写不合法，请填写数字';
            }else{
                if ($data['pre_weight'] <= 0) {
                    $error['pre_weight'] = '*预权重不能为负';
                }
            }
        }

        return $error;
    }
    /**
     * 按照自定义不同的条件
     * 查询渠道列表
     */
    function show_oper(){
//        $str ="6227603";
//        $str = md5($str);
//        echo $str;exit;
        $data = array();
        $this->load->view('operator_manage/show_operator', $data);
    }
    
    /**
     * ajax请求的查询方法
     */
    function ajax_operator_list(){
        $res = array();
        $result = array();
        $res = $this->all_operator_search();

        $result = array(
            'total' => $res["num"],
            'rows' => $res["search"],
            'footer' => '',
        );

        echo json_encode($result);
    }
    
    /**
     * 执行查询条件获取post
     * 进行查询select操作
     * 整理需要输出的 json 内容
     */
    function all_operator_search(){
        $search_arr["id"] = isset($_POST['id']) ? $_POST['id'] : '';
        $search_arr["name"] = isset($_POST['name']) ? $_POST['name'] : '';
        $search_arr["status"] = isset($_POST['status']) ? $_POST['status'] : '';
        $search_arr["c_start_time"] = isset($_POST['c_start_time']) ? $_POST['c_start_time'] : '';
        $search_arr["c_end_time"] = isset($_POST['c_end_time']) ? $_POST['c_end_time'] : '';
        $search_arr["u_start_time"] = isset($_POST['u_start_time']) ? $_POST['u_start_time'] : '';
        $search_arr["u_end_time"] = isset($_POST['u_end_time']) ? $_POST['u_end_time'] : '';
        $search_arr["bysort"] = isset($_POST['bysort']) ? $_POST['bysort'] : '';
        $search_arr["byorder"] = isset($_POST['byorder']) ? $_POST['byorder'] : '';

        $search_arr["page"] = isset($_POST['page']) ? intval($_POST['page']) : '1';
        $search_arr["rows"] = isset($_POST['rows']) ? intval($_POST['rows']) : '10';

        $result = $this->Operator_m->all_operator_serach($search_arr);
        $num = $this->Operator_m->all_operator_serach($search_arr, -1);
        $list_info = $this->Operator_m->deal_operator_mes($result);
        $operator_list_info = array();
        $operator_list_info["search"] = $list_info;
        $operator_list_info["num"] = $num;
        return $operator_list_info;        
    }
    
    /**
     * 编辑更新联盟信息
     */
    function edit_operator() {
        if ($_POST) {
            # 验证必填项
            $error = array();
            $oper_id = $_GET['oper_id'];
           if (empty($oper_id) || !is_numeric($oper_id)) {
                $error['if_have'] = '修改的联盟不合法';
            }
            $if_have_sql = "SELECT * FROM o_provider WHERE id='" . $oper_id . "' ";
            $oper_mes = $this->db->query($if_have_sql)->row_array();
            if (empty($oper_mes)) {
                $error['if_have'] = '修改的联盟id不存在';
            }
            $data['name'] = $this->input->post('oper_name', true);
            $data['weight'] = isset($_POST['oper_weight'])?$_POST['oper_weight']:'5';
            $data['pre_weight'] = isset($_POST['oper_weight'])?$_POST['oper_weight']:'25';
            $data['cap'] = $this->input->post('oper_cap', true); 
            $error = $this->_validate_operator($data,1);
            if (empty($error)) {
                #保存
                $data['updatedate'] = date('Y-m-d H:i:s');
                //print_r($data);exit;
                $this->Common->update("o_provider", array('id' => $_GET['oper_id']), $data);
                redirect(base_url().'operator_manage/show_oper');
            }else {
                $viewdata['oper_mes'] = $data;
                $viewdata['error'] = $error;
                $this->load->view('operator_manage/edit_operator', $viewdata);
            }           
        } else {
            $oper_id = $_GET['oper_id'];
            if (empty($oper_id) || !is_numeric($oper_id)) {
                echo "<script>alert('您查看的联盟id不合法！');location.replace('show_oper');</script>";
                return false;
            }
            $if_have_sql = "SELECT * FROM o_provider WHERE id='" . $oper_id . "' ";
            $oper_mes = $this->db->query($if_have_sql)->row_array();
            if (empty($oper_mes)) {
                echo "<script>alert('您查看的联盟不存在！');location.replace('show_oper');</script>";
                return false;
            } else {
                $data['oper_mes'] = $oper_mes;
                $this->load->view('operator_manage/edit_operator', $data);
            }
        }
    }
    
    function update_oper_status(){
        $result_arr = array('result' => 'error', 'error' => '参数错误');
        if (isset($_POST['id']) && isset($_POST['val'])) {
            $res = $this->Common->update('o_provider', array('id' => $_POST['id']), array($_POST['type'] => $_POST['val'] == 'false' ? -1 : 0));
            $result_arr = array('result' => $res);
        }
        echo json_encode($result_arr);        
    }

}

