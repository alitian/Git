<?php
require_once BASEPATH . 'libraries/memcache.php';

class mo_common {

    /**
     * 缁熶竴澶勭悊缂撳瓨鏇存柊
     * @param type $table
     * @param type $data
     * @return boolean
     */
    public static function refresh_memcache($table, $data) {
        memcache::delete(md5("welcome/index"));
        return true;
    }

}
