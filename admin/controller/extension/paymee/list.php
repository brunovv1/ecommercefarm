<?php
class ControllerExtensionPaymeeList extends Controller {
    private $error = array();

    public function index() {
        $data = $this->load->language('extension/paymee/list');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->document->addStyle('//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css');
        $this->document->addStyle('view/javascript/bootstrap/css/bootstrap-glyphicons.css');
        $this->document->addScript('//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js');
        $this->document->addScript('//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/paymee/list', 'user_token=' . $this->session->data['user_token'], true)
        );

        $this->load->model('extension/payment/paymee');
        $transactions = $this->model_extension_payment_paymee->getTransactions();

        $data['transactions'] = array();

        foreach ($transactions as $transaction) {
            switch ($transaction['chosen']) {
                case 'BB_TRANSFER':
                    $metodo = $this->language->get('text_banco_brasil');
                    break;
                case 'BRADESCO_TRANSFER':
                    $metodo = $this->language->get('text_bradesco');
                    break;
                case 'ITAU_TRANSFER_GENERIC':
                    $metodo = $this->language->get('text_itau');
                    break;
                case 'CEF_TRANSFER':
                    $metodo = $this->language->get('text_caixa');
                    break;
                case 'ORIGINAL_TRANSFER':
                    $metodo = $this->language->get('text_original');
                    break;
                case 'SANTANDER_TRANSFER':
                    $metodo = $this->language->get('text_santander');
                    break;
                case 'INTER_TRANSFER':
                    $metodo = $this->language->get('text_inter');
                    break;
                case 'ITAU_DI':
                    $metodo = $this->language->get('text_itau_di');
                    break;
                case 'SANTANDER_DI':
                    $metodo = $this->language->get('text_santander_di');
                    break;
                case 'PIX':
                    $metodo = $this->language->get('text_pix');
                    break;
            }

            switch ($transaction['status']) {
                case 'PENDING':
                    $status = $this->language->get('text_pendente');
                    break;
                case 'PAID':
                    $status = $this->language->get('text_paga');
                    break;
                case 'CANCELLED':
                    $status = $this->language->get('text_cancelada');
                    break;
                case 'REFUNDED':
                    $status = $this->language->get('text_reembolsada');
                    break;
            }

            $action = array();

            $action[] = array(
                'name' => 'button-consultar',
                'title' => $this->language->get('button_consultar'),
                'icon' => 'fa fa-refresh',
                'class' => 'btn btn-info',
                'id' => $transaction['order_paymee_id']
            );

            if ($transaction['status'] == 'PENDING') {
                $action[] = array(
                    'name' => 'button-cancelar',
                    'title' => $this->language->get('button_cancelar'),
                    'icon' => 'fa fa-times',
                    'class' => 'btn btn-warning',
                    'id' => $transaction['order_paymee_id']
                );
            }

            if ($transaction['status'] == 'PAID') {
                $action[] = array(
                    'name' => 'button-reembolsar',
                    'title' => $this->language->get('button_reembolsar'),
                    'icon' => 'fa fa-share',
                    'class' => 'btn btn-success',
                    'id' => $transaction['order_paymee_id']
                );
            }

            $action[] = array(
                'name' => 'button-excluir',
                'title' => $this->language->get('button_excluir'),
                'icon' => 'fa fa-trash-o',
                'class' => 'btn btn-danger',
                'id' => $transaction['order_paymee_id']
            );

            $data['transactions'][] = array(
                'order_id' => $transaction['order_id'],
                'date_added' => date('d/m/Y H:i:s', strtotime($transaction['date_added'])),
                'customer' => $transaction['customer'],
                'metodo' => $metodo,
                'status' => $status,
                'view_order' => $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $transaction['order_id'], true),
                'action' => $action
            );
        }

        $data['user_token'] = $this->session->data['user_token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/paymee/list', $data));
    }

    public function consultar() {
        $json = array();

        $this->load->language('extension/paymee/list');

        if ($this->user->hasPermission('modify', 'extension/paymee/list')) {
            if (isset($this->request->get['paymee_id'])) {
                $paymee_id = (int) $this->request->get['paymee_id'];

                $this->load->model('extension/payment/paymee');
                $transaction_info = $this->model_extension_payment_paymee->getTransaction($paymee_id);

                if ($transaction_info) {
                    $dados['debug'] = $this->config->get('payment_paymee_debug');
                    $dados['sandbox'] = $this->config->get('payment_paymee_sandbox');
                    $dados['x_api_key'] = $this->config->get('payment_paymee_x_api_key');
                    $dados['x_api_token'] = $this->config->get('payment_paymee_x_api_token');
                    $dados['uuid'] = $transaction_info['uuid'];

                    require_once(DIR_SYSTEM . 'library/paymee/paymee.php');
                    $paymee = new PayMee();
                    $paymee->setParametros($dados);
                    $resposta = $paymee->getTransaction();

                    if (isset($resposta->situation) && isset($resposta->status) && $resposta->status == '0') {
                        $status = $resposta->situation;

                        switch ($status) {
                            case 'PENDING':
                                $mensagem = $this->language->get('text_pendente');
                                break;
                            case 'PAID':
                                if ($resposta->type == 'SALE') {
                                    $mensagem = $this->language->get('text_paga');
                                } else if ($resposta->type == 'REFUND') {
                                    $status = 'REFUNDED';
                                    $mensagem = $this->language->get('text_reembolsada');
                                }
                                break;
                            case 'CANCELLED':
                                $mensagem = $this->language->get('text_cancelada');
                                break;
                        }

                        $campos = array('paymee_id' => $paymee_id, 'status' => $status);
                        $this->model_extension_payment_paymee->editTransaction($campos);

                        if (isset($mensagem)) {
                            $json['success'] = $mensagem;
                        } else {
                            $json['success'] = $this->language->get('text_consultou');
                        }
                    } else if (isset($resposta->status) && $resposta->status == '999') {
                        $json['error'] = $this->language->get('error_nao_encontrada');
                    } else {
                        $json['error'] = $this->language->get('error_consultar');
                    }
                } else {
                    $json['error'] = $this->language->get('error_consultar');
                }
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function cancelar() {
        $json = array();

        $this->load->language('extension/paymee/list');

        if ($this->user->hasPermission('modify', 'extension/paymee/list')) {
            if (isset($this->request->get['paymee_id'])) {
                $paymee_id = (int) $this->request->get['paymee_id'];

                $this->load->model('extension/payment/paymee');
                $transaction_info = $this->model_extension_payment_paymee->getTransaction($paymee_id);

                if ($transaction_info) {
                    $dados['debug'] = $this->config->get('payment_paymee_debug');
                    $dados['sandbox'] = $this->config->get('payment_paymee_sandbox');
                    $dados['x_api_key'] = $this->config->get('payment_paymee_x_api_key');
                    $dados['x_api_token'] = $this->config->get('payment_paymee_x_api_token');
                    $dados['uuid'] = $transaction_info['uuid'];

                    require_once(DIR_SYSTEM . 'library/paymee/paymee.php');
                    $paymee = new PayMee();
                    $paymee->setParametros($dados);

                    $status = $transaction_info['status'];
                    if ($status == 'PENDING') {
                        $resposta = $paymee->setCancel();

                        if (isset($resposta->status) && $resposta->status == '0') {
                            $campos = array('paymee_id' => $paymee_id, 'status' => 'CANCELLED');
                            $this->model_extension_payment_paymee->editTransaction($campos);

                            $json['success'] = $this->language->get('text_cancelou');
                        } else if (isset($resposta->status) && $resposta->status == '998') {
                            $json['error'] = $this->language->get('error_nao_encontrada');
                        } else {
                            $json['error'] = $this->language->get('error_cancelar');
                        }
                    } else {
                        $json['error'] = $this->language->get('error_cancelar');
                    }
                } else {
                    $json['error'] = $this->language->get('error_warning');
                }
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function reembolsar() {
        $json = array();

        $this->load->language('extension/paymee/list');

        if ($this->user->hasPermission('modify', 'extension/paymee/list')) {
            if (isset($this->request->get['paymee_id'])) {
                $paymee_id = (int) $this->request->get['paymee_id'];

                $this->load->model('extension/payment/paymee');
                $transaction_info = $this->model_extension_payment_paymee->getTransaction($paymee_id);

                if ($transaction_info) {
                    $dados['debug'] = $this->config->get('payment_paymee_debug');
                    $dados['sandbox'] = $this->config->get('payment_paymee_sandbox');
                    $dados['x_api_key'] = $this->config->get('payment_paymee_x_api_key');
                    $dados['x_api_token'] = $this->config->get('payment_paymee_x_api_token');
                    $dados['uuid'] = $transaction_info['uuid'];
                    $dados['amount'] = number_format($transaction_info['amount'], 2, '.', '');

                    require_once(DIR_SYSTEM . 'library/paymee/paymee.php');
                    $paymee = new PayMee();
                    $paymee->setParametros($dados);

                    $status = $transaction_info['status'];
                    if ($status == 'PAID') {
                        $resposta = $paymee->setRefund();

                        if (isset($resposta->status) && $resposta->status == '0') {
                            $campos = array('paymee_id' => $paymee_id, 'status' => 'REFUNDED');
                            $this->model_payment_paymee->editTransaction($campos);

                            $json['success'] = $this->language->get('text_reembolsou');
                        } else if (isset($resposta->status) && $resposta->status == '998') {
                            $json['error'] = $this->language->get('error_nao_encontrada');
                        } else {
                            $json['error'] = $this->language->get('error_reembolsar');
                        }
                    } else {
                        $json['error'] = $this->language->get('error_reembolsar');
                    }
                } else {
                    $json['error'] = $this->language->get('error_warning');
                }
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function excluir() {
        $json = array();

        $this->load->language('extension/paymee/list');

        if ($this->user->hasPermission('modify', 'extension/paymee/list')) {
            if (isset($this->request->get['paymee_id'])) {
                $paymee_id = (int) $this->request->get['paymee_id'];

                $this->load->model('extension/payment/paymee');
                $this->model_extension_payment_paymee->deleteTransaction($paymee_id);

                $json['success'] = $this->language->get('text_excluiu');
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}