<?php
class ControllerCommonHome extends Controller {
	public function index() {
		
		$data['language'] = $this->load->controller('common/language');
		$data['lang'] = $this->config->get('config_language_id');
		$data['admin_homeslide_status'] = $this->config->get('admin_homeslide_status');
		$data['admin_homeslidestatus_status'] = $this->config->get('admin_homeslidestatus_status');
		$data['admin_catwallitem1_status'] = $this->config->get('admin_catwallitem1_status');
		$data['admin_catwallitemtype1_status'] = $this->config->get('admin_catwallitemtype1_status');
		$data['admin_catwallitem1_img'] = $this->config->get('admin_catwallitem1_img');
		$data['admin_catwallitem1_link'] = $this->config->get('admin_catwallitem1_link');
		$data['admin_catwallitem1_text'] = $this->config->get('admin_catwallitem1_text');
		$data['admin_catwallitem2_status'] = $this->config->get('admin_catwallitem2_status');
		$data['admin_catwallitemtype2_status'] = $this->config->get('admin_catwallitemtype2_status');
		$data['admin_catwallitem2_img'] = $this->config->get('admin_catwallitem2_img');
		$data['admin_catwallitem2_link'] = $this->config->get('admin_catwallitem2_link');
		$data['admin_catwallitem2_text'] = $this->config->get('admin_catwallitem2_text');
		$data['admin_catwallitem3_status'] = $this->config->get('admin_catwallitem3_status');
		$data['admin_catwallitemtype3_status'] = $this->config->get('admin_catwallitemtype3_status');
		$data['admin_catwallitem3_img'] = $this->config->get('admin_catwallitem3_img');
		$data['admin_catwallitem3_link'] = $this->config->get('admin_catwallitem3_link');
		$data['admin_catwallitem3_text'] = $this->config->get('admin_catwallitem3_text');
		$data['admin_catwallitem4_status'] = $this->config->get('admin_catwallitem4_status');
		$data['admin_catwallitemtype4_status'] = $this->config->get('admin_catwallitemtype4_status');
		$data['admin_catwallitem4_img'] = $this->config->get('admin_catwallitem4_img');
		$data['admin_catwallitem4_link'] = $this->config->get('admin_catwallitem4_link');
		$data['admin_catwallitem4_text'] = $this->config->get('admin_catwallitem4_text');
		$data['admin_catwallitem5_status'] = $this->config->get('admin_catwallitem5_status');
		$data['admin_catwallitemtype5_status'] = $this->config->get('admin_catwallitemtype5_status');
		$data['admin_catwallitem5_img'] = $this->config->get('admin_catwallitem5_img');
		$data['admin_catwallitem5_link'] = $this->config->get('admin_catwallitem5_link');
		$data['admin_catwallitem5_text'] = $this->config->get('admin_catwallitem5_text');
		$data['admin_catwallitem6_status'] = $this->config->get('admin_catwallitem6_status');
		$data['admin_catwallitemtype6_status'] = $this->config->get('admin_catwallitemtype6_status');
		$data['admin_catwallitem6_img'] = $this->config->get('admin_catwallitem6_img');
		$data['admin_catwallitem6_link'] = $this->config->get('admin_catwallitem6_link');
		$data['admin_catwallitem6_text'] = $this->config->get('admin_catwallitem6_text');
		$data['admin_homeslide_img'] = $this->config->get('admin_homeslide_img');
		$data['admin_homeslide_text_status'] = $this->config->get('admin_homeslide_text_status');
		$data['admin_homeslide_title_link'] = $this->config->get('admin_homeslide_title_link');
		$data['admin_homeslide_title'] = $this->config->get('admin_homeslide_title');
		$data['admin_homeslide_text'] = $this->config->get('admin_homeslide_text');
		$data['admin_underslide_status'] = $this->config->get('admin_underslide_status');
		$data['admin_underslideleft1_img'] = $this->config->get('admin_underslideleft1_img');
		$data['admin_underslideleft1_text'] = $this->config->get('admin_underslideleft1_text');
		$data['admin_underslideleft2_img'] = $this->config->get('admin_underslideleft2_img');
		$data['admin_underslideleft2_text'] = $this->config->get('admin_underslideleft2_text');
		$data['admin_underslide_img'] = $this->config->get('admin_underslide_img');
		$data['admin_underslideright1_img'] = $this->config->get('admin_underslideright1_img');
		$data['admin_underslideright1_text'] = $this->config->get('admin_underslideright1_text');
		$data['admin_underslideright2_img'] = $this->config->get('admin_underslideright2_img');
		$data['admin_underslideright2_text'] = $this->config->get('admin_underslideright2_text');
		$data['admin_map_status'] = $this->config->get('admin_map_status');
		$data['admin_map_img'] = $this->config->get('admin_map_img');
		$data['admin_map_text1'] = $this->config->get('admin_map_text1');
		$data['admin_map_text2'] = $this->config->get('admin_map_text2');
		$data['admin_map_text3'] = $this->config->get('admin_map_text3');
		$data['admin_map_text4'] = $this->config->get('admin_map_text4');
		$data['admin_map_text5'] = $this->config->get('admin_map_text5');
			
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
