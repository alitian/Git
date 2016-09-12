<?php
require_once BASEPATH . 'libraries/memcache.php';

class Common extends CI_Model {


    function __construct() {
        $this->load->database();

    }

    function add($table, $data) {
        $res = $this->db->insert($table, $data);
        $res = $this->db->insert_id();
        return $res;
    }

    function update($table, $where, $data) {
        $this->db->where($where);
        $res = $this->db->update($table, $data);
        return $res;
    }

    function delete($table, $where) {
        if (!empty($where)) {
            #$this->db->where( $where );
            $res = $this->db->delete($table, $where);
            return $res;
        } else
            return false;
    }

    function get_real_ip() {
        $ip = false;
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi("^(10|172\.16|192\.168)\.", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

}

?>
