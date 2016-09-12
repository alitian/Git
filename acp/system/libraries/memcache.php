<?php
class memcache {

    private static $_mem;

    public static function instance() {
        if (isset($_SERVER['HTTP_APPNAME'])) {
            self::$_mem = memcache_init();
        } else {
			$ci = &get_instance();
			$config = $ci->config->item('md_memcache');
            self::$_mem = new Memcache;
            self::$_mem->connect($config['ip'], $config['port']);
        }
        return self::$_mem;
    }

    public static function set($key, $value, $exp = 10) {
        if (!isset(self::$_mem)) {
            self::instance();
        }
        return self::$_mem->set($key, $value, MEMCACHE_COMPRESSED, $exp);
    }

    public static function get($key) {
        if (!isset(self::$_mem)) {
            self::instance();
        }
        return self::$_mem->get($key);
    }

    public static function delete($key) {
        if (!isset(self::$_mem)) {
            self::instance();
        }
        return self::$_mem->delete($key, 0);
    }

    public static function flush()
    {
        if (!isset(self::$_mem)) {
            self::instance();
        }
        return memcache_flush(self::$_mem);
    }
}
