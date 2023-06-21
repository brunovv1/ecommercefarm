<?php
class ControllerExtensionPaymentPaymee extends Controller {
    public function index() {
        $data = $this->load->language('extension/payment/paymee');

        $data['logo'] = HTTPS_SERVER . 'image/catalog/paymee/paymee.png';

        $data['sandbox'] = $this->config->get('payment_paymee_sandbox');

        $data['cor_normal_texto'] = $this->config->get('payment_paymee_cor_normal_texto');
        $data['cor_normal_fundo'] = $this->config->get('payment_paymee_cor_normal_fundo');
        $data['cor_normal_borda'] = $this->config->get('payment_paymee_cor_normal_borda');
        $data['cor_efeito_texto'] = $this->config->get('payment_paymee_cor_efeito_texto');
        $data['cor_efeito_fundo'] = $this->config->get('payment_paymee_cor_efeito_fundo');
        $data['cor_efeito_borda'] = $this->config->get('payment_paymee_cor_efeito_borda');

        $metodos = array();
        $metodos_todos = array(
            array('metodo' => 'PIX', 'titulo' => $this->language->get('text_pix'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/pix.png', 'alt' => $this->language->get('text_pix')),
            array('metodo' => 'BB_TRANSFER', 'titulo' => $this->language->get('text_transferencia'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/banco_brasil.png', 'alt' => $this->language->get('text_banco_brasil')),
            array('metodo' => 'BRADESCO_TRANSFER', 'titulo' => $this->language->get('text_transferencia'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/bradesco.png', 'alt' => $this->language->get('text_bradesco')),
            array('metodo' => 'ITAU_TRANSFER_GENERIC', 'titulo' => $this->language->get('text_transferencia'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/itau.png', 'alt' => $this->language->get('text_itau')),
            array('metodo' => 'CEF_TRANSFER', 'titulo' => $this->language->get('text_transferencia'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/caixa.png', 'alt' => $this->language->get('text_caixa')),
            array('metodo' => 'ORIGINAL_TRANSFER', 'titulo' => $this->language->get('text_transferencia'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/original.png', 'alt' => $this->language->get('text_original')),
            array('metodo' => 'SANTANDER_TRANSFER', 'titulo' => $this->language->get('text_transferencia'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/santander.png', 'alt' => $this->language->get('text_santander')),
            array('metodo' => 'INTER_TRANSFER', 'titulo' => $this->language->get('text_transferencia'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/inter.png', 'alt' => $this->language->get('text_inter')),
            array('metodo' => 'BS2_TRANSFER', 'titulo' => $this->language->get('text_transferencia'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/bs2.png', 'alt' => $this->language->get('text_bs2')),
            array('metodo' => 'ITAU_DI', 'titulo' => $this->language->get('text_deposito'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/itau.png', 'alt' => $this->language->get('text_itau')),
            array('metodo' => 'SANTANDER_DI', 'titulo' => $this->language->get('text_deposito'), 'imagem' => HTTPS_SERVER . 'image/catalog/paymee/santander.png', 'alt' => $this->language->get('text_santander'))
        );
        $metodos_habilitados = $this->config->get('payment_paymee_metodos');

        foreach ($metodos_todos as $metodo) {
            if (in_array($metodo['metodo'], $metodos_habilitados)) {
                array_push($metodos, $metodo);
            }
        }

        $data['metodos'] = json_encode($metodos);

        $data['termos_dados'] = $this->language->get('entry_dados');
        $data['termos_aceito'] = $this->language->get('entry_aceito');
        $data['termos_prazo'] = sprintf($this->language->get('entry_prazo'), ($this->config->get('payment_paymee_vencimento') / 60));

        include_once(DIR_SYSTEM . 'library/paymee/versao.php');

        return $this->load->view('extension/payment/paymee', $data);
    }

    private function getValidacao() {
        $order_id = $this->session->data['order_id'];

        $this->load->model('extension/payment/paymee');

        if ($this->config->get('payment_paymee_one_checkout')) {
            $order_data['custom_field'] = array();

            if ($this->customer->isLogged()) {
                $this->load->model('account/customer');
                $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

                $order_data['custom_field'] = json_decode($customer_info['custom_field'], true);
            } else {
                $order_data['custom_field'] = $this->session->data['guest']['custom_field'];
            }

            $order_info = $this->model_extension_payment_paymee->editOrder($order_id, $order_data);
        }

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);

        $colunas = array();
        if ($this->config->get('payment_paymee_custom_razao_id') == 'N') {
            array_push($colunas, $this->config->get('payment_paymee_razao_coluna'));
        }
        if ($this->config->get('payment_paymee_custom_cnpj_id') == 'N') {
            array_push($colunas, $this->config->get('payment_paymee_cnpj_coluna'));
        }
        if ($this->config->get('payment_paymee_custom_cpf_id') == 'N') {
            array_push($colunas, $this->config->get('payment_paymee_cpf_coluna'));
        }

        $cliente = '';
        $documento = '';

        $colunas_info = array();
        if (count($colunas)) {
            $colunas_info = $this->model_extension_payment_paymee->getOrder($colunas, $order_id);
        }

        if ($this->config->get('payment_paymee_custom_razao_id') == 'N') {
            if (isset($colunas_info[$this->config->get('payment_paymee_razao_coluna')])) {
                $cliente = trim($colunas_info[$this->config->get('payment_paymee_razao_coluna')]);
            }
        } else {
            if ($this->config->get('payment_paymee_custom_razao_id')) {
                if (is_array($order_info['custom_field'])) {
                    foreach ($order_info['custom_field'] as $key => $value) {
                        if ($this->config->get('payment_paymee_custom_razao_id') == $key) {
                            $cliente = trim($value);
                        }
                    }
                }
            }
        }

        if ($this->config->get('payment_paymee_custom_cnpj_id') == 'N') {
            if (isset($colunas_info[$this->config->get('payment_paymee_cnpj_coluna')])) {
                $documento = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('payment_paymee_cnpj_coluna')]);
            }
        } else {
            if ($this->config->get('payment_paymee_custom_cnpj_id')) {
                if (is_array($order_info['custom_field'])) {
                    foreach ($order_info['custom_field'] as $key => $value) {
                        if ($this->config->get('payment_paymee_custom_cnpj_id') == $key) {
                            $documento = preg_replace("/[^0-9]/", '', $value);
                        }
                    }
                }
            }
        }

        if (empty($cliente)) {
            if ($this->config->get('payment_paymee_custom_cpf_id') == 'N') {
                if (isset($colunas_info[$this->config->get('payment_paymee_cpf_coluna')])) {
                    $documento = preg_replace("/[^0-9]/", '', $colunas_info[$this->config->get('payment_paymee_cpf_coluna')]);
                }
            } else {
                if ($this->config->get('payment_paymee_custom_cpf_id')) {
                    if (is_array($order_info['custom_field'])) {
                        foreach ($order_info['custom_field'] as $key => $value) {
                            if ($this->config->get('payment_paymee_custom_cpf_id') == $key) {
                                $documento = preg_replace("/[^0-9]/", '', $value);
                            }
                        }
                    }
                }
            }
        }

        $this->load->language('extension/payment/paymee_validacao');

        $cliente = (empty($cliente)) ? trim($order_info['firstname'].' '.$order_info['lastname']) : $cliente;

        $telefone = preg_replace("/[^0-9]/", '', $order_info['telephone']);

        $erros = '';

        if (strlen($cliente) < 1) {
            $erros .= $this->language->get('error_cliente');
        }

        if (($this->config->get('payment_paymee_cnpj_coluna')) || ($this->config->get('payment_paymee_cpf_coluna'))) {
            if (strlen($documento) == 11 || strlen($documento) == 14) {
            } else {
                $erros .= $this->language->get('error_documento');
            }
        }

        if (strlen($telefone) == 10 || strlen($telefone) == 11) {
        } else {
            $erros .= $this->language->get('error_telefone');
        }

        if (empty($erros)) {
            return false;
        } else {
            return $erros;
        }
    }

    public function transacao() {
        $json = array();

        $this->language->load('extension/payment/paymee');

        $validacao = $this->getValidacao();
        if (isset($this->session->data['order_id']) && (empty($validacao)) && isset($this->request->post['metodo']) && ($this->session->data['payment_method']['code'] == 'paymee')) {
            $order_id = $this->session->data['order_id'];

            $metodo = $this->request->post['metodo'];

            $agencia = '';
            if (isset($this->request->post['agencia'])) {
                $agencia = $this->request->post['agencia'];
            }

            $conta = '';
            if (isset($this->request->post['conta'])) {
                $conta = $this->request->post['conta'];
            }

            $this->load->model('checkout/order');
            $order_info = $this->model_checkout_order->getOrder($order_id);

            $this->load->model('extension/payment/paymee');

            $cliente = '';
            $documento = '';

            $colunas = array();
            if ($this->config->get('payment_paymee_custom_razao_id') == 'N') {
                array_push($colunas, $this->config->get('payment_paymee_razao_coluna'));
            }
            if ($this->config->get('payment_paymee_custom_cnpj_id') == 'N') {
                array_push($colunas, $this->config->get('payment_paymee_cnpj_coluna'));
            }
            if ($this->config->get('payment_paymee_custom_cpf_id') == 'N') {
                array_push($colunas, $this->config->get('payment_paymee_cpf_coluna'));
            }

            $colunas_info = array();
            if (count($colunas)) {
                $colunas_info = $this->model_extension_payment_paymee->getOrder($colunas, $order_id);
            }

            if ($this->config->get('payment_paymee_custom_razao_id') == 'N') {
                if (isset($colunas_info[$this->config->get('payment_paymee_razao_coluna')])) {
                    $cliente = $colunas_info[$this->config->get('payment_paymee_razao_coluna')];
                }
            } else {
                if (is_array($order_info['custom_field'])) {
                    foreach ($order_info['custom_field'] as $key => $value) {
                        if ($this->config->get('payment_paymee_custom_razao_id') == $key) {
                            $cliente = $value;
                        }
                    }
                }
            }

            if ($this->config->get('payment_paymee_custom_cnpj_id') == 'N') {
                if (isset($colunas_info[$this->config->get('payment_paymee_cnpj_coluna')])) {
                    $documento = $colunas_info[$this->config->get('payment_paymee_cnpj_coluna')];
                }
            } else {
                if (is_array($order_info['custom_field'])) {
                    foreach ($order_info['custom_field'] as $key => $value) {
                        if ($this->config->get('payment_paymee_custom_cnpj_id') == $key) {
                            $documento = $value;
                        }
                    }
                }
            }

            if (empty($cliente)) {
                if ($this->config->get('payment_paymee_custom_cpf_id') == 'N') {
                    if (isset($colunas_info[$this->config->get('payment_paymee_cpf_coluna')])) {
                        $documento = $colunas_info[$this->config->get('payment_paymee_cpf_coluna')];
                    }
                } else {
                    if (is_array($order_info['custom_field'])) {
                        foreach ($order_info['custom_field'] as $key => $value) {
                            if ($this->config->get('payment_paymee_custom_cpf_id') == $key) {
                                $documento = $value;
                            }
                        }
                    }
                }
            }

            $dados['debug'] = $this->config->get('payment_paymee_debug');
            $dados['sandbox'] = $this->config->get('payment_paymee_sandbox');
            $dados['x_api_key'] = $this->config->get('payment_paymee_x_api_key');
            $dados['x_api_token'] = $this->config->get('payment_paymee_x_api_token');
            $dados['vencimento'] = $this->config->get('payment_paymee_vencimento');
            $dados['order_id'] = $order_id;
            $total = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
            $dados['amount'] = number_format($total, 2, '.', '');
            $dados['metodo'] = $metodo;
            $dados['id'] = $order_info['customer_id'];
            $dados['cliente'] = (!empty($cliente)) ? trim($cliente) : trim($order_info['payment_firstname'] .' '. $order_info['payment_lastname']);
            $dados['documento'] = $documento;
            $dados['email'] = $order_info['email'];
            $dados['telefone'] = $order_info['telephone'];
            $dados['agencia'] = $agencia;
            $dados['conta'] = $conta;
            $dados['url_notificacao'] = HTTPS_SERVER . 'index.php?route=extension/payment/paymee/notificacao';

            require_once(DIR_SYSTEM . 'library/paymee/paymee.php');
            $paymee = new PayMee();
            $paymee->setParametros($dados);
            $resposta = $paymee->setTransaction();

            if ($resposta) {
                if (isset($resposta->status) && ($resposta->status == '0')) {
                    $campos = array(
                        'order_id' => $order_id,
                        'uuid' => $resposta->response->uuid,
                        'chosen' => $resposta->response->instructions->chosen,
                        'amount' => number_format($resposta->response->amount, 2, '.', ''),
                        'status' => 'PENDING'
                    );

                    $comentario = '';
                    if (isset($resposta->response->instructions->steps->qrCode)) {
                        $comentario .= sprintf($this->language->get('text_qrcode'), $resposta->response->instructions->qrCode->url, $resposta->response->instructions->qrCode->plain);

                        foreach ($resposta->response->instructions->steps->qrCode as $step) {
                            $comentario .= $step . "\n";
                        }
                    } else {
                        foreach ($resposta->response->instructions->steps as $step) {
                            $comentario .= $step . "\n";
                        }
                    }

                    if (!empty($conta)) {
                        $comentario .= sprintf($this->language->get('text_conta'), $conta) . "\n";
                    }

                    $comentario .= sprintf($this->language->get('text_vencimento'), ($this->config->get('payment_paymee_vencimento') / 60)) . "\n";
                    $comentario .= $this->language->get('text_confirmacao') . "\n";

                    if (isset($this->session->data['instrucoes'])) { unset($this->session->data['instrucoes']); }
                    $this->session->data['instrucoes'] = $comentario;

                    $this->model_extension_payment_paymee->addTransaction($campos);

                    $this->load->model('checkout/order');
                    $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('payment_paymee_situacao_pendente_id'), $comentario, true);

                    $json['redirect'] = $this->url->link('extension/payment/paymee/confirmado');
                } else {
                    $json['error'] = $this->language->get('error_json');
                }
            } else {
                $json['error'] = $this->language->get('error_configuracao');
            }
        } else {
            $json['error'] = sprintf($this->language->get('error_validacao'), $validacao);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function notificacao() {
        header('Content-Type: application/json;');

        $x_api_key = $this->config->get('payment_paymee_x_api_key');
        $x_api_token = $this->config->get('payment_paymee_x_api_token');

        if (empty($x_api_key) || empty($x_api_token)) {
            header('WWW-Authenticate: Basic realm="Callback PayMee"');
            header('HTTP/1.0 401 Unauthorized');
            return;
        }

        $username = '';
        $password = '';
        $auth = false;

        if (isset($this->request->server['PHP_AUTH_USER']) && isset($this->request->server['PHP_AUTH_PW'])) {
            $username = $this->request->server['PHP_AUTH_USER'];
            $password = $this->request->server['PHP_AUTH_PW'];
        } else if (isset($this->request->server['HTTP_AUTHORIZATION'])) {
            if (preg_match('/^basic/i', $this->request->server['HTTP_AUTHORIZATION'])) {
                list($username, $password) = explode(':', base64_decode(substr($this->request->server['HTTP_AUTHORIZATION'], 6)));
            }
        } else if (isset($this->request->server['REDIRECT_HTTP_AUTHORIZATION'])) {
            if (preg_match('/^basic/i', $this->request->server['REDIRECT_HTTP_AUTHORIZATION'])) {
                list($username, $password) = explode(':', base64_decode(substr($this->request->server['REDIRECT_HTTP_AUTHORIZATION'], 6)));
            }
        } else if (isset($this->request->server['REMOTE_USER'])) {
            if (preg_match('/^basic/i', $this->request->server['REMOTE_USER'])) {
                list($username, $password) = explode(':', base64_decode(substr($this->request->server['REMOTE_USER'], 6)));
            }
        }

        $username = strip_tags(trim($username));
        $password = strip_tags(trim($password));

        if ($username == $x_api_key && $password == $x_api_token) {
            $auth = true;
        }

        if (!$auth){
            header('WWW-Authenticate: Basic realm="Callback PayMee"');
            header('HTTP/1.0 401 Unauthorized');
            return;
        }

        $json = json_decode(file_get_contents("php://input"));

        if (isset($json->referenceCode) && isset($json->amount) && !isset($json->status)) {
            $order_id = $json->referenceCode;

            $this->load->model('extension/payment/paymee');
            $order_info = $this->model_extension_payment_paymee->getOrder(array('total', 'currency_code', 'currency_value'), $order_id);

            if ($order_info) {
                $transaction_info = $this->model_extension_payment_paymee->getTransaction($order_id);

                if ($transaction_info) {
                    if ($this->config->get('payment_paymee_produto_digital') == '1' && ($transaction_info['status'] == 'PAID' || $transaction_info['status'] == 'REFUNDED')) {
                        return false;
                    }

                    $this->load->language('extension/payment/paymee');

                    $amount = number_format($json->amount, 2, '.', '');

                    $valor_pago = $this->currency->format($amount, $order_info['currency_code'], '1.00', true);
                    $comentario = sprintf($this->language->get('text_pagamento'), $valor_pago);

                    $total = (float) $order_info['total'] * $order_info['currency_value'];
                    $total = round($total, 2);
                    $total = number_format($total, 2, '.', '');

                    if (floatval($total) === floatval($amount)) {
                        $order_status_id = $this->config->get('payment_paymee_situacao_pago_id');
                    } else {
                        $order_status_id = $this->config->get('payment_paymee_situacao_analise_id');
                    }

                    $campos = array(
                        'order_id' => $order_id,
                        'amount' => $amount,
                        'status' => 'PAID'
                    );
                    $this->model_extension_payment_paymee->editTransaction($campos);

                    $this->load->model('checkout/order');
                    $this->model_checkout_order->addOrderHistory($order_id, $order_status_id, $comentario, true);
                }
            }
        }
    }

    public function confirmado() {
        if (isset($this->session->data['order_id'])) {
            $this->cart->clear();

            $this->load->model('account/activity');

            if ($this->customer->isLogged()) {
                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name' => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
                    'order_id' => $this->session->data['order_id']
                );

                $this->model_account_activity->addActivity('order_account', $activity_data);
            } else {
                $activity_data = array(
                    'name' => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
                    'order_id' => $this->session->data['order_id']
                );

                $this->model_account_activity->addActivity('order_guest', $activity_data);
            }

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['guest']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);
            unset($this->session->data['totals']);
        }

        $data = $this->load->language('extension/payment/paymee_confirmado');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_basket'),
            'href' => $this->url->link('checkout/cart')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_checkout'),
            'href' => $this->url->link('checkout/checkout', '', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_success'),
            'href' => $this->url->link('extension/payment/paymee/confirmado', '', true)
        );

        $data['instrucoes'] = nl2br($this->session->data['instrucoes']);
        $data['history'] = $this->url->link('account/order', '', true);

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('extension/payment/paymee_confirmado', $data));
    }
}
