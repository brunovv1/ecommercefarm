<?php
class ControllerExtensionPaymentPaymee extends Controller {
    private $error = array();

    public function index() {
        $data = $this->load->language('extension/payment/paymee');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payment_paymee', $this->request->post);

            $this->update();

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['save_stay']) && ($this->request->post['save_stay'] = 1)) {
                $this->response->redirect($this->url->link('extension/payment/paymee', 'user_token=' . $this->session->data['user_token'], true));
            } else {
                $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
            }
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['user_token'] = $this->session->data['user_token'];

        $erros = array(
            'warning',
            'stores',
            'customer_groups',
            'x_api_key',
            'x_api_token',
            'metodos',
            'razao',
            'cnpj',
            'cpf',
            'titulo'
        );

        foreach ($erros as $erro) {
            if (isset($this->error[$erro])) {
                $data['error_'.$erro] = $this->error[$erro];
            } else {
                $data['error_'.$erro] = '';
            }
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/paymee', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/paymee', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        include_once(DIR_SYSTEM . 'library/paymee/versao.php');

        $lib = DIR_SYSTEM . 'library/paymee/paymee.php';
        if (is_file($lib)) {
            if (!is_readable($lib)) {
                chmod($lib, 0644);
            }
        }

        $this->document->addStyle('view/javascript/jquery/paymee/colorpicker/css/bootstrap-colorpicker.min.css');
        $this->document->addScript('view/javascript/jquery/paymee/colorpicker/js/bootstrap-colorpicker.min.js');

        $campos = array(
            'stores' => array(0),
            'customer_groups' => array(0),
            'total' => '',
            'geo_zone_id' => '',
            'status' => '',
            'sort_order' => '',
            'x_api_key' => '',
            'x_api_token' => '',
            'sandbox' => '',
            'vencimento' => '',
            'metodos' => array(),
            'debug' => '',
            'produto_digital' => '',
            'situacao_pendente_id' => '',
            'situacao_analise_id' => '',
            'situacao_pago_id' => '',
            'custom_razao_id' => '',
            'razao_coluna' => '',
            'custom_cnpj_id' => '',
            'cnpj_coluna' => '',
            'custom_cpf_id' => '',
            'cpf_coluna' => '',
            'titulo' => '',
            'imagem' => '',
            'one_checkout' => '',
            'cor_normal_texto' => '#FFFFFF',
            'cor_normal_fundo' => '#33b0f0',
            'cor_normal_borda' => '#33b0f0',
            'cor_efeito_texto' => '#FFFFFF',
            'cor_efeito_fundo' => '#0487b0',
            'cor_efeito_borda' => '#0487b0'
        );

        foreach ($campos as $campo => $valor) {
            if (isset($this->request->post['payment_paymee_' . $campo])) {
                $data['payment_paymee_' . $campo] = $this->request->post['payment_paymee_' . $campo];
            } else {
                $valor = !is_null($this->config->get('payment_paymee_' . $campo)) ? $this->config->get('payment_paymee_' . $campo) : $valor;
                $data['payment_paymee_' . $campo] = $valor;
            }
        }

        $data['store_default'] = $this->config->get('config_name');
        $this->load->model('setting/store');
        $data['stores'] = $this->model_setting_store->getStores();

        $this->load->model('customer/customer_group');
        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['url_notificacao'] = HTTPS_CATALOG . 'index.php?route=extension/payment/paymee/notificacao';

        $data['vencimentos'] = array(
            '1440' => $this->language->get('text_24_horas'),
            '2880' => $this->language->get('text_48_horas'),
            '4320' => $this->language->get('text_72_horas')
        );

        $data['metodos'] = array(
            'PIX' => $this->language->get('text_pix'),
            'BB_TRANSFER' => $this->language->get('text_bb_transfer'),
            'BRADESCO_TRANSFER' => $this->language->get('text_bradesco_transfer'),
            'ITAU_TRANSFER_GENERIC' => $this->language->get('text_itau_transfer_generic'),
            'CEF_TRANSFER' => $this->language->get('text_cef_transfer'),
            'ORIGINAL_TRANSFER' => $this->language->get('text_original_transfer'),
            'SANTANDER_TRANSFER' => $this->language->get('text_santander_transfer'),
            'INTER_TRANSFER' => $this->language->get('text_inter_transfer'),
            'BS2_TRANSFER' => $this->language->get('text_bs2_transfer'),
            'ITAU_DI' => $this->language->get('text_itau_di'),
            'SANTANDER_DI' => $this->language->get('text_santander_di')
        );

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['custom_fields'] = array();
        $this->load->model('customer/custom_field');
        $custom_fields = $this->model_customer_custom_field->getCustomFields();
        foreach ($custom_fields as $custom_field) {
            $data['custom_fields'][] = array(
                'custom_field_id' => $custom_field['custom_field_id'],
                'name' => $custom_field['name'],
                'type' => $custom_field['type'],
                'location' => $custom_field['location']
            );
        }

        $this->load->model('extension/payment/paymee');
        $data['columns'] = $this->model_extension_payment_paymee->getColumns();

        $this->load->model('tool/image');
        if (isset($this->request->post['payment_paymee_imagem']) && is_file(DIR_IMAGE . $this->request->post['payment_paymee_imagem'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['payment_paymee_imagem'], 100, 100);
        } elseif (is_file(DIR_IMAGE . $this->config->get('payment_paymee_imagem'))) {
            $data['thumb'] = $this->model_tool_image->resize($this->config->get('payment_paymee_imagem'), 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }
        $data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/paymee', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/paymee')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['payment_paymee_stores'])) {
            $this->error['stores'] = $this->language->get('error_stores');
        }

        if (empty($this->request->post['payment_paymee_customer_groups'])) {
            $this->error['customer_groups'] = $this->language->get('error_customer_groups');
        }

        if (empty($this->request->post['payment_paymee_metodos'])) {
            $this->error['metodos'] = $this->language->get('error_metodos');
        }

        $erros = array(
            'x_api_key',
            'x_api_token',
            'titulo'
        );

        foreach ($erros as $erro) {
            if (!(trim($this->request->post['payment_paymee_'.$erro]))) {
                $this->error[$erro] = $this->language->get('error_'.$erro);
            }
        }

        $erros_campos = array(
            'razao',
            'cnpj',
            'cpf'
        );

        foreach ($erros_campos as $erro) {
            if ($this->request->post['payment_paymee_custom_'.$erro.'_id'] == 'N') {
                if (!(trim($this->request->post['payment_paymee_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    public function install() {
        $this->load->model('extension/payment/paymee');
        $this->model_extension_payment_paymee->update();
    }

    public function uninstall() {
        $this->load->model('user/user_group');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/paymee/list');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/paymee/list');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/paymee/log');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/paymee/log');
    }

    public function update() {
        $this->load->model('extension/payment/paymee');
        $this->model_extension_payment_paymee->update();

        if (!$this->user->hasPermission('modify', 'extension/payment/paymee/list')) {
            $this->load->model('user/user_group');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/paymee/list');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/paymee/list');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/paymee/log');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/paymee/log');
        }
    }
}
