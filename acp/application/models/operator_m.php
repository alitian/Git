<?php
class Operator_m extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    function all_operator_serach($data,$limit=0){
       // $now_tme = date("Y-m-d H:i:s");
        $res = array();
        $sql = "SELECT o.`id`,o.`name`,o.`url`,o.`weight`,o.`pre_weight`,o.`cap`,o.`sinstall`,o.`status`,o.`createdate`,o.`updatedate` FROM `o_provider` o WHERE 1 ";
       
        if (!empty($data["id"])) {
            $sql .= " and o.`id` IN (".$data["id"].")";
        }
        if (!empty($data["name"])) {
            $sql .= " and o.`name` LIKE '%" . $data["name"] . "%'";
        }
        if (!empty($data["status"])) {
            $sql .= " and o.`status` = '".$data["status"]."'";
        }
        if (!empty($data["c_start_time"])) {
            $sql.=" and UNIX_TIMESTAMP(o.`createdate`) >= UNIX_TIMESTAMP('".$data["c_start_time"]."') ";
        }
        if (!empty($data["c_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(o.`createdate`) <= UNIX_TIMESTAMP('".$data["end_time"]."')  ";
        }
        if (!empty($data["u_start_time"])) {           
            $sql.=" and UNIX_TIMESTAMP(o.`updatedate`) >= UNIX_TIMESTAMP('".$data["u_start_time"]."') ";
        }
        if (!empty($data["u_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(o.`updatedate`) <= UNIX_TIMESTAMP('".$data["u_end_time"]."')  ";
        }
        if (!empty($data["byorder"])) {
            $sql.=" order by o.".$data["byorder"]." ";
        }else{
            $sql.=" order by o.id ";
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
        $res = $this->db->query($sql)->result_array(); 
        return $res;
    }
    
    /**
     * 将查询到的数据
     * 整理成需要展示在前端的数据格式
     * @param type $operator_arr
     */
    function deal_operator_mes($operator_arr = array()){
        $list_info = array();
        if (!empty($operator_arr)) {         
            foreach ($operator_arr as $key => $val) {
                $operator_arr[$key]['work'] = ' <a href="/operator_manage/edit_operator?oper_id=' . $operator_arr[$key]['id'] . '" id="edit_operator" class="sel_btn ch_cls">编辑</a>';               
                $operator_arr[$key]['ctime'] = $operator_arr[$key]['createdate'];
                $operator_arr[$key]['utime'] = $operator_arr[$key]['updatedate']; 
                if ($operator_arr[$key]['status'] == '0') {
                    $operator_arr[$key]['status'] = '打开';                       
                } elseif ($operator_arr[$key]['status'] == '-1') {
                    $operator_arr[$key]['status'] = '关闭';                       
                }
            }
            $list_info = $operator_arr;
        } 
        return $list_info;
    }   
}

