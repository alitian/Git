<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Statistics extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        header("Content-type: text/html; charset=utf-8");
        session_start();
        $this->load->helper('url');
        $this->load->model('offer_m');
        $this->load->model('Common');
        $this->load->model('Admin_m');
        $this->load->model("Statistics_m");         
       
    }
    
/******************************************************** 实时数据  start ******************************************/    
    /**
     * 查看实时数据
     * 及一天24小时的
     */
    function realtime_data(){
        $this->load->library("Redis_cluster");
        // ================= TEST DEMO =================
// 只有一台 Redis 的应用
        $redis = new Redis_cluster(true);      
$redis->connect(array('host'=>'52.76.42.108','port'=>6400),true);
exit('asxas');
$redis->connect(array('host'=>'52.76.42.108','port'=>6401),false);
$redis->connect(array('host'=>'52.76.42.108','port'=>6402),false);

$today = date('Ymd');
$sinstall_key = 'adsinstall_' . $today;
        $key_exists = $redis->hget($sinstall_key,9143886); //判断key是否存在
        if (!$key_exists) {//不存在
            exit('asdf');
            return false;
        } else { 
            exit('1234');
        }
        if(empty($_SESSION['admin_id'])){
            redirect(base_url().'welcome/login');
        }
        $data = array();
        $this->load->view('statistics/offer_realtime_data', $data);
    }
    
    function ajax_realtime_data(){
        $res = array();
        $result = array();
        $res = $this->get_realtime_data();

        $result = array(
            'total' => $res["num"],
            'rows' => $res["search"],
            'footer' => '',
        );

        echo json_encode($result);
    }
    
    function get_realtime_data(){
        $search_arr['show_status'] = isset($_POST['show_status'])?$_POST['show_status']:'';
        $search_arr['status'] = isset($_POST['status'])?$_POST['status']:'';
        $search_arr['ad_id'] = isset($_POST['ad_id'])?$_POST['ad_id']:'';
        $search_arr['ad_name'] = isset($_POST['ad_name'])?$_POST['ad_name']:'';
        $search_arr['provider_id'] = isset($_POST['provider_id'])?$_POST['provider_id']:'';
        $search_arr['type'] = isset($_POST['type'])?$_POST['type']:'';
        $search_arr['bysort'] = isset($_POST['bysort'])?$_POST['bysort']:'';
        $search_arr['byorder'] = isset($_POST['byorder'])?$_POST['byorder']:'';
        
        $search_arr['page'] = isset($_POST['page']) ? intval($_POST['page']) : '1';
        $search_arr['rows'] = isset($_POST['rows']) ? intval($_POST['rows']) : '10';

        $result = $this->Statistics_m->all_realtime_data($search_arr);
        $num = $this->Statistics_m->all_realtime_data($search_arr, -1);
        $list_info = $this->Statistics_m->deal_realtime_data($result,$search_arr['start_time'],$search_arr['end_time']);
        $realtime_list_info = array();
        $realtime_list_info["search"] = $list_info;
        $realtime_list_info["num"] = $num;
        return $realtime_list_info; 
    }
    
    
    
/******************************************************** 实时数据  end ******************************************/
    
    
/******************************************************** 历史数据  start ******************************************/  
    
    /**
     * 根据不同的筛选条件
     * 查看历史数据
     */
    function history_data(){
        if(empty($_SESSION['admin_id'])){
            redirect(base_url().'welcome/login');
        }
        $data = array();
        $this->load->view('statistics/offer_history_data', $data);
    }
    
    function ajax_history_data(){
        $res = array();
        $result = array();
        $res = $this->get_history_data();

        $result = array(
            'total' => $res["num"],
            'rows' => $res["search"],
            'footer' => '',
        );

        echo json_encode($result);
    }
    
    function get_history_data() {
        $search_arr['show_status'] = isset($_POST['show_status'])?$_POST['show_status']:'';
        $search_arr['status'] = isset($_POST['status'])?$_POST['status']:'';
        $search_arr['ad_id'] = isset($_POST['ad_id'])?$_POST['ad_id']:'';
        $search_arr['ad_name'] = isset($_POST['ad_name'])?$_POST['ad_name']:'';
        $search_arr['provider_id'] = isset($_POST['provider_id'])?$_POST['provider_id']:'';
        $search_arr['type'] = isset($_POST['type'])?$_POST['type']:'';
        $search_arr['start_time'] = isset($_POST['start_time'])?$_POST['start_time']:'';
        $search_arr['end_time'] = isset($_POST['end_time'])?$_POST['end_time']:'';
        $search_arr['bysort'] = isset($_POST['bysort'])?$_POST['bysort']:'';
        $search_arr['byorder'] = isset($_POST['byorder'])?$_POST['byorder']:'';
        
        $search_arr['page'] = isset($_POST['page']) ? intval($_POST['page']) : '1';
        $search_arr['rows'] = isset($_POST['rows']) ? intval($_POST['rows']) : '10';

        $result = $this->Statistics_m->all_history_data($search_arr);
        $num = $this->Statistics_m->all_history_data($search_arr, -1);
        $list_info = $this->Statistics_m->deal_history_data($result,$search_arr['start_time'],$search_arr['end_time']);
        $history_list_info = array();
        $history_list_info["search"] = $list_info;
        $history_list_info["num"] = $num;
        return $history_list_info; 
    }
    
    /******************************************************** 历史数据  end ******************************************/      
}

