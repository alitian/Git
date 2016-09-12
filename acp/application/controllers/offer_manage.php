<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Offer_manage extends CI_Controller {
    
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
     * 广告APK管理
     */
    function offer_apk(){
        $data = array();
        $this->load->view('offer_manage/apk_manage',$data);
    }
    
    function ajax_all_apk(){
        $res = array();
        $result = array();
        $res = $this->all_apk_search();

        $result = array(
            'total' => $res["num"],
            'rows' => $res["search"],
            'footer' => '',
        );

        echo json_encode($result);
    }
    
    function all_apk_search(){
        $search_arr["id"] = isset($_POST['id']) ? $_POST['id'] : '';
        $search_arr["name"] = isset($_POST['name']) ? $_POST['name'] : '';
        $search_arr["c_start_time"] = isset($_POST['c_start_time']) ? $_POST['c_start_time'] : '';
        $search_arr["c_end_time"] = isset($_POST['c_end_time']) ? $_POST['c_end_time'] : '';
        $search_arr["u_start_time"] = isset($_POST['u_start_time']) ? $_POST['u_start_time'] : '';
        $search_arr["u_end_time"] = isset($_POST['u_end_time']) ? $_POST['u_end_time'] : '';
        $search_arr["bysort"] = isset($_POST['bysort']) ? $_POST['bysort'] : '';
        $search_arr["byorder"] = isset($_POST['byorder']) ? $_POST['byorder'] : '';

        $search_arr["page"] = isset($_POST['page']) ? intval($_POST['page']) : '1';
        $search_arr["rows"] = isset($_POST['rows']) ? intval($_POST['rows']) : '10';

        $result = $this->offer_m->all_apk_serach($search_arr);
        $num = $this->offer_m->all_apk_serach($search_arr, -1);
        $list_info = $this->offer_m->deal_apk_mes($result);
        $operator_list_info = array();
        $operator_list_info["search"] = $list_info;
        $operator_list_info["num"] = $num;
        return $operator_list_info;          
    }
    
    /**
     * 创建新的APK
     */
    function create_new_apk() {
        $data['id'] = $this->input->post('id', true);
        $data['name'] = $this->input->post('apk_name', true);
        $data['pkg'] = $this->input->post('pkg', true);
        $data['apk'] = $this->input->post('apk', true);
        $data['icon'] = isset($_POST['icon']) ? $_POST['icon'] : '';
        $data['versioncode'] = $this->input->post('versioncode', true);
        $data['size'] = $this->input->post('size', true);
        $data['md5'] = $this->input->post('md5', true);
        
        if($data['id'] == '' || empty($data['id'])) {
            $if_have = $this->offer_m->if_have_apk($data['name']);
            if(!empty($if_have)){
                echo "<script>alert('该APK已经创建过!')</script>";
                return false;
            }else{
                $data['status']=0;
                $data['createdate'] = date('Y-m-d H:i:s');
                $data['updatedate'] = date('Y-m-d H:i:s');
                $inner_new_apk = $this->Common->add('o_apk',$data);
                echo "<script>alert('创建成功')</script>";
                return true;
            }            
        }else{
            $where = array('id'=>$data['id']);
            $data['updatedate'] = date('Y-m-d H:i:s');
            $update_apk = $this->Common->update('o_apk', $where, $data);
            echo "<script>alert('编辑更新成功！');</script>";
            return true;
        }

    }
    
    /**
     * 编辑更新对应的
     * apk
     */
    function edit_apk(){        
        $apk_id = $_GET['id'];
        $apk_mes = $this->offer_m->get_apk($apk_id);
        if(empty($apk_mes)){
           echo "<script>alert('要编辑的apk异常，请检查id!')</script>";
           return false;
        }else{
           $data['apk_mes'] = $apk_mes;
           $this->load->view('offer_manage/apk_edit',$data);
        }       
    }
    
    /**
     * 将某一个apk置为废弃状态
     */
    function delete_apk(){     
        $apk_id = $_GET['id'];
        $apk_mes = $this->offer_m->get_apk($apk_id);
        if(empty($apk_mes)){
           echo "<script>alert('删除apk异常，请检查id!')</script>";
           return false;
        }else{
           $delete = "DELETE FROM `o_apk` WHERE `id`='".$apk_id."'"; 
           $this->db->query($delete);
           echo "<script>alert('删除成功！');location.replace('offer_apk');</script>";
           return true;
        }
    }
/**************************广告优化模块*****************************************************/
    /**
     * 广告的优化
     */
    function offer_optimization(){
        $data = array();
        $this->load->view('offer_manage/offer_optimization',$data);
    }
    
    function ajax_offer_optimi(){
        $res = array();
        $result = array();
        $res = $this->all_offer_search();

        $result = array(
            'total' => $res["num"],
            'rows' => $res["search"],
            'footer' => '',
        );
        echo json_encode($result);
    }
    
    function all_offer_search(){
        $search_arr["type"] = isset($_POST['type']) ? $_POST['type'] : '';
        $search_arr["id"] = isset($_POST['id']) ? $_POST['id'] : '';
        $search_arr["name"] = isset($_POST['name']) ? $_POST['name'] : '';
        $search_arr["adid"] = isset($_POST['adid']) ? $_POST['adid'] : '';
        $search_arr["pkg"] = isset($_POST['pkg']) ? $_POST['pkg'] : '';
        $search_arr["status"] = isset($_POST['status']) ? $_POST['status'] : '';
        $search_arr["c_start_time"] = isset($_POST['c_start_time']) ? $_POST['c_start_time'] : '';
        $search_arr["c_end_time"] = isset($_POST['c_end_time']) ? $_POST['c_end_time'] : '';
        $search_arr["u_start_time"] = isset($_POST['u_start_time']) ? $_POST['u_start_time'] : '';
        $search_arr["u_end_time"] = isset($_POST['u_end_time']) ? $_POST['u_end_time'] : '';
        $search_arr["bysort"] = isset($_POST['bysort']) ? $_POST['bysort'] : '';
        $search_arr["byorder"] = isset($_POST['byorder']) ? $_POST['byorder'] : '';

        $search_arr["page"] = isset($_POST['page']) ? intval($_POST['page']) : '1';
        $search_arr["rows"] = isset($_POST['rows']) ? intval($_POST['rows']) : '10';

        $result = $this->offer_m->all_offer_serach($search_arr);
        $num = $this->offer_m->all_offer_serach($search_arr, -1);
        $list_info = $this->offer_m->deal_offer_mes($result);
        $offer_list_info = array();
        $offer_list_info["search"] = $list_info;
        $offer_list_info["num"] = $num;
        return $offer_list_info; 
    }
    
    function edit_offer(){
        $id = $_GET['id'];
        if ($_POST) {
            # 验证必填项
            $error = array();
            $offer_mes['name'] = $this->input->post('name', true);
            $offer_mes['status'] = $this->input->post('status', true);
            $offer_mes['type'] = $this->input->post('type', true);
            $offer_mes['adid'] = intval($this->input->post('adid', true));
            $offer_mes['pullratio'] = intval($this->input->post('pullratio', true));
            $offer_mes['provider'] = intval($this->input->post('provider', true));
            $offer_mes['weight'] = intval($this->input->post('weight', true));
            $offer_mes['preweight'] = intval($this->input->post('pre_weight', true));
            $offer_mes['pkg'] = $this->input->post('pkg', true);
            $offer_mes['apk'] = $this->input->post('apk', true);
            $offer_mes['country'] = isset($_POST['country'])?$_POST['country']:'ALL';
            $offer_mes['ecountry'] = isset($_POST['ecountry'])?$_POST['ecountry']:'CN';
            $offer_mes['mainicon'] = intval($this->input->post('mainicon', true));
            $offer_mes['sinstall'] = intval($this->input->post('sinstall', true));
            $error = $this->_validate_operator($offer_mes);
            if (empty($error)) {
                #保存
                $where = array('id'=>$id);
                $offer_mes['updatedate'] = date('Y-m-d H:i:s');
                $insert_id = $this->Common->update('o_ad_forinstall', $where, $offer_mes);
                redirect(base_url().'offer_manage/offer_optimization');
            }else {
                $data['offer_mes'] = $offer_mes;
                $data['error'] = $error;
                $this->load->view('offer_manage/offer_edit', $data);
            }
        } else{
        $where = array('id'=>$id);
        $offer_mes = $this->Admin_m->get_single_record('o_ad_forinstall', $where);
        if(empty($offer_mes)){
           echo "<script>alert('要编辑的offer异常，请检查id!')</script>";
           return false;
        } else {
                switch ($offer_mes['type']) {
                    case '1':
                        $offer_mes['type_name'] = 'Apk Offer';
                        break;
                    case '3':
                        $offer_mes['type_name'] = 'Affliate Offer';
                        break;
                }
                switch ($offer_mes['status']) {
                    case '-1':
                        $offer_mes['status_name'] = '下架';
                        break;
                    case '0':
                        $offer_mes['status_name'] = '上架';
                        break;
                    case '1':
                        $offer_mes['status_name'] = '页面修改失败';
                        break;
                    case '2':
                        $offer_mes['status_name'] = '没有有下载地址';
                        break;
                }
                $data['offer_mes'] = $offer_mes;
                $this->load->view('offer_manage/offer_edit', $data);
            }
        }       
        
    }
    
    /**
     * 验证post数据
     * 是否符合要求
     * @param type $data
     */
    function _validate_operator($data){
        if (empty($data['name'])){
            $error['name'] = '*请输入用户名';
        }
        if ($data['status'] == ''){
            $error['status'] = '*请选择广告状态';
        }
        if ($data['type'] == ''){
            $error['type'] = '*请选择广告类型';          
        } else {
            if($data['type'] == 1){
                if(empty($data['adid'])){
                    $error['adid'] = '*当广告类型是Apk Offer时，adid不能为空';  
                }else{
                    if(!is_int($data['adid'])){
                        $error['adid'] = '*adid是正整数int型';  
                    }
                }
            }else{
                if(!empty($data['adid'])){
                    $error['adid'] = '*广告类型只有是Apk Offer时才可以填写adid';  
                }
            }
        }
        if(empty($data['pullratio']) ){
             $error['pullratio'] = '*不能为空';  
        }else{
            if (!is_int($data['pullratio'])) {
                 $error['pullratio'] = '*pullratio是正整数int型';
            }elseif( $data['pullratio'] > 100){
                    $error['pullratio'] = '*控制在1-100';
            }
        }
        if(empty($data['weight']) ){
             $error['weight'] = '*不能为空';  
        }else{
            if (!is_int($data['weight'])) {
                 $error['weight'] = '*weight是正整数';
            }
        }
        if(empty($data['preweight']) ){
             $error['preweight'] = '*不能为空';  
        }else{
            if (!is_int($data['preweight'])) {
                 $error['preweight'] = '*preweight是正整数';
            }
        }
        if (empty($data['pkg'])){
            $error['pkg'] = '*请输入pkg';
        }
        if (empty($data['apk'])){
            $error['apk'] = '*请输入apk';
        }
        if(empty($data['mainicon']) ){
             $error['mainicon'] = '*不能为空';  
        }else{
            if (!is_int($data['mainicon'])) {
                 $error['mainicon'] = '*pullratio是正整数int型';
            }
        }
        
        if(empty($data['sinstall']) ){
             $error['sinstall'] = '*不能为空';  
        }else{
            if (!is_int($data['sinstall'])) {
                 $error['sinstall'] = '*pullratio是正整数int型';
            }elseif( $data['sinstall'] > 100){
                    $error['sinstall'] = '*控制在1-100';
            }
        }
        return $error;
    }
    
/**************************************************************************************************/    
    /**
     * 广告配置
     */
    function offer_status(){
        
    }
}

