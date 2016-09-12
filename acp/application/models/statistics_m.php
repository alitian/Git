<?php

class Statistics_m extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function all_history_data($data, $limit = 0) {
        $res = array();
        if ($data['show_status'] == 1 || $data['show_status'] == '' || $data['show_status'] == 4) {
            $sql = "SELECT a.`id` as adid, a.`type`,a.`provider` as provider_id, a.`name` as ad_name, a.`cap`, a.`price`, a.`preweight`, a.`weight`, a.`status` , "
                    . " b.`date`, b.`postnum`, b.`installnum`, b.`sendnum` , convert(((b.`postnum`/b.`installnum`)*100),decimal) as cr"
                    . " FROM `o_ad` a INNER JOIN `o_adstatsback` b ON a.`id`=b.`adid` WHERE 1 ";
        } else {
            $sql = "SELECT a.`id` as adid, a.`type`,a.`provider` as provider_id, a.`name` as ad_name, a.`cap`, a.`price`, a.`preweight`, a.`weight`, a.`status` , "
                    . " b.`date`, SUM(b.`postnum`) as postnum , SUM(b.`installnum`) as installnum ,SUM(b.`sendnum`) as sendnum ,convert(((SUM(b.`postnum`)/SUM(b.`installnum`))*100),decimal) as cr "
                    . " FROM `o_ad` a INNER JOIN `o_adstatsback` b ON a.`id`=b.`adid` WHERE 1 ";
        }
        if (!empty($data["ad_id"])) {
            $sql .= " and a.`id` IN (" . $data["ad_id"] . ")";
        }
        if (!empty($data["ad_name"])) {
            $sql .= " and a.`name`='" . $data["ad_name"] . "'";
        }
        if (!empty($data["provider_id"])) {
            $sql .= " and a.`provider` IN (" . $data["provider_id"] . ")";
        }
        if (!empty($data["type"])) {
            $sql .= " and a.`type` = '" . $data["type"] . "'";
        }
        if (!empty($data["status"])) {
            if (3 == $data["status"]) {
                $sql .= " and a.`status` = '0'";
            } else {
                $sql .= " and a.`status` = '" . $data["status"] . "'";
            }
        }
        if (!empty($data["start_time"])) {
            $sql.=" and UNIX_TIMESTAMP(b.`date`) >= UNIX_TIMESTAMP('" . $data["start_time"] . "') ";
        }
        if (!empty($data["end_time"])) {
            $sql.=" and UNIX_TIMESTAMP(b.`date`) <= UNIX_TIMESTAMP('" . $data["end_time"] . "')  ";
        }
        if ($data['show_status'] == 2 || $data['show_status'] == 3) {
            $sql .= " GROUP BY a.`name` ";
        }

        if (!empty($data["byorder"])) {
            $sql.=" order by " . $data["byorder"] . " ";
        } else {
            $sql.=" order by a.`id` ";
        }
        if (!empty($data["bysort"])) {
            $sql.=" " . $data["bysort"] . " ";
        } else {
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
        // echo $sql;exit;
        $res = $this->db->query($sql)->result_array();
        return $res;
    }

    function deal_history_data($history_mes, $startdate, $enddate) {
        $list_info = array();
        if (!empty($history_mes)) {
            foreach ($history_mes as $key => $val) {
                if (empty($history_mes[$key]['cr'])) {
                    $history_mes[$key]['cr'] = 0;
                }
                if (!empty($startdate)) {
                    $history_mes[$key]['start_time'] = $startdate;
                } else {
                    $history_mes[$key]['start_time'] = $history_mes[$key]['date'];
                }

                if (!empty($enddate)) {
                    $history_mes[$key]['end_time'] = $enddate;
                } else {
                    $history_mes[$key]['end_time'] = $history_mes[$key]['date'];
                }
                switch ($history_mes[$key]['type']) {
                    case '1':
                        $history_mes[$key]['type'] = 'Apk Offer';
                        break;
                    case '3':
                        $history_mes[$key]['type'] = 'Affliate Offer';
                        break;
                }
                switch ($history_mes[$key]['status']) {
                    case '-1':
                        $history_mes[$key]['status'] = '下架';
                        break;
                    case '0':
                        $history_mes[$key]['status'] = '上架';
                        break;
                    case '1':
                        $history_mes[$key]['status'] = '页面修改失败';
                        break;
                    case '-2':
                        $history_mes[$key]['status'] = '没有有下载地址';
                        break;
                }
            }
            $list_info = $history_mes;
        }
        return $list_info;
    }

