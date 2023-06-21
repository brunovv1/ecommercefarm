<?php
class ControllerExtensionModuleAdmin extends Controller {
    private $error = array();  
    public function index() {   
	
		$language = $this->load->language('extension/module/admin');
        $data = array_merge($language);

        $this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('view/colorpicker/css/colorpicker.css');
  		$this->document->addScript('view/colorpicker/js/colorpicker.js');
		$this->document->addStyle('view/stylesheet/codemirror/lib/codemirror.css?');
        $this->document->addStyle('view/stylesheet/codemirror/mode/theme/monokai.css?');
        $this->document->addScript('view/javascript/codemirror/lib/codemirror.js');
        $this->document->addScript('view/javascript/codemirror/mode/css/css.js');
        $this->document->addScript('view/javascript/codemirror/mode/javascript/javascript.js');
        
        $this->load->model('setting/setting');
        
        $this->load->model('tool/image');  
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('admin', $this->request->post);    

            $this->session->data['success'] = $this->language->get('text_success');
        
            if(isset($this->request->post['save_stay']) and $this->request->post['save_stay']=1)
			$this->response->redirect($this->url->link('extension/module/admin', 'user_token=' . $this->session->data['user_token'], true));
			else
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }
		
            $data['text_image_manager'] = 'Image manager';
            $data['user_token'] = $this->session->data['user_token'];       
       
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

