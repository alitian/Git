<?php

class Offer_m extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function get_admin_user_items($email = '', $password = '') {
        $sql = "SELECT adu.*,grp.group_item_ids FROM md_admin adu
                LEFT JOIN md_admin_group grp ON adu.admin_group=grp.id
                WHERE adu.`user_email`='{$email}' AND adu.`user_password`='" . md5($password) . "' AND adu.`if_show`=1";
        $result = $this->db->query($sql)->row_array();
        return $result;
    }

    /**
     * 根据Pid获取菜单列表
     * @param type $pid
     * @param type $ids
     * @return type
     */
    function md_admin_menu($pid = 0, $ids = '') {
        $sql = "SELECT * FROM md_admin_power_item WHERE pid={$pid} ORDER BY id DESC";
        $list = $this->db->query($sql)->result_array();
        $res = array();
        foreach ($list as $key => $item) {
            $list[$key]['id'] = $list[$key]['id'];
            $list[$key]['if_show'] = $list[$key]['if_show'];
            $list[$key]['name'] = $list[$key]['name'];
            $list[$key]['uri'] = $list[$key]['controller'] . "/" . $list[$key]['action'];
            $list[$key]['operation'] = '<a href="admin_about?edit=' . $list[$key]['id'] . '">修改</a> | <a href="admin_about?del=' . $list[$key]['id'] . '" onclick="return confirm(\'确认删除?\');">删除</a>';
            if (strpos($ids, $list[$key]['id']) !== FALSE) {
                $list[$key]['checked'] = true;
            } else {
                $list[$key]['checked'] = false;
            }
            $list[$key]['id'] = $list[$key]['id'];
            $list[$key]['children'] = $this->get_admin_children($list[$key]['id'], $ids);
        }
        return $list;
    }

    function get_admin_children($pid = 0, $ids = '') {
        $sql = "SELECT * FROM md_admin_power_item WHERE pid={$pid} ORDER BY id DESC";
        $list = $this->db->query($sql)->result_array();
        $res = array();
        foreach ($list as $key => $item) {
            $list[$key]['id'] = $list[$key]['id'];
            $list[$key]['if_show'] = $list[$key]['if_show'];
            $list[$key]['text'] = $list[$key]['name'];
            $list[$key]['uri'] = base_url() . $list[$key]['controller'] . "/" . $list[$key]['action'];
            $list[$key]['operation'] = '<a href="admin_about?edit=' . $list[$key]['id'] . '">修改</a> | <a href="admin_about?del=' . $list[$key]['id'] . '" onclick="return confirm(\'确认删除?\');">删除</a>';
            if (strpos($ids, $list[$key]['id']) !== FALSE) {
                $list[$key]['checked'] = true;
            } else {
                $list[$key]['checked'] = false;
            }
            $list[$key]['id'] = $item['id'];
        }
        return $list;
    }

    /**
     * 获取用户能够访问的uri列表
     */
    function md_admin_get_uid($pw_ids) {
        $result = array();
        if ($pw_ids) {
            $sql = "SELECT * FROM md_admin_power_item WHERE id IN ({$pw_ids})";
            $res = $this->db->query($sql)->result_array();
            foreach ($res as $item) {
                if ($item['controller']) {
                    if ($item['action'] == '') {
                        $item['action'] = 'index';
                    }
                    $result[] = $item['controller'] . ":" . $item['action'];
                }
                if ($item['plus_uri']) {
                    $item['plus_uri'] = explode(',', $item['plus_uri']);
                    foreach ($item['plus_uri'] as $v) {
                        $result[] = $v;
                    }
                }
            }
        }
        return $result;
    }
    
    
    function all_apk_serach($data,$limit=0){
        $res = array();
        $sql = "SELECT `id`, `name`, `pkg`, `apk`, `icon`, `versioncode`, `size`, `md5`, `status`,`createdate`, `updatedate` FROM `o_apk` WHERE 1 ";
       
        if (!empty($data["id"])) {
            $sql .= " and `id` IN (".$data["id"].")";
        }
        if (!empty($data["name"])) {
            $sql .= " and `name` LIKE '%" . $data["name"] . "%'";
        }
        if (!empty($data["c_start_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`createdate`) >= UNIX_TIMESTAMP('".$data["c_start_time"]."') ";
        }
        if (!empty($data["c_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`createdate`) <= UNIX_TIMESTAMP('".$data["end_time"]."')  ";
        }
        if (!empty($data["u_start_time"])) {           
            $sql.=" and UNIX_TIMESTAMP(`updatedate`) >= UNIX_TIMESTAMP('".$data["u_start_time"]."') ";
        }
        if (!empty($data["u_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`updatedate`) <= UNIX_TIMESTAMP('".$data["u_end_time"]."')  ";
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
        $res = $this->db->query($sql)->result_array(); 
        return $res;        
    }
    
    /**
     *将查询到的数据
     * 整理成需要展示在前端的数据格式
     * @param type $apk_mes
     */
    function deal_apk_mes($apk_mes=array()){
       $list_info = array();
        if (!empty($apk_mes)) {         
            foreach ($apk_mes as $key => $val) {
                $apk_mes[$key]['work'] = ' <a href="/offer_manage/edit_apk?id=' . $apk_mes[$key]['id'] . '" id="edit_apk" class="sel_btn ch_cls">编辑</a>';    
                $admin_id = $_SESSION['admin_id'];
                $this->load->model('Admin_m');
                $admin_mes = $this->Admin_m->get_single_record('md_admin', array('id' => $admin_id, 'if_show' => 1));
                if($admin_mes['user_type'] == 1){
                    $apk_mes[$key]['work'] .= ' | <a href="/offer_manage/delete_apk?id=' . $apk_mes[$key]['id'] . '" id="delete_apk" class="sel_btn ch_cls" onclick="if(confirm(\'确定要删除嘛？\')) return true;else return false;">删除</a>';
                }
                if ($apk_mes[$key]['status'] == '0') {
                    $apk_mes[$key]['status'] = '使用';                       
                } elseif ($apk_mes[$key]['status'] == '-1') {
                    $apk_mes[$key]['status'] = '废弃';                       
                }
            }
            $list_info = $apk_mes;
        } 
        return $list_info; 
    }
    
    /**
     * 判断目前添加的apk是否已经存在
     * @param type $name
     */
    function if_have_apk($name){
        $this->db->where('name', $name);
        $this->db->from('o_apk');
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }
    
    /**
     * 获取某一个
     * apk的数据信息
     * @param type $id
     */
    function get_apk($id=0){
        $this->db->where('id', $id);
        $this->db->from('o_apk');
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }
 
    function all_offer_serach($data,$limit=0){
        $res = array();
        $sql = "SELECT `id`, `type`, `provider`,`name`, `pkg`, `adid`, `apk`,`mainicon`,`offerid`, `preweight`, `weight`, `sinstall`, `status`, `createdate`, `updatedate` FROM `o_ad_forinstall` WHERE 1 ";
       
        if (!empty($data["id"])) {
            $sql .= " and `id` IN (".$data["id"].")";
        }
        if (!empty($data["adid"])) {
            $sql .= " and `adid` IN (".$data["adid"].")";
        }
        if (!empty($data["name"])) {
            $sql .= " and `name` LIKE '%" . $data["name"] . "%'";
        }
        if (!empty($data["type"])) {
            $sql .= " and `type` = '" . $data["type"] . "'";
        }
        if (!empty($data["pkg"])) {
            $sql .= " and `pkg` LIKE '%" . $data["pkg"] . "%'";
        }
        if (!empty($data["status"])) {
            if(3 == $data["status"]){
                $sql .= " and `status` = '0'";
            }else{
                $sql .= " and `status` = '" . $data["status"] . "'";
            }         
        }
        if (!empty($data["c_start_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`createdate`) >= UNIX_TIMESTAMP('".$data["c_start_time"]."') ";
        }
        if (!empty($data["c_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`createdate`) <= UNIX_TIMESTAMP('".$data["end_time"]."')  ";
        }
        if (!empty($data["u_start_time"])) {           
            $sql.=" and UNIX_TIMESTAMP(`updatedate`) >= UNIX_TIMESTAMP('".$data["u_start_time"]."') ";
        }
        if (!empty($data["u_end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(`updatedate`) <= UNIX_TIMESTAMP('".$data["u_end_time"]."')  ";
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
        $res = $this->db->query($sql)->result_array(); 
        return $res;     
    }
    
    function deal_offer_mes($offer_mes=array()){
        $list_info = array();
        if (!empty($offer_mes)) {         
            foreach ($offer_mes as $key => $val) {
                $offer_mes[$key]['work'] = ' <a href="/offer_manage/edit_offer?id=' . $offer_mes[$key]['id'] . '" id="edit_apk" class="sel_btn ch_cls">编辑</a>';    
                switch($offer_mes[$key]['type']){
                    case '1':
                        $offer_mes[$key]['type'] = 'Apk Offer';
                        break;
                    case '3':
                        $offer_mes[$key]['type'] = 'Affliate Offer';
                        break;
                }
                switch($offer_mes[$key]['status']){
                    case '-1':
                        $offer_mes[$key]['status'] = '下架';
                        break;
                    case '0':
                        $offer_mes[$key]['status'] = '上架';
                        break;
                    case '1':
                        $offer_mes[$key]['status'] = '页面修改失败';
                        break;
                    case '2':
                        $offer_mes[$key]['status'] = '没有有下载地址';
                        break;
                }
                
            }           
            $list_info = $offer_mes;
        } 
        return $list_info; 
    }
}
