<?php

class Channel_m extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    /**
     * 根据查询条件
     * 获取渠道数据
     * @param type $data
     * @param type $limit
     */
    function all_channel_serach($data,$limit=0){
        $res = array();
        $sql  = "SELECT c.`id`,c.`token` as name,c.`channel_name` as md5_key,c.`utime` as update_time,c.`ctime`,u.`update_pack`, u.`update_ver`, u.`update_downurl_1` ,u.`update_memo` ";
         $sql .= "  FROM `kfkx_root_channel` c LEFT JOIN `kfkx_rootsdk_update` u  ON CONVERT(u.`update_name` USING utf8)=CONVERT(c.`token` USING utf8) WHERE 1 ";
       
        if (!empty($data["id"])) {
            $sql .= " and c.`id` IN (".$data["id"].")";
        }
        if (!empty($data["token"])) {
            $sql .= " and c.`token` LIKE '%" . $data["token"] . "%'";
        }
        if (!empty($data["c_start_time"])) {
            $sql.=" and UNIX_TIMESTAMP(c.`ctime`) >= UNIX_TIMESTAMP('".$data["c_start_time"]."') ";
        }
        if (!empty($data["c_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(c.`ctime`) <= UNIX_TIMESTAMP('".$data["end_time"]."')  ";
        }
        if (!empty($data["u_start_time"])) {           
            $sql.=" and UNIX_TIMESTAMP(u.`update_time`) >= UNIX_TIMESTAMP('".$data["u_start_time"]."') ";
        }
        if (!empty($data["u_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(u.`update_time`) <= UNIX_TIMESTAMP('".$data["u_end_time"]."')  ";
        }
        $sql.=" order by c.id ASC";        
        if ($limit == -1) {
            return $this->db->query($sql)->num_rows();
        }
        if (!empty($data["page"]) && !empty($data["rows"])) {
            if ($data["page"] > 1) {
                $start = ($data["page"] - 1) * $data["rows"];
                $sql.=" limit " . $start . "," . $data["rows"] . " ";
            } else {
                $sql.=" limit 0," . $data["rows"] . " ";
            }
        }
       // echo $sql;exit;
        $res = $this->db->query($sql)->result_array(); 
        return $res;        
    }
    
    function deal_channel_mes($channel_arr = array()){
        $list_info = array();
        if (!empty($channel_arr)) {         
            foreach ($channel_arr as $key => $val) {
                $channel_arr[$key]['work'] = ' <a href="/channel_manage/edit_channel?id=' . $channel_arr[$key]['id'] . '" id="edit_channel" class="sel_btn ch_cls">编辑</a>';               
            }
            $list_info = $channel_arr;
        } 
        return $list_info;
    }
    
    function get_channel_mes($channel_id){
        $res = array();
        $sql  = "SELECT c.`id`,c.`token` as name,c.`channel_name` as md5_key,u.`update_time` as update_time,c.`ctime`,u.`update_pack`, u.`update_ver`, u.`update_downurl_1` ,u.`update_memo` ";
        $sql .= "  FROM `kfkx_root_channel` c LEFT JOIN `kfkx_rootsdk_update` u ON CONVERT(u.`update_name` USING utf8)=CONVERT(c.`token` USING utf8) WHERE c.`id`='".$channel_id."' ";
        $res = $this->db->query($sql)->row_array(); 
        return $res;
    }
    
    function get_channel_umes($channel){
        $res = array();
        $sql = "SELECT * FROM `kfkx_rootsdk_update` WHERE `channel`='".$channel."'";
        $res = $this->db->query($sql)->row_array(); 
        return $res;
    } 
    
    function if_have_sdk($update_memo){
        $res = array();
        $sql = "SELECT * FROM `o_channel_sdk_item` WHERE `update_memo`='".$update_memo."'";
        $res = $this->db->query($sql)->row_array(); 
        return $res;
    }
    
    function all_channel_sdk_serach($data,$limit=0){
        $res = array();
        $sql  = "SELECT * FROM `o_channel_sdk_item` WHERE 1 ";
       
        if (!empty($data["id"])) {
            $sql .= " and `id` IN (".$data["id"].")";
        }
        if (!empty($data["name"])) {
            $sql .= " and `name` LIKE '%" . $data["name"] . "%'";
        }
        if (!empty($data["status"])) {
            $sql .= " and `status` = '" . $data["status"] . "'";
        }
        if (!empty($data["c_start_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`ctime`) >= UNIX_TIMESTAMP('".$data["c_start_time"]."') ";
        }
        if (!empty($data["c_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`ctime`) <= UNIX_TIMESTAMP('".$data["end_time"]."')  ";
        }
        if (!empty($data["u_start_time"])) {           
            $sql.=" and UNIX_TIMESTAMP(`utime`) >= UNIX_TIMESTAMP('".$data["u_start_time"]."') ";
        }
        if (!empty($data["u_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`utime`) <= UNIX_TIMESTAMP('".$data["u_end_time"]."')  ";
        }
        $sql.=" order by id ASC";        
        if ($limit == -1) {
            return $this->db->query($sql)->num_rows();
        }
        if (!empty($data["page"]) && !empty($data["rows"])) {
            if ($data["page"] > 1) {
                $start = ($data["page"] - 1) * $data["rows"];
                $sql.=" limit " . $start . "," . $data["rows"] . " ";
            } else {
                $sql.=" limit 0," . $data["rows"] . " ";
            }
        }
        $res = $this->db->query($sql)->result_array(); 
        return $res; 
    }
    
    function deal_channel_sdk_mes($sdk_mes){
        $list_info = array();
        if (!empty($sdk_mes)) {         
            foreach ($sdk_mes as $key => $val) {
                $sdk_mes[$key]['work'] = ' <a href="/channel_manage/edit_channel_sdk?id=' . $sdk_mes[$key]['id'] . '" id="edit_channel_sdk" class="sel_btn ch_cls">编辑</a>';               
                switch($sdk_mes[$key]['status']){
                    case '-1':
                        $sdk_mes[$key]['status'] = '废弃';
                        break;
                    case '1':
                        $sdk_mes[$key]['status'] = '使用';
                        break;
                    case '2':
                        $sdk_mes[$key]['status'] = '延时使用';
                        break;
                }
                
            }
            $list_info = $sdk_mes;
        } 
        return $list_info;
    }
    
    function get_sdk_mes($id=0){
        $res = array();
        $sql = "SELECT * FROM `o_channel_sdk_item` WHERE `id`='".$id."'";
        $res = $this->db->query($sql)->row_array(); 
        return $res;
    }
    
    function channel_quality_search($data,$limit=0){
        $res = array();
        if($data['status'] == 2){
            $sql  = "SELECT `id`, `channel_name`, SUM(`req_uv`) as req_uv , SUM(`req_ad`) as req_ad , SUM(`click_uv`) as click_uv , SUM(`click_ad`) as click_ad, SUM(`down_uv`) as down_uv , SUM(`down_ad`) as down_ad, SUM(`install_uv`) as install_uv, SUM(`install_ad`) as install_ad  FROM `o_channel_install_daily` WHERE 1 ";                  
            
        }else{
            $sql = "SELECT * FROM `o_channel_install_daily` WHERE 1 ";
        }
        if (!empty($data["id"])) {
            $sql .= " and `id` IN (".$data["id"].")";
        }
        if (!empty($data["name"])) {
            $sql .= " and `channel_name`='" . $data["name"] . "'";
        }
        if (!empty($data["start_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`date`) >= UNIX_TIMESTAMP('".$data["start_time"]."') ";
        }
        if (!empty($data["end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`date`) <= UNIX_TIMESTAMP('".$data["end_time"]."')  ";
        }
        if($data['status'] == 2){
            $sql  .= " GROUP BY channel_name";                  
            
        }
        if (!empty($data["bysort"])) {
            $sql.=" order by ".$data["bysort"]." ";
        }else{
            $sql.=" order by id ";
        }        
        if (!empty($data["byorder"])) {
            $sql.=" ".$data["byorder"]." ";
        }else{
            $sql.=" ASC";
        }
        
        if ($limit == -1) {
            return $this->db->query($sql)->num_rows();
        }
        if (!empty($data["page"]) && !empty($data["rows"])) {
            if ($data["page"] > 1) {
                $start = ($data["page"] - 1) * $data["rows"];
                $sql.=" limit " . $start . "," . $data["rows"] . " ";
            } else {
                $sql.=" limit 0," . $data["rows"] . " ";
            }
        }
        //echo $sql;exit;
        $res = $this->db->query($sql)->result_array(); 
        return $res;         
    }
    
    function deal_channel_quality_mes($quality_mes,$start_time='',$end_time=''){
        $list_info = array();
        if (!empty($quality_mes)) {         
            foreach ($quality_mes as $key => $val) {
                if(!empty($start_time)){
                    $quality_mes[$key]['start_time'] = $start_time;
                }else{
                    $quality_mes[$key]['start_time'] = $quality_mes[$key]['date'];
                }
                
                if(!empty($end_time)){
                   $quality_mes[$key]['end_time'] = $end_time;
                }else{
                    $quality_mes[$key]['end_time'] = $quality_mes[$key]['date'];
                }               
            }
            $list_info = $quality_mes;
        } 
        return $list_info;
    }
    
    function conversion_rates_search($data,$limit=0){
        $res = array();
        if($data['status'] == 1 || $data['status'] == ''){
            $sql = "SELECT `id`, `channel_name`, `country_code`, `uv`, `rootuv`,convert(((rootuv/uv)*100),decimal) as cr, `flag`, `date`, `hour` FROM `s_channel_cr_hourly` WHERE 1 ";
        }else{
            $sql = "SELECT `id`, `channel_name`, `country_code`, SUM(`uv`) as uv, SUM(`rootuv`) as rootuv, convert(((sum(rootuv)/SUM(uv))*100),decimal) as cr,`flag`, `date`, `hour` FROM `s_channel_cr_hourly` WHERE 1 ";
        }        
        if (!empty($data["channel_name"])) {
            $sql .= " and `channel_name`='" . $data["channel_name"] . "'";
        }
        if (!empty($data["country_code"])) {
            $sql .= " and `country_code`='" . $data["country_code"] . "'";
        }
        if (!empty($data["flag"])) {
            $sql .= " and `flag`='" . $data["flag"] . "'";
        }
        if (!empty($data["startdate"])) {
            $sql.=" and UNIX_TIMESTAMP(`date`) >= UNIX_TIMESTAMP('".$data["startdate"]."') ";
        }
        if (!empty($data["enddate"])) {
            $sql.=" and UNIX_TIMESTAMP(`date`) <= UNIX_TIMESTAMP('".$data["enddate"]."')  ";
        }
        if (!empty($data["start_hour"])) {
            $sql.=" and `hour` >= '".$data["start_hour"]."' ";
        }
        if (!empty($data["end_hour"])) {
            $sql.=" and `hour` <= '".$data["end_hour"]."'  ";
        }

        if($data['status'] == 2 ||  $data['status'] == 3  ){
            $sql  .= " GROUP BY channel_name "; 
        }
        
        if (!empty($data["byorder"])) {
            $sql.=" order by ".$data["byorder"]." ";
        }else{
            $sql.=" order by id ";
        }        
        if (!empty($data["bysort"])) {
            $sql.=" ".$data["bysort"]." ";
        }else{
            $sql.=" ASC";
        }
        
        if ($limit == -1) {
            return $this->db->query($sql)->num_rows();
        }
        if (!empty($data["page"]) && !empty($data["rows"])) {
            if ($data["page"] > 1) {
                $start = ($data["page"] - 1) * $data["rows"];
                $sql.=" limit " . $start . "," . $data["rows"] . " ";
            } else {
                $sql.=" limit 0," . $data["rows"] . " ";
            }
        }
        //echo $sql;exit;
        $res = $this->db->query($sql)->result_array(); 
        return $res;          
    }
    
    function deal_onversion_rates_mes($onversion_rates_mes,$startdate,$enddate,$start_hour,$end_hour){
        $list_info = array();
        if (!empty($onversion_rates_mes)) {         
            foreach ($onversion_rates_mes as $key => $val) {
                if(!empty($startdate)){
                    $onversion_rates_mes[$key]['startdate'] = $startdate;
                }else{
                    $onversion_rates_mes[$key]['startdate'] = $onversion_rates_mes[$key]['date'];
                }
                
                if(!empty($enddate)){
                   $onversion_rates_mes[$key]['enddate'] = $enddate;
                }else{
                    $onversion_rates_mes[$key]['enddate'] = $onversion_rates_mes[$key]['date'];
                }
                if(!empty($start_hour)){
                    $onversion_rates_mes[$key]['starthour'] = $start_hour;
                }else{
                    $onversion_rates_mes[$key]['starthour'] = $onversion_rates_mes[$key]['hour'];
                }
                
                if(!empty($end_hour)){
                   $onversion_rates_mes[$key]['endhour'] = $end_hour;
                }else{
                    $onversion_rates_mes[$key]['endhour'] = $onversion_rates_mes[$key]['hour'];
                }
            }
            $list_info = $onversion_rates_mes;
        } 
        return $list_info;        
    }
}