        $config_data = array(
        'admin_homeslide_status',
		'admin_homeslidestatus_status',	
		'admin_catwallitem1_status',	
		'admin_catwallitem2_status',
		'admin_catwallitem3_status',
		'admin_catwallitem4_status',
		'admin_catwallitem5_status',
		'admin_catwallitem6_status',
		'admin_homeslide_text_status',
		'admin_underslide_status',
		'admin_map_status',
		'admin_footerlink1_status',
		'admin_footerlink2_status',
		'admin_footerlink3_status',
		'admin_footerlink4_status',
		'admin_footerlink5_status',
		'admin_footerpay1_status',
		'admin_footerpay2_status',
		'admin_footerpay3_status',
		'admin_footerpay4_status',
		'admin_footerpay5_status',
		'admin_footertext_status',
		'admin_catwallitemtype1_status',
		'admin_catwallitemtype2_status',
		'admin_catwallitemtype3_status',
		'admin_catwallitemtype4_status',
		'admin_catwallitemtype5_status',
		'admin_catwallitemtype6_status',			
		'admin_color_main',
		'admin_second_color',
		'admin_text_color',
		'admin_texthover_color',
		'admin_name_color',
		'admin_namehover_color',
		'admin_font',
		'admin_custom_css',
		'admin_catwallitem1_img',
		'admin_catwallitem1_text',
		'admin_catwallitem1_link',		
		'admin_catwallitem2_img',
		'admin_catwallitem2_text',
		'admin_catwallitem2_link',	
		'admin_catwallitem3_img',
		'admin_catwallitem3_text',
		'admin_catwallitem3_link',	
		'admin_catwallitem4_img',
		'admin_catwallitem4_link',	
		'admin_catwallitem4_text',
		'admin_catwallitem5_img',
		'admin_catwallitem5_text',
		'admin_catwallitem5_link',	
		'admin_catwallitem6_img',
		'admin_catwallitem6_text',
		'admin_catwallitem6_link',			
		'admin_homeslide_img', 
		'admin_homeslide_title_link',
		'admin_homeslide_title',
		'admin_homeslide_text', 
		'admin_underslideleft1_img',
		'admin_underslideleft1_text',
		'admin_underslideleft2_img',
		'admin_underslideleft2_text', 
		'admin_underslide_img',
		'admin_underslideright1_img',
		'admin_underslideright1_text',
		'admin_underslideright2_img',
		'admin_underslideright2_text', 
		'admin_map_img',
		'admin_map_text1',
		'admin_map_text2',
		'admin_map_text3',
		'admin_map_text4',
		'admin_map_text5',
		'admin_footerlink1_img',
		'admin_footerlink2_img',
		'admin_footerlink3_img',
		'admin_footerlink4_img',
		'admin_footerlink5_img',
		'admin_footerlink1_text',
		'admin_footerlink2_text',
		'admin_footerlink3_text',
		'admin_footerlink4_text',
		'admin_footerlink5_text',
		'admin_footerpay1_img',
		'admin_footerpay2_img',
		'admin_footerpay3_img',
		'admin_footerpay4_img',
		'admin_footerpay5_img',
		'admin_footertext_img',
		);
       foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $data[$conf] = $this->request->post[$conf];
            } else {
                $data[$conf] = $this->config->get($conf);
            }
        }		
		
		if (isset($this->request->post['admin_homeslide_status'])) {
			$data['admin_homeslide_status'] = $this->request->post['admin_homeslide_status'];
		} elseif ($this->config->get('admin_homeslide_status')) {
			$data['admin_homeslide_status'] = $this->config->get('admin_homeslide_status');
		} else {
			$data['admin_homeslide_status'] = 0;
		}
			if (isset($this->request->post['admin_homeslidestatus_status'])) {
			$data['admin_homeslidestatus_status'] = $this->request->post['admin_homeslidestatus_status'];
		} elseif ($this->config->get('admin_homeslidestatus_status')) {
			$data['admin_homeslidestatus_status'] = $this->config->get('admin_homeslidestatus_status');
		} else {
			$data['admin_homeslidestatus_status'] = 0;
		}
				if (isset($this->request->post['admin_catwallitem1_status'])) {
			$data['admin_catwallitem1_status'] = $this->request->post['admin_catwallitem1_status'];
		} elseif ($this->config->get('admin_catwallitem1_status')) {
			$data['admin_catwallitem1_status'] = $this->config->get('admin_catwallitem1_status');
		} else {
			$data['admin_catwallitem1_status'] = 0;
		}
				if (isset($this->request->post['admin_catwallitem2_status'])) {
			$data['admin_catwallitem2_status'] = $this->request->post['admin_catwallitem2_status'];
		} elseif ($this->config->get('admin_catwallitem2_status')) {
			$data['admin_catwallitem2_status'] = $this->config->get('admin_catwallitem2_status');
		} else {
			$data['admin_catwallitem2_status'] = 0;
		}
			if (isset($this->request->post['admin_catwallitem3_status'])) {
			$data['admin_catwallitem3_status'] = $this->request->post['admin_catwallitem3_status'];
		} elseif ($this->config->get('admin_catwallitem3_status')) {
			$data['admin_catwallitem3_status'] = $this->config->get('admin_catwallitem3_status');
		} else {
			$data['admin_catwallitem3_status'] = 0;
		}
			if (isset($this->request->post['admin_catwallitem4_status'])) {
			$data['admin_catwallitem4_status'] = $this->request->post['admin_catwallitem4_status'];
		} elseif ($this->config->get('admin_catwallitem3_status')) {
			$data['admin_catwallitem4_status'] = $this->config->get('admin_catwallitem4_status');
		} else {
			$data['admin_catwallitem4_status'] = 0;
		}
		if (isset($this->request->post['admin_catwallitem5_status'])) {
			$data['admin_catwallitem5_status'] = $this->request->post['admin_catwallitem5_status'];
		} elseif ($this->config->get('admin_catwallitem5_status')) {
			$data['admin_catwallitem5_status'] = $this->config->get('admin_catwallitem5_status');
		} else {
			$data['admin_catwallitem5_status'] = 0;
		}
			if (isset($this->request->post['admin_catwallitem6_status'])) {
			$data['admin_catwallitem6_status'] = $this->request->post['admin_catwallitem6_status'];
		} elseif ($this->config->get('admin_catwallitem6_status')) {
			$data['admin_catwallitem6_status'] = $this->config->get('admin_catwallitem6_status');
		} else {
			$data['admin_catwallitem6_status'] = 0;
		}
				if (isset($this->request->post['admin_homeslide_text_status'])) {
			$data['admin_homeslide_text_status'] = $this->request->post['admin_homeslide_text_status'];
		} elseif ($this->config->get('admin_homeslide_text_status')) {
			$data['admin_homeslide_text_status'] = $this->config->get('admin_homeslide_text_status');
		} else {
			$data['admin_homeslide_text_status'] = 0;
		}
		if (isset($this->request->post['admin_underslide_status'])) {
			$data['admin_underslide_status'] = $this->request->post['admin_underslide_status'];
		} elseif ($this->config->get('admin_underslide_status')) {
			$data['admin_underslide_status'] = $this->config->get('admin_underslide_status');
		} else {
			$data['admin_underslide_status'] = 0;
		}
		if (isset($this->request->post['admin_map_status'])) {
			$data['admin_map_status'] = $this->request->post['admin_map_status'];
		} elseif ($this->config->get('admin_map_status')) {
			$data['admin_map_status'] = $this->config->get('admin_map_status');
		} else {
			$data['admin_map_status'] = 0;
		}
		if (isset($this->request->post['admin_footerlink1_status'])) {
			$data['admin_footerlink1_status'] = $this->request->post['admin_footerlink1_status'];
		} elseif ($this->config->get('admin_footerlink1_status')) {
			$data['admin_footerlink1_status'] = $this->config->get('admin_footerlink1_status');
		} else {
			$data['admin_footerlink1_status'] = 0;
		}
		if (isset($this->request->post['admin_footerlink2_status'])) {
			$data['admin_footerlink2_status'] = $this->request->post['admin_footerlink2_status'];
		} elseif ($this->config->get('admin_footerlink2_status')) {
			$data['admin_footerlink2_status'] = $this->config->get('admin_footerlink2_status');
		} else {
			$data['admin_footerlink2_status'] = 0;
		}
		if (isset($this->request->post['admin_footerlink3_status'])) {
			$data['admin_footerlink3_status'] = $this->request->post['admin_footerlink3_status'];
		} elseif ($this->config->get('admin_footerlink3_status')) {
			$data['admin_footerlink3_status'] = $this->config->get('admin_footerlink3_status');
		} else {
			$data['admin_footerlink3_status'] = 0;
		}
		if (isset($this->request->post['admin_footerlink4_status'])) {
			$data['admin_footerlink4_status'] = $this->request->post['admin_footerlink4_status'];
		} elseif ($this->config->get('admin_footerlink4_status')) {
			$data['admin_footerlink4_status'] = $this->config->get('admin_footerlink4_status');
		} else {
			$data['admin_footerlink4_status'] = 0;
		}
		if (isset($this->request->post['admin_footerlink5_status'])) {
			$data['admin_footerlink5_status'] = $this->request->post['admin_footerlink5_status'];
		} elseif ($this->config->get('admin_footerlink5_status')) {
			$data['admin_footerlink5_status'] = $this->config->get('admin_footerlink5_status');
		} else {
			$data['admin_footerlink5_status'] = 0;
		}
		if (isset($this->request->post['admin_footerpay1_status'])) {
			$data['admin_footerpay1_status'] = $this->request->post['admin_footerpay1_status'];
		} elseif ($this->config->get('admin_footerpay1_status')) {
			$data['admin_footerpay1_status'] = $this->config->get('admin_footerpay1_status');
		} else {
			$data['admin_footerpay1_status'] = 0;
		}
		if (isset($this->request->post['admin_footerpay2_status'])) {
			$data['admin_footerpay2_status'] = $this->request->post['admin_footerpay2_status'];
		} elseif ($this->config->get('admin_footerpay2_status')) {
			$data['admin_footerpay2_status'] = $this->config->get('admin_footerpay2_status');
		} else {
			$data['admin_footerpay2_status'] = 0;
		}
		if (isset($this->request->post['admin_footerpay3_status'])) {
			$data['admin_footerpay3_status'] = $this->request->post['admin_footerpay3_status'];
		} elseif ($this->config->get('admin_footerpay3_status')) {
			$data['admin_footerpay3_status'] = $this->config->get('admin_footerpay3_status');
		} else {
			$data['admin_footerpay3_status'] = 0;
		}
		if (isset($this->request->post['admin_footerpay4_status'])) {
			$data['admin_footerpay4_status'] = $this->request->post['admin_footerpay4_status'];
		} elseif ($this->config->get('admin_footerpay4_status')) {
			$data['admin_footerpay4_status'] = $this->config->get('admin_footerpay4_status');
		} else {
			$data['admin_footerpay4_status'] = 0;
		}
		if (isset($this->request->post['admin_footerpay5_status'])) {
			$data['admin_footerpay5_status'] = $this->request->post['admin_footerpay5_status'];
		} elseif ($this->config->get('admin_footerpay5_status')) {
			$data['admin_footerpay5_status'] = $this->config->get('admin_footerpay5_status');
		} else {
			$data['admin_footerpay5_status'] = 0;
		}
		if (isset($this->request->post['admin_footertext_status'])) {
			$data['admin_footertext_status'] = $this->request->post['admin_footertext_status'];
		} elseif ($this->config->get('admin_footertext_status')) {
			$data['admin_footertext_status'] = $this->config->get('admin_footertext_status');
		} else {
			$data['admin_footertext_status'] = 0;
		}
		if (isset($this->request->post['admin_catwallitemtype1_status'])) {
			$data['admin_catwallitemtype1_status'] = $this->request->post['admin_catwallitemtype1_status'];
		} elseif ($this->config->get('admin_catwallitemtype1_status')) {
			$data['admin_catwallitemtype1_status'] = $this->config->get('admin_catwallitemtype1_status');
		} else {
			$data['admin_catwallitemtype1_status'] = 0;
		}
		if (isset($this->request->post['admin_catwallitemtype2_status'])) {
			$data['admin_catwallitemtype2_status'] = $this->request->post['admin_catwallitemtype2_status'];
		} elseif ($this->config->get('admin_catwallitemtype2_status')) {
			$data['admin_catwallitemtype2_status'] = $this->config->get('admin_catwallitemtype2_status');
		} else {
			$data['admin_catwallitemtype2_status'] = 0;
		}
		if (isset($this->request->post['admin_catwallitemtype3_status'])) {
			$data['admin_catwallitemtype3_status'] = $this->request->post['admin_catwallitemtype3_status'];
		} elseif ($this->config->get('admin_catwallitemtype3_status')) {
			$data['admin_catwallitemtype3_status'] = $this->config->get('admin_catwallitemtype3_status');
		} else {
			$data['admin_catwallitemtype3_status'] = 0;
		}
		if (isset($this->request->post['admin_catwallitemtype4_status'])) {
			$data['admin_catwallitemtype4_status'] = $this->request->post['admin_catwallitemtype4_status'];
		} elseif ($this->config->get('admin_catwallitemtype4_status')) {
			$data['admin_catwallitemtype4_status'] = $this->config->get('admin_catwallitemtype4_status');
		} else {
			$data['admin_catwallitemtype4_status'] = 0;
		}
		if (isset($this->request->post['admin_catwallitemtype5_status'])) {
			$data['admin_catwallitemtype5_status'] = $this->request->post['admin_catwallitemtype5_status'];
		} elseif ($this->config->get('admin_catwallitemtype5_status')) {
			$data['admin_catwallitemtype5_status'] = $this->config->get('admin_catwallitemtype5_status');
		} else {
			$data['admin_catwallitemtype5_status'] = 0;
		}
		if (isset($this->request->post['admin_catwallitemtype6_status'])) {
			$data['admin_catwallitemtype6_status'] = $this->request->post['admin_catwallitemtype6_status'];
		} elseif ($this->config->get('admin_catwallitemtype6_status')) {
			$data['admin_catwallitemtype6_status'] = $this->config->get('admin_catwallitemtype6_status');
		} else {
			$data['admin_catwallitemtype6_status'] = 0;
		}
		if (isset($this->request->post['admin_color_main'])) {
			$data['admin_color_main'] = $this->request->post['admin_color_main'];
		} elseif (!empty($module_info)) {
			$data['admin_color_main'] = $module_info['admin_color_main'];
		} else {
			$data['admin_color_main'] = '';
		}
		if (isset($this->request->post['admin_second_color'])) {
			$data['admin_second_color'] = $this->request->post['admin_second_color'];
		} elseif (!empty($module_info)) {
			$data['admin_second_color'] = $module_info['admin_second_color'];
		} else {
			$data['admin_second_color'] = '';
		}
       if (isset($this->request->post['admin_text_color'])) {
			$data['admin_text_color'] = $this->request->post['admin_text_color'];
		} elseif (!empty($module_info)) {
			$data['admin_text_color'] = $module_info['admin_text_color'];
		} else {
			$data['admin_text_color'] = '';
		}
		if (isset($this->request->post['admin_texthover_color'])) {
			$data['admin_texthover_color'] = $this->request->post['admin_texthover_color'];
		} elseif (!empty($module_info)) {
			$data['admin_texthover_color'] = $module_info['admin_texthover_color'];
		} else {
			$data['admin_texthover_color'] = '';
		}
		 if (isset($this->request->post['admin_name_color'])) {
			$data['admin_name_color'] = $this->request->post['admin_name_color'];
		} elseif (!empty($module_info)) {
			$data['admin_name_color'] = $module_info['admin_name_color'];
		} else {
			$data['admin_name_color'] = '';
		}
		if (isset($this->request->post['admin_namehover_color'])) {
			$data['admin_namehover_color'] = $this->request->post['admin_namehover_color'];
		} elseif (!empty($module_info)) {
			$data['admin_namehover_color'] = $module_info['admin_namehover_color'];
		} else {
			$data['admin_namehover_color'] = '';
		}
	  	if (isset($this->request->post['admin_catwallitem1_img']) && is_file(DIR_IMAGE . $this->request->post['admin_catwallitem1_img'])) {
			$data['admin_catwallitem1_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_catwallitem1_img'], 100, 100);
		} elseif ($this->config->get('admin_catwallitem1_img') && is_file(DIR_IMAGE . $this->config->get('admin_catwallitem1_img'))) {
			$data['admin_catwallitem1_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_catwallitem1_img'), 100, 100);
		} else {
			$data['admin_catwallitem1_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_catwallitem2_img']) && is_file(DIR_IMAGE . $this->request->post['admin_catwallitem2_img'])) {
			$data['admin_catwallitem2_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_catwallitem2_img'], 100, 100);
		} elseif ($this->config->get('admin_catwallitem2_img') && is_file(DIR_IMAGE . $this->config->get('admin_catwallitem2_img'))) {
			$data['admin_catwallitem2_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_catwallitem2_img'), 100, 100);
		} else {
			$data['admin_catwallitem2_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_catwallitem3_img']) && is_file(DIR_IMAGE . $this->request->post['admin_catwallitem3_img'])) {
			$data['admin_catwallitem3_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_catwallitem3_img'], 100, 100);
		} elseif ($this->config->get('admin_catwallitem3_img') && is_file(DIR_IMAGE . $this->config->get('admin_catwallitem3_img'))) {
			$data['admin_catwallitem3_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_catwallitem3_img'), 100, 100);
		} else {
			$data['admin_catwallitem3_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_catwallitem4_img']) && is_file(DIR_IMAGE . $this->request->post['admin_catwallitem4_img'])) {
			$data['admin_catwallitem4_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_catwallitem4_img'], 100, 100);
		} elseif ($this->config->get('admin_catwallitem4_img') && is_file(DIR_IMAGE . $this->config->get('admin_catwallitem4_img'))) {
			$data['admin_catwallitem4_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_catwallitem4_img'), 100, 100);
		} else {
			$data['admin_catwallitem4_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_catwallitem5_img']) && is_file(DIR_IMAGE . $this->request->post['admin_catwallitem5_img'])) {
			$data['admin_catwallitem5_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_catwallitem5_img'], 100, 100);
		} elseif ($this->config->get('admin_catwallitem5_img') && is_file(DIR_IMAGE . $this->config->get('admin_catwallitem5_img'))) {
			$data['admin_catwallitem5_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_catwallitem5_img'), 100, 100);
		} else {
			$data['admin_catwallitem5_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_catwallitem6_img']) && is_file(DIR_IMAGE . $this->request->post['admin_catwallitem6_img'])) {
			$data['admin_catwallitem6_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_catwallitem6_img'], 100, 100);
		} elseif ($this->config->get('admin_catwallitem6_img') && is_file(DIR_IMAGE . $this->config->get('admin_catwallitem6_img'))) {
			$data['admin_catwallitem6_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_catwallitem6_img'), 100, 100);
		} else {
			$data['admin_catwallitem6_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_homeslide_img']) && is_file(DIR_IMAGE . $this->request->post['admin_homeslide_img'])) {
			$data['admin_homeslide_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_homeslide_img'], 100, 100);
		} elseif ($this->config->get('admin_homeslide_img') && is_file(DIR_IMAGE . $this->config->get('admin_homeslide_img'))) {
			$data['admin_homeslide_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_homeslide_img'), 100, 100);
		} else {
			$data['admin_homeslide_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_underslideleft1_img']) && is_file(DIR_IMAGE . $this->request->post['admin_underslideleft1_img'])) {
			$data['admin_underslideleft1_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_underslideleft1_img'], 100, 100);
		} elseif ($this->config->get('admin_underslideleft1_img') && is_file(DIR_IMAGE . $this->config->get('admin_underslideleft1_img'))) {
			$data['admin_underslideleft1_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_underslideleft1_img'), 100, 100);
		} else {
			$data['admin_underslideleft1_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_underslideleft2_img']) && is_file(DIR_IMAGE . $this->request->post['admin_underslideleft2_img'])) {
			$data['admin_underslideleft2_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_underslideleft2_img'], 100, 100);
		} elseif ($this->config->get('admin_underslideleft2_img') && is_file(DIR_IMAGE . $this->config->get('admin_underslideleft2_img'))) {
			$data['admin_underslideleft2_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_underslideleft2_img'), 100, 100);
		} else {
			$data['admin_underslideleft2_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_underslide_img']) && is_file(DIR_IMAGE . $this->request->post['admin_underslide_img'])) {
			$data['admin_underslide_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_underslide_img'], 100, 100);
		} elseif ($this->config->get('admin_underslide_img') && is_file(DIR_IMAGE . $this->config->get('admin_underslide_img'))) {
			$data['admin_underslide_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_underslide_img'), 100, 100);
		} else {
			$data['admin_underslide_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_underslideright1_img']) && is_file(DIR_IMAGE . $this->request->post['admin_underslideright1_img'])) {
			$data['admin_underslideright1_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_underslideright1_img'], 100, 100);
		} elseif ($this->config->get('admin_underslideright1_img') && is_file(DIR_IMAGE . $this->config->get('admin_underslideright1_img'))) {
			$data['admin_underslideright1_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_underslideright1_img'), 100, 100);
		} else {
			$data['admin_underslideright1_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_underslideright2_img']) && is_file(DIR_IMAGE . $this->request->post['admin_underslideright2_img'])) {
			$data['admin_underslideright2_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_underslideright2_img'], 100, 100);
		} elseif ($this->config->get('admin_underslideright2_img') && is_file(DIR_IMAGE . $this->config->get('admin_underslideright2_img'))) {
			$data['admin_underslideright2_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_underslideright2_img'), 100, 100);
		} else {
			$data['admin_underslideright2_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_map_img']) && is_file(DIR_IMAGE . $this->request->post['admin_map_img'])) {
			$data['admin_map_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_map_img'], 100, 100);
		} elseif ($this->config->get('admin_map_img') && is_file(DIR_IMAGE . $this->config->get('admin_map_img'))) {
			$data['admin_map_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_map_img'), 100, 100);
		} else {
			$data['admin_map_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_footerlink1_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerlink1_img'])) {
			$data['admin_footerlink1_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerlink1_img'], 100, 100);
		} elseif ($this->config->get('admin_footerlink1_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerlink1_img'))) {
			$data['admin_footerlink1_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerlink1_img'), 100, 100);
		} else {
			$data['admin_footerlink1_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_footerlink2_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerlink2_img'])) {
			$data['admin_footerlink2_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerlink2_img'], 100, 100);
		} elseif ($this->config->get('admin_footerlink2_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerlink2_img'))) {
			$data['admin_footerlink2_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerlink2_img'), 100, 100);
		} else {
			$data['admin_footerlink2_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_footerlink3_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerlink3_img'])) {
			$data['admin_footerlink3_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerlink3_img'], 100, 100);
		} elseif ($this->config->get('admin_footerlink3_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerlink3_img'))) {
			$data['admin_footerlink3_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerlink3_img'), 100, 100);
		} else {
			$data['admin_footerlink3_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_footerlink4_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerlink4_img'])) {
			$data['admin_footerlink4_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerlink4_img'], 100, 100);
		} elseif ($this->config->get('admin_footerlink4_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerlink4_img'))) {
			$data['admin_footerlink4_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerlink4_img'), 100, 100);
		} else {
			$data['admin_footerlink4_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_footerlink5_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerlink5_img'])) {
			$data['admin_footerlink5_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerlink5_img'], 100, 100);
		} elseif ($this->config->get('admin_footerlink5_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerlink5_img'))) {
			$data['admin_footerlink5_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerlink5_img'), 100, 100);
		} else {
			$data['admin_footerlink5_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
			if (isset($this->request->post['admin_footerpay1_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerpay1_img'])) {
			$data['admin_footerpay1_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerpay1_img'], 100, 100);
		} elseif ($this->config->get('admin_footerpay1_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerpay1_img'))) {
			$data['admin_footerpay1_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerpay1_img'), 100, 100);
		} else {
			$data['admin_footerpay1_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_footerpay2_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerpay2_img'])) {
			$data['admin_footerpay2_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerpay2_img'], 100, 100);
		} elseif ($this->config->get('admin_footerpay2_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerpay2_img'))) {
			$data['admin_footerpay2_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerpay2_img'), 100, 100);
		} else {
			$data['admin_footerpay2_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_footerpay3_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerpay3_img'])) {
			$data['admin_footerpay3_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerpay3_img'], 100, 100);
		} elseif ($this->config->get('admin_footerpay3_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerpay3_img'))) {
			$data['admin_footerpay3_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerpay3_img'), 100, 100);
		} else {
			$data['admin_footerpay3_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_footerpay4_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerpay4_img'])) {
			$data['admin_footerpay4_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerpay4_img'], 100, 100);
		} elseif ($this->config->get('admin_footerpay4_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerpay4_img'))) {
			$data['admin_footerpay4_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerpay4_img'), 100, 100);
		} else {
			$data['admin_footerpay4_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}
		if (isset($this->request->post['admin_footerpay5_img']) && is_file(DIR_IMAGE . $this->request->post['admin_footerpay5_img'])) {
			$data['admin_footerpay5_img_preview'] = $this->model_tool_image->resize($this->request->post['admin_footerpay5_img'], 100, 100);
		} elseif ($this->config->get('admin_footerpay5_img') && is_file(DIR_IMAGE . $this->config->get('admin_footerpay5_img'))) {
			$data['admin_footerpay5_img_preview'] = $this->model_tool_image->resize($this->config->get('admin_footerpay5_img'), 100, 100);
		} else {
			$data['admin_footerpay5_img_preview'] = $this->model_tool_image->resize('no_image.png', 100, 100);;
		}  
	  
        foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $data[$conf] = $this->request->post[$conf];
            } else {
                $data[$conf] = $this->config->get($conf);
            }
        }
    
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        $data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);
        
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('extension/module/admin', 'user_token=' . $this->session->data['user_token'], true)
        );
		
		$data['action'] = $this->url->link('extension/module/admin', 'user_token=' . $this->session->data['user_token'], true);
		
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
    
        if (isset($this->request->post['admin_module'])) {
            $modules = explode(',', $this->request->post['admin_module']);
        } elseif ($this->config->get('admin_module') != '') {
            $modules = explode(',', $this->config->get('admin_module'));
        } else {
            $modules = array();
        }           
                
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();

        $data['modules'] = $modules;
        
        if (isset($this->request->post['admin_module'])) {
            $data['admin_module'] = $this->request->post['admin_module'];
        } else {
            $data['admin_module'] = $this->config->get('admin_module');

		}
		
		$data['admin_modules'] = array();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/admin', $data));

    }
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/admin')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	public function uninstall() {
      $this->load->model('setting/setting');
      $this->model_setting_setting->deleteSetting('admin');

}
}