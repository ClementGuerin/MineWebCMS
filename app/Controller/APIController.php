<?php 

class APIController extends AppController {

	public $components = array('Session', 'API');

	public function mineguard() {
		$this->autoRender = false;
		$username = $_GET['user'];
		$ip = $_GET['ip'];
		echo json_encode($this->API->verifIp($username, $ip));
	}

	public function launcher($username, $password, $args = null) {
		$this->autoRender = false;
		$args = explode(',', $args);
		echo json_encode($this->API->get($username, $password, $args));
	}

	public function delete_ip() {
		$this->autoRender = false;
        if($this->Connect->connect()) {
    		if($this->request->is('post')) {
    			if(isset($this->request->data['ip'])) {
    				if($this->API->removeIp($this->Connect->get_pseudo(), $this->request->data['ip'])) {
    					echo 'true';
    				} else {
    					echo $this->Lang->get('INTERNAL_ERROR').'|false';
    				}
    			} else {
    				echo $this->Lang->get('COMPLETE_ALL_FIELDS').'|false';
    			}
    		} else {
    			echo $this->Lang->get('NOT_POST').'|false';
    		}
    	} else {
    		echo $this->Lang->get('NEED_CONNECT').'|false';
    	}
	}

	public function add_ip() {
		$this->autoRender = false;
        if($this->Connect->connect()) {
    		if($this->request->is('post')) {
    			if(!empty($this->request->data['ip'])) {
    				if(filter_var($this->request->data['ip'], FILTER_VALIDATE_IP)) {
	    				if($this->API->setIp($this->Connect->get_pseudo(), $this->request->data['ip'])) {
	    					echo $this->Lang->get('SUCCESS_ADD_IP').'|true';
	    				} else {
	    					echo $this->Lang->get('INTERNAL_ERROR').'|false';
	    				}
	    			} else {
	    				echo $this->Lang->get('INVALID_IP').'|false';
	    			}
    			} else {
    				echo $this->Lang->get('COMPLETE_ALL_FIELDS').'|false';
    			}
    		} else {
    			echo $this->Lang->get('NOT_POST').'|false';
    		}
    	} else {
    		echo $this->Lang->get('NEED_CONNECT').'|false';
    	}
	}

	public function disable_mineguard() {
		$this->autoRender = false;
        if($this->Connect->connect()) {
    		if($this->request->is('post')) {
    			
    			$this->Connect->set('allowed_ip', '0');

    			echo $this->Lang->get('SUCCESS_DISABLE_MINEGUARD').'|true';

    		} else {
    			echo $this->Lang->get('NOT_POST').'|false';
    		}
    	} else {
    		echo $this->Lang->get('NEED_CONNECT').'|false';
    	}
	}

	public function enable_mineguard() {
		$this->autoRender = false;
        if($this->Connect->connect()) {
    		if($this->request->is('post')) {
    			
    			$this->Connect->set('allowed_ip', serialize(array()));

    			echo $this->Lang->get('SUCCESS_ENABLE_MINEGUARD').'|true';

    		} else {
    			echo $this->Lang->get('NOT_POST').'|false';
    		}
    	} else {
    		echo $this->Lang->get('NEED_CONNECT').'|false';
    	}
	}

	public function admin_index() {
		if($this->Connect->connect() AND $this->Connect->if_admin()) {
			$this->set('title_for_layout',$this->Lang->get('API'));
			$this->layout = 'admin';

			if($this->request->is('post')) {
				if(isset($this->request->data['skins']) AND isset($this->request->data['skin_free']) AND !empty($this->request->data['skin_filename']) AND isset($this->request->data['capes']) AND isset($this->request->data['cape_free']) AND !empty($this->request->data['cape_filename'])) {
					foreach ($this->request->data as $key => $value) {
						$this->API->set($key, $value);
					}
					$this->History->set('EDIT_CONFIGURATION', 'api');
					$this->Session->setFlash($this->Lang->get('EDIT_CONFIGURATION_SUCCESS'), 'default.success');
				} else {
					$this->Session->setFlash($this->Lang->get('COMPLETE_ALL_FIELDS'), 'default.error');
				}
			}

			$this->loadModel('ApiConfiguration');
			$config = $this->ApiConfiguration->find('first');
			$this->set('config', $config['ApiConfiguration']);
		} else {
			$this->redirect('/');
		}
	}

	public function get_skin($name) {
		$this->response->type('png');
		$this->autoRender = false;
		$this->loadModel('ApiConfiguration');
		$config = $this->ApiConfiguration->find('first');
		$config = $config['ApiConfiguration'];
		if($config['skins']) {
			$target = substr($config['skin_filename'], 0, (strrpos($config['skin_filename'], '/') + 1));
			$where = WWW_ROOT.$target;
		} else {
			$where = 'https://skins.minecraft.net/MinecraftSkins/';
		}

		echo $this->API->get_skin($name, $where);
	}

	public function get_head_skin($name, $size = 50) {
		$this->response->type('png');
		$this->autoRender = false;
		$this->loadModel('ApiConfiguration');
		$config = $this->ApiConfiguration->find('first');
		$config = $config['ApiConfiguration'];
		if($config['skins']) {
			$target = substr($config['skin_filename'], 0, (strrpos($config['skin_filename'], '/') + 1));
			$where = WWW_ROOT.$target;
		} else {
			$where = 'https://skins.minecraft.net/MinecraftSkins/';
		}
		echo $this->API->get_head_skin($name, $size, $where);
	}

}