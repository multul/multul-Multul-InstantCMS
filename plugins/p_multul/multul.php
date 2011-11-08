<?php

/* 
 * Created by TIgor
 * e-mail: tigorr@gmail.com
 * site: multul.ru
 */

class Multul {

	private $config = array();

	private $js_src;

	public function __construct(array $config = NULL) {
		$this->config = array(
			'secret_key'	=> '',
			'timestamp'		=> time(),
			'random'		=> rand(10, 1000),
			'v'				=> 1,
		);
//		$this->js_src = 'http://cdn.multul.ru/v' . $this->config['v'] . '/js/im.js';
		$this->js_src = 'http://cdn.multul.lh/v' . $this->config['v'] . '/js/im.js';
		$this->config = array_merge($this->config, $config);
	}

	public static function factory(array $config = NULL) {
		return new Multul($config);
	}

	public function render() {
		$return = '<script type="text/javascript" src="' . $this->js_src . '"></script>'
			. '<script type="text/javascript">multul.im.load("' . $this->get_uri($this->config) . '");</script>';
		return $return;
	}

	private function get_uri(array $config = array()) {
		ksort($config);
		$params = array();

		foreach($config as $key => $value) {
			if ($key == 'secret_key'){
				continue;
			}
			$params[$key] = urlencode($value);
		}
		return http_build_query($params) . '&sig=' . $this->get_sig($params, $config['secret_key']);
	}

	public function get_sig($params, $secret_key) {
		ksort($params);
		$app_params_str = '';
		foreach($params as $key => $value) {
			if($key != 'sig') {
				$app_params_str .= sprintf('%s=%s', $key, $value);
			}
		}
		return md5($app_params_str . $secret_key);
	}
}
?>