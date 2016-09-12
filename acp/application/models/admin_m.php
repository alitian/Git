<?php

class Admin_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_multiple_count($tablename, $where = array()) {
        $this->db->where($where);
        $qry = $this->db->get($tablename);
        return $qry->num_rows();
    }

    function get_multiple($tablename, $where = array(), $start = '', $count = '', $ordering = '') {
        $this->db->where($where);

        if ($ordering != '') {
            $this->db->order_by($ordering);
        }
        if ($count !== '') {
            if ($start !== '') {
                $this->db->limit($count, $start);
            } else {
                $this->db->limit($count);
            }
        }
        $qry = $this->db->get($tablename);
        $user_list = $qry->result_array();
        if(!empty($user_list)){
            foreach($user_list as $key=>$row){
                if(1 == $user_list[$key]['user_type']){
                    $user_list[$key]['type_text'] = 'Admin管理员';
                }else{
                    $user_list[$key]['type_text'] = '普通管理员';
                }
            }
        }else{
            $user_list = array();
        }
        return $user_list;
    }
    
    function get_admin_group(){
        $this->db->where('if_show', '1');
        $this->db->from('md_admin_group');
        $query = $this->db->get();
        $res = $query->result_array();
        return $res;
    }
    
    function save($tablename, $data) {
        # Populate creation data
        $data['ctime'] = date('Y-m-d H:i:s');

        $data['if_show'] = 1;

        $this->db->insert($tablename, $data);

        return $this->db->insert_id();
    }
    
    function delete($tablename, $id)
    {
        return $this->db->delete($tablename, array('id' => $id));
    }
    
    function update($tablename, $id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update($tablename, $data);
    }
    
    function get_single_record($tablename, $where = array()) {
        $this->db->where($where);
        $query = $this->db->get($tablename);

        if ($query->num_rows() == 0) {
            $result = array();
            return $result;
        } else {
            $result = $query->row_array();
            return $result;
        }
    }

}

?>
