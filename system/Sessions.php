<?php
class Sessions {
	public function is_logged_in() {
		return !empty($_SESSION['user']);
	}
	public function set_user_session($user_info) {
		$_SESSION['user'] = $user_info;
	}
	public function get_logged_in() {
		return !empty($_SESSION['user']) ? $_SESSION['user'] : null;
	}
	public function user_type() {
		return !empty($_SESSION['user_type']) ? $_SESSION['user_type'] : null;
	}
	public function set_user_type($user_type) {
		$_SESSION['user_type'] =  $user_type;
	}
	public function logout() {
		session_unset();
	}
	public function set_msg($mesg, $validity=1) {
		$_SESSION['msg'] = $mesg;
		$_SESSION['msg_validity'] = ++$validity;
	}
	public function get_msg() {
		if (!empty($_SESSION['msg']) && $_SESSION['msg_validity']) {
			return $_SESSION['msg'];
		}
		else {
			if (empty($_SESSION['msg_validity'])) {
				unset($_SESSION['msg']);
				unset($_SESSION['msg_validity']);
			}
			return false;
		}
	}
	public function get_msg_validity() {
		return !empty($_SESSION['msg_validity']) ? $_SESSION['msg_validity'] : '';
	}
	public function reduce_msg_validity() {
		if (!empty($_SESSION['msg_validity'])) $_SESSION['msg_validity']--;
	}
	public function keep_data($key, $msg) {
		$_SESSION[$key] = $msg;
	}
	public function fetch_data($key) {
		return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
	}
	public function clear_keep($key) {
		unset($_SESSION[$key]);
	}

}
?>