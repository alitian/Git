<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

// ------------------------------------------------------------------------

/**
 * Base URL
 * 
 * Create a local URL based on your basepath.
 * Segments can be passed in as a string or an array, same as site_url
 * or a URL to a file can be passed in, e.g. to an image file.
 *
 * @access	public
 * @param string
 * @return	string
 */
if ( ! function_exists('base_url'))
{
	function base_url($uri = '')
	{
		$CI =& get_instance();
		return $CI->config->base_url($uri);
	}
}

/**
 * Static URL
 * 
 * Create a local URL based on your basepath.
 * Segments can be passed in as a string or an array, same as site_url
 * or a URL to a file can be passed in, e.g. to an image file.
 *
 * @access	public
 * @param string
 * @return	string
 */
if ( ! function_exists('static_url'))
{
	function static_url($uri = '')
	{
		$CI =& get_instance();
		return $CI->config->static_url($uri);
	}
}
// ------------------------------------------------------------------------
/**
 * Header Redirect
 *
 * Header redirect in two flavors
 * For very fine grained control over headers, you could use the Output
 * Library's set_header() function.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the method: location or redirect
 * @return	string
 */
if ( ! function_exists('redirect'))
{
	function redirect($uri = '', $method = 'location', $http_response_code = 302)
	{
		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = site_url($uri);
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
				break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
				break;
		}
		exit;
	}
}

/**
 * get config item by key
 *
 * @param unknown_type $key
 * @return unknown
 */
if (!function_exists('_gc')) {

    function _gc($key = '', $cfg = '') {
        $CI = get_instance();
        if ($cfg != '') {
            $CI->load->config($cfg, true);
            return $CI->config->item($key, $cfg);
        } else {
            return $CI->config->item($key);
        }
    }

}
// ------------------------------------------------------------------------

/**
 * 生成短连接
 *
 * @access	private
 * @param	array
 * @param	bool
 * @return	string
 * @example 
 * short_url('http://www.modian.com/');
 * Array ( [url_short] => http://t.cn/aOnqoj [url_long] => http://www.modian.com/ [type] => 0 ) 
 */
if ( ! function_exists('short_url'))
{
    function short_url($url) {
        $url = 'http://api.t.sina.com.cn/short_url/shorten.json?source=' . 3249442221 . '&url_long=' . $url;
        //设置附加HTTP头
        $addHead = array(
            "Content-type: application/json"
        );
        //初始化curl，当然，你也可以用fsockopen代替
        $curl_obj = curl_init();
        //设置网址
        curl_setopt($curl_obj, CURLOPT_URL, $url);
        //附加Head内容
        curl_setopt($curl_obj, CURLOPT_HTTPHEADER, $addHead);
        //是否输出返回头信息
        curl_setopt($curl_obj, CURLOPT_HEADER, 0);
        //将curl_exec的结果返回
        curl_setopt($curl_obj, CURLOPT_RETURNTRANSFER, 1);
        //设置超时时间
        curl_setopt($curl_obj, CURLOPT_TIMEOUT, 15);
        //执行
        $result = curl_exec($curl_obj);
        //关闭curl回话
        curl_close($curl_obj);
        $result = json_decode($result, true);
        return $result[0];
    }

}
/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */