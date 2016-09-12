<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Channel_manage extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        header("Content-type: text/html; charset=utf-8");
        session_start();
        $this->load->helper('url');
        $this->load->model('offer_m');
        $this->load->model('channel_m');
        $this->load->model('Common');
        $this->load->model('Admin_m');
        $this->load->library('pagination');     
    }
    
    /*************************渠道创建  start ***************************************************/
    
    /**
     * 创建添加
     * 新的渠道
     */
    function create_channel(){
        if(empty($_SESSION['admin_id'])){
            redirect(base_url().'welcome/login');
        }
        if($_POST){
            $sel_name = $this->input->post('name', true);
            $channel_name = $this->input->post('channel_name', true);
            $add_nums = $this->input->post('add_nums', true);
            $update_pack =isset($_POST['update_pack']) ? $_POST['update_pack'] : '';
            $update_ver = isset($_POST['update_ver']) ? $_POST['update_ver'] : '';
            $update_downurl_1 = $this->input->post('update_downurl_1', true);
            $update_memo = $this->input->post('update_memo', true);
            $private_json = isset($_POST['private_json']) ? $_POST['private_json'] : '';
            $add_arr = explode($sel_name,$channel_name);
            $num=0;
            if(empty($add_arr[1])){
                $num=0;
            }else{
                $num=$add_arr[1]+1;
            }
            
            for($i=0;$i<$add_nums;$i++){
                $token_name = $sel_name.($i+$num);
                $token_md5 = strtoupper(md5($root_inner['token']));
                $ctme = date('Y-m-d H:i:s');
                $root_inner['token'] = $token_name;
                $root_inner['channel_name'] = $token_md5;
                $root_inner['permission'] = 1;
                $root_inner['utime'] = $ctme;
                $root_inner['ctime'] = $ctme;
                $root_inner['package_md5'] = $update_memo;
                $root_inner['ispure'] = 0;
                $root_inner['public_json'] = '';
                $root_inner['private_json'] = $private_json; 
                
                $update_channel['update_name'] = $token_name;
                $update_channel['channel'] = $token_md5;
                $update_channel['update_pack'] = $update_pack;
                $update_channel['update_ver'] = $update_ver;
                $update_channel['update_downurl_1'] = $update_downurl_1;
                $update_channel['update_downurl_2'] = '';
                $update_channel['update_memo'] = $update_memo;
                $update_channel['supdate_status'] = 1; 
                
                $channel_id = $this->Common->add('kfkx_root_channel', $root_inner);
                $update_id = $this->Common->add('kfkx_rootsdk_update', $update_channel);
            }
            echo "<script>alert('添加成功！');location.replace('show_channel');</script>";
            return true;
        }else{
            $data = array();
            $sdk_sql = "SELECT * FROM `o_channel_sdk_item` WHERE `status`=1 ";
            $sdk_mes = $this->db->query($sdk_sql)->result_array(); 
            $data['sdk_mes'] = $sdk_mes;
            $this->load->view('channel_manage/create_channel', $data);    
        }
        
    }
    
    function ajax_channel_nums(){
        $channel_name = isset($_POST['channel_name']) ? $_POST['channel_name'] : '';
        
        $channel_sql = "SELECT token as channel_name FROM kfkx_root_channel WHERE token LIKE '%".$channel_name."%' ORDER BY id DESC limit 1";
        $channel_mes = $this->db->query($channel_sql)->row_array(); 
        echo json_encode(array('status' => '1','channel_name' => $channel_mes['channel_name']));
    }
    
    function ajax_sdk_mes(){
        $sdk_id = isset($_POST['sdk_id']) ? $_POST['sdk_id'] : '';
        $sdk_mes = $this->channel_m->get_sdk_mes($sdk_id);
        if(!empty($sdk_mes)){
            echo json_encode(array('status' => '1','sdk_mes' => $sdk_mes));
        }else{
            echo json_encode(array('status' => '-1'));
        }
    }
    
    /*************************渠道创建  end ***************************************************/
    
    /************************* 渠道查询 编辑  start *******************************************/
    
    /**
     * 按照自定义不同的条件
     * 查询渠道列表
     */
    function show_channel(){
        $data = array();
        $this->load->view('channel_manage/show_channel', $data);
    }
    
    function ajax_channel_list(){
        $res = array();
        $result = array();
        $res = $this->all_channel_search();

        $result = array(
            'total' => $res["num"],
            'rows' => $res["search"],
            'footer' => '',
        );

        echo json_encode($result);
    }
    
    function all_channel_search(){
        $search_arr["id"] = isset($_POST['id']) ? $_POST['id'] : '';
        $search_arr["token"] = isset($_POST['token']) ? $_POST['token'] : '';
        $search_arr["c_start_time"] = isset($_POST['c_start_time']) ? $_POST['c_start_time'] : '';
        $search_arr["c_end_time"] = isset($_POST['c_end_time']) ? $_POST['c_end_time'] : '';
        $search_arr["u_start_time"] = isset($_POST['u_start_time']) ? $_POST['u_start_time'] : '';
        $search_arr["u_end_time"] = isset($_POST['u_end_time']) ? $_POST['u_end_time'] : '';

        $search_arr["page"] = isset($_POST['page']) ? intval($_POST['page']) : '1';
        $search_arr["rows"] = isset($_POST['rows']) ? intval($_POST['rows']) : '20';

        $result = $this->channel_m->all_channel_serach($search_arr);
        $num = $this->channel_m->all_channel_serach($search_arr, -1);
        $list_info = $this->channel_m->deal_channel_mes($result);
        $channel_list_info = array();
        $channel_list_info["search"] = $list_info;
        $channel_list_info["num"] = $num;
        return $channel_list_info;        
    }
    
    function edit_channel(){
        $channel_id = $_GET['id'];
        if($_POST){
            $channel_mes['update_name'] = $this->input->post('name', true);
            $channel_mes['channel'] = $this->input->post('md5_key', true);
            $channel_mes['update_pack'] = $this->input->post('update_pack', true);
            $channel_mes['update_ver'] = $this->input->post('update_ver', true);
            $channel_mes['update_memo'] = $this->input->post('update_memo', true);
            $channel_mes['update_downurl_1'] = $this->input->post('update_downurl_1', true);     
            $channel_mes['update_time'] = date('Y-m-d H:i:s');
            $channel_update = $this->channel_m->get_channel_umes($channel_mes['channel']);
            $where = array('channel' => $channel_mes['channel']);
            if(empty($channel_update)){
                $channel_mes['supdate_status'] = 1;
                $update = $this->Common->add('kfkx_rootsdk_update', $channel_mes);
                $up = array('utime'=>$channel_mes['update_time'],'package_md5'=>$channel_mes['update_memo']);
                $this->Common->update('kfkx_root_channel', $where, $up);
            }else{
                $up = array('utime'=>$channel_mes['update_time'],'package_md5'=>$channel_mes['update_memo']);
                $this->Common->update('kfkx_root_channel', $where, $up);
                $update = $this->Common->update('kfkx_rootsdk_update', $where, $channel_mes);
            }          
            redirect(base_url() . 'channel_manage/show_channel');
        }  else {
            $channel_mes = $this->channel_m->get_channel_mes($channel_id);
            if (empty($channel_mes)) {
                echo "<script>alert('要编辑的渠道数据异常，请检查id!')</script>";
                return false;
            } else {
                $data['channel_mes'] = $channel_mes;
                $this->load->view('channel_manage/channel_edit', $data);
            }
        }
    }
    
    /************************* 渠道查询 编辑  end *******************************************/
    
    /************************* SDK 方案管理（添加 修改） start *******************************************/
    
    function channel_sdk(){
        $data = array();
        $this->load->view('channel_manage/show_channel_sdk', $data);
    }
    
    function ajax_channel_sdk(){
        $res = array();
        $result = array();
        $res = $this->all_sdk_search();

        $result = array(
            'total' => $res["num"],
            'rows' => $res["search"],
            'footer' => '',
        );

        echo json_encode($result);
    }
    
    function all_sdk_search(){
        $search_arr["id"] = isset($_POST['id']) ? $_POST['id'] : '';
        $search_arr["name"] = isset($_POST['name']) ? $_POST['name'] : '';
        $search_arr["status"] = isset($_POST['status']) ? $_POST['status'] : '';
        $search_arr["c_start_time"] = isset($_POST['c_start_time']) ? $_POST['c_start_time'] : '';
        $search_arr["c_end_time"] = isset($_POST['c_end_time']) ? $_POST['c_end_time'] : '';
        $search_arr["u_start_time"] = isset($_POST['u_start_time']) ? $_POST['u_start_time'] : '';
        $search_arr["u_end_time"] = isset($_POST['u_end_time']) ? $_POST['u_end_time'] : '';

        $search_arr["page"] = isset($_POST['page']) ? intval($_POST['page']) : '1';
        $search_arr["rows"] = isset($_POST['rows']) ? intval($_POST['rows']) : '20';

        $result = $this->channel_m->all_channel_sdk_serach($search_arr);
        $num = $this->channel_m->all_channel_sdk_serach($search_arr, -1);
        $list_info = $this->channel_m->deal_channel_sdk_mes($result);
        $sdk_list_info = array();
        $sdk_list_info["search"] = $list_info;
        $sdk_list_info["num"] = $num;
        return $sdk_list_info;    
    }
    
    function create_new_sdk(){
        $data['id'] = $this->input->post('id', true);
        $data['name'] = $this->input->post('name', true);
        $data['update_pack'] = $this->input->post('update_pack', true);
        $data['update_ver'] = isset($_POST['update_ver']) ? $_POST['update_ver'] : 'null';
        $data['update_downurl_1'] = isset($_POST['update_downurl_1']) ? $_POST['update_downurl_1'] : '';
        $data['update_memo'] = $this->input->post('update_memo', true);
        $data['private_json'] =isset($_POST['private_json']) ? $_POST['private_json'] : '';
        
        if($data['id'] == '' || empty($data['id'])) {
            $if_have = $this->channel_m->if_have_sdk($data['update_memo']);
            if(!empty($if_have)){
                echo "<script>alert('该SDK已经创建过!')</script>";
                return false;
            }else{
                $data['status']=0;
                $data['ctime'] = date('Y-m-d H:i:s');
                $data['utime'] = date('Y-m-d H:i:s');
                $inner_new_apk = $this->Common->add('o_channel_sdk_item',$data);
                return true;
            }            
        }else{
            $data['status']=$this->input->post('status', true);
            $where = array('id'=>$data['id']);
            $data['utime'] = date('Y-m-d H:i:s');
            $update_apk = $this->Common->update('o_channel_sdk_item', $where, $data);
            return true;
        }
    }
    
    function edit_channel_sdk(){
        $id = $_GET['id'];
        $sdk_mes = $this->channel_m->get_sdk_mes($id);
        if(empty($sdk_mes)){
           echo "<script>alert('要编辑的SDK数据异常，请检查id!')</script>";
           return false;
        }else{
            switch ($sdk_mes['status']) {
                case '-1':
                    $sdk_mes['status_name'] = '废弃';
                    break;
                case '1':
                    $sdk_mes['status_name'] = '使用';
                    break;
                case '2':
                    $sdk_mes['status_name'] = '延时使用';
                    break;
            }
            $data['sdk_mes'] = $sdk_mes;
           $this->load->view('channel_manage/channel_sdk_edit',$data);
        }
    }
    
    
    /************************* SDK 方案管理（添加 修改） end *******************************************/
    
    /************************* 渠道转化率  start *******************************************/
    
    function conversion_rates(){
        $data = array();
        $this->load->view('channel_manage/conversion_rates',$data);
    }
    
    function ajax_conversion_rates(){
        $res = array();
        $result = array();
        $res = $this->conversion_rates_search();

        $result = array(
            'total' => $res["num"],
            'rows' => $res["search"],
            'footer' => '',
        );

        echo json_encode($result);
    }
    
    function conversion_rates_search(){
        $search_arr["status"] = isset($_POST['status']) ? $_POST['status'] : '';
        $search_arr["channel_name"] = isset($_POST['channel_name']) ? $_POST['channel_name'] : '';
        $search_arr["country_code"] = isset($_POST['country_code']) ? $_POST['country_code'] : '';
        $search_arr["flag"] = isset($_POST['flag']) ? $_POST['flag'] : '';
        $search_arr["startdate"] = isset($_POST['startdate']) ? $_POST['startdate'] : '';
        $search_arr["enddate"] = isset($_POST['enddate']) ? $_POST['enddate'] : '';
        $search_arr["start_hour"] = isset($_POST['start_hour']) ? $_POST['start_hour'] : '';
        $search_arr["end_hour"] = isset($_POST['end_hour']) ? $_POST['end_hour'] : '';
        $search_arr["bysort"] = isset($_POST['bysort']) ? $_POST['bysort'] : '';
        $search_arr["byorder"] = isset($_POST['byorder']) ? $_POST['byorder'] : '';

        $search_arr["page"] = isset($_POST['page']) ? intval($_POST['page']) : '1';
        $search_arr["rows"] = isset($_POST['rows']) ? intval($_POST['rows']) : '20';
       // print_r($search_arr);exit;
        $result = $this->channel_m->conversion_rates_search($search_arr);
        $num = $this->channel_m->conversion_rates_search($search_arr, -1);
        $list_info = $this->channel_m->deal_onversion_rates_mes($result,$search_arr["startdate"],$search_arr["enddate"],$search_arr["start_hour"],$search_arr["end_hour"]);
        $sdk_list_info = array();
        $sdk_list_info["search"] = $list_info;
        $sdk_list_info["num"] = $num;
        return $sdk_list_info;           
    }
    
    /************************* 渠道转化率  end *******************************************/
    
    /************************* 渠道质量  start *******************************************/
    
    function channel_quality(){
        $data = array();
        $this->load->view('channel_manage/channel_quality',$data);
    }
    
    function ajax_channel_quality(){
        $res = array();
        $result = array();
        $res = $this->channel_quality_search();

        $result = array(
            'total' => $res["num"],
            'rows' => $res["search"],
            'footer' => '',
        );

        echo json_encode($result);
    }
    
    function channel_quality_search(){
        $search_arr["status"] = isset($_POST['status']) ? $_POST['status'] : '';
        $search_arr["id"] = isset($_POST['id']) ? $_POST['id'] : '';
        $search_arr["name"] = isset($_POST['name']) ? $_POST['name'] : '';
        $search_arr["start_time"] = isset($_POST['start_time']) ? $_POST['start_time'] : '';
        $search_arr["end_time"] = isset($_POST['end_time']) ? $_POST['end_time'] : '';
        $search_arr["byorder"] = isset($_POST['bysort']) ? $_POST['bysort'] : '';
        $search_arr["bysort"] = isset($_POST['byorder']) ? $_POST['byorder'] : '';

        $search_arr["page"] = isset($_POST['page']) ? intval($_POST['page']) : '1';
        $search_arr["rows"] = isset($_POST['rows']) ? intval($_POST['rows']) : '20';
       // print_r($search_arr);exit;
        $result = $this->channel_m->channel_quality_search($search_arr);
        $num = $this->channel_m->channel_quality_search($search_arr, -1);
        $list_info = $this->channel_m->deal_channel_quality_mes($result,$search_arr["start_time"],$search_arr["end_time"]);
        $sdk_list_info = array();
        $sdk_list_info["search"] = $list_info;
        $sdk_list_info["num"] = $num;
        return $sdk_list_info;   
    }
    
    /************************* 渠道质量  end *******************************************/
}