    function all_realtime_data($data, $limit = 0) {
        $this->load->library("Md_redis");
        $today = date('Ymd');
        //$today = '20160907';
        $get_key = 'adsget_' . $today;
        $sinstall_key = 'adsinstall_' . $today;
        $postback_key = 'adspostback_' . $today;
        $key_exists = $this->md_redis->Exists($sinstall_key); //判断key是否存在
        if (!$key_exists) {//不存在
            return false;
        } else { 
            $res = array();
            $sql = "SELECT a.`id` as adid, a.`type`,a.`provider` as provider_id, a.`name` as ad_name, a.`cap`, a.`price`, a.`preweight`, a.`weight`, a.`status` FROM `o_ad` a WHERE 1 ";
            if (!empty($data["ad_id"])) {
                $sql .= " and a.`id` IN (" . $data["ad_id"] . ")";
            }
            if (!empty($data["ad_name"])) {
                $sql .= " and a.`name`='" . $data["ad_name"] . "'";
            }
            if (!empty($data["provider_id"])) {
                $sql .= " and a.`provider` IN (" . $data["provider_id"] . ")";
            }
            if (!empty($data["type"])) {
                $sql .= " and a.`type` = '" . $data["type"] . "'";
            }
            if (!empty($data["status"])) {
                if (3 == $data["status"]) {
                    $sql .= " and a.`status` = '0'";
                } else {
                    $sql .= " and a.`status` = '" . $data["status"] . "'";
                }
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
            // echo $sql;exit;
            $res = $this->db->query($sql)->result_array();
            $realtime = array();
            foreach($res as $key=>$row){
                $realtime[$key] = $res[$key];
                $getNum = $this->md_redis->hGet($get_key,$res[$key]['adid']);//获取adid下发数
                $sinstallNum = $this->md_redis->hGet($sinstall_key,$res[$key]['adid']);//获取adid安装数
                $postNum = $this->md_redis->hGet($postback_key,$res[$key]['adid']);//获取adid回调数
                $realtime[$key]['date'] = $today;
                $realtime[$key]['postnum'] = isset($postNum)?$postNum:0;
                $realtime[$key]['installnum'] =isset($sinstallNum)?$sinstallNum:0;
                $realtime[$key]['sendnum'] =isset($getNum)?$getNum:0;
                $realtime[$key]['cr'] = round(($realtime[$key]['postnum'] / $realtime[$key]['installnum'])*100,2);
            }
            if($data["bysort"] = 'asc'){
                $sort = SORT_DESC;
            }elseif($data["bysort"] = 'desc'){
                $sort = SORT_ASC;
            }
            $return_realtime = $realtime;
            $return_realtime = $this->multi_array_sort($return_realtime,$data["byorder"],$sort);
            return $return_realtime;
        }
    }
    function multi_array_sort($multi_array, $sort_key, $sort = SORT_DESC) {
        if (is_array($multi_array)) {
            foreach ($multi_array as $row_array) {
                if (is_array($row_array)) {
                    $key_array[] = $row_array[$sort_key];
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
        array_multisort($key_array, $sort, $multi_array);
        return $multi_array;
    }

    function deal_realtime_data($realtime_mes) {
        $list_info = array();
        if (!empty($realtime_mes)) {
            foreach ($realtime_mes as $key => $val) {
                if (empty($realtime_mes[$key]['cr'])) {
                    $realtime_mes[$key]['cr'] = 0;
                }
                switch ($realtime_mes[$key]['type']) {
                    case '1':
                        $realtime_mes[$key]['type'] = 'Apk Offer';
                        break;
                    case '3':
                        $realtime_mes[$key]['type'] = 'Affliate Offer';
                        break;
                }
                switch ($realtime_mes[$key]['status']) {
                    case '-1':
                        $realtime_mes[$key]['status'] = '下架';
                        break;
                    case '0':
                        $realtime_mes[$key]['status'] = '上架';
                        break;
                    case '1':
                        $realtime_mes[$key]['status'] = '页面修改失败';
                        break;
                    case '-2':
                        $realtime_mes[$key]['status'] = '没有有下载地址';
                        break;
                }
            }
            $list_info = $realtime_mes;
        }
        return $list_info;
    }

}
