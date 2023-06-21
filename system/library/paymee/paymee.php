<?php
/**
 * Class PayMee
 *
 * @package PayMee
 * @author OpenCart Brasil
 * @copyright Copyright (c) 2010 - 2021, OpenCart Brasil
 * @license https://opensource.org/licenses/GPL-3.0
 * @link https://www.opencartbrasil.com.br
 */
final class PayMee
{
    /**
     * @var array
     */
    private $_parametro = array();

    /**
     * @var array
     */
    private $_dados = array();

    /**
     * @var string
     */
    private $_x_api_key;

    /**
     * @var string
     */
    private $_x_api_token;

    /**
     * @var string
     */
    private $_url;

    /**
     * @var string
     */
    private $_verbo;

    /**
     * @param array
     * @return void
     */
    public function setParametros($dados = array()) {
        $this->_parametro = $dados;
    }

    /**
     * @return object|bool
     */
    public function setTransaction() {
        $requisitos = $this->validar_requisitos();
        if ($requisitos == false) { return false; }

        $campos = array('debug', 'sandbox', 'x_api_key', 'x_api_token', 'amount', 'order_id', 'vencimento', 'metodo', 'url_notificacao', 'id', 'cliente', 'email', 'documento', 'telefone', 'agencia', 'conta');
        $parametros = $this->validar_parametros($campos);
        if ($parametros == false) {
            $this->debug('Erro 412 (Precondition Failed). Não foram enviados todos os dados necessários para a PayMee iniciar o checkout.');
            return false;
        }

        $x_api_key = trim($this->_parametro['x_api_key']);
        if (empty($x_api_key)) {
            $this->debug('Erro 412 (Precondition Failed). O x_api_key não foi informado.');
            return false;
        }

        $x_api_token = trim($this->_parametro['x_api_token']);
        if (empty($x_api_token)) {
            $this->debug('Erro 412 (Precondition Failed). O x_api_token não foi informado.');
            return false;
        }

        $amount = $this->_parametro['amount'];
        if ($amount <= 0) {
            $this->debug('Erro 412 (Precondition Failed). O valor do pedido não pode ser menor que zero.');
            return false;
        }

        $order_id = $this->_parametro['order_id'];
        if (empty($order_id)) {
            $this->debug('Erro 412 (Precondition Failed). O código do pedido não foi informado.');
            return false;
        }

        $vencimento = $this->_parametro['vencimento'];
        if ($vencimento < 60) {
            $this->debug('Erro 412 (Precondition Failed). O vencimento não pode ser inferior há 1 hora.');
            return false;
        }

        $metodo = $this->_parametro['metodo'];
        $metodos = array('BB_TRANSFER','BRADESCO_TRANSFER','ITAU_TRANSFER_GENERIC','ITAU_TRANSFER_PF', 'ITAU_TRANSFER_PJ', 'ITAU_DI', 'CEF_TRANSFER', 'ORIGINAL_TRANSFER', 'INTER_TRANSFER', 'BS2_TRANSFER', 'SANTANDER_TRANSFER', 'SANTANDER_DI', 'PIX');
        if (!in_array($metodo, $metodos)) {
            $this->debug('Erro 412 (Precondition Failed). O método de pagamento não é válido.');
            return false;
        }

        $url_notificacao = preg_replace('/[^A-Za-z0-9-:_?=.\/]/', '', $this->_parametro['url_notificacao']);
        if (($url_notificacao == '') || (strlen($url_notificacao) > 255)) {
            $this->debug('Erro 412 (Precondition Failed). A URL de notificação não é válida.');
            return false;
        }

        $cliente = trim($this->_parametro['cliente']);
        if (empty($cliente)) {
            $this->debug('Erro 412 (Precondition Failed). O cliente não foi informado.');
            return false;
        }

        $email = trim($this->_parametro['email']);
        if (empty($email)) {
            $this->debug('Erro 412 (Precondition Failed). O e-mail não foi informado.');
            return false;
        }

        $documento = preg_replace("/[^0-9]/", '', $this->_parametro['documento']);
        if (strlen($documento) < 11) {
            $this->debug('Erro 412 (Precondition Failed). O documento não é válido.');
            return false;
        }

        $telefone = preg_replace("/[^0-9]/", '', $this->_parametro['telefone']);
        if (strlen($telefone) < 10) {
            $this->debug('Erro 412 (Precondition Failed). O telefone não é válido.');
            return false;
        }

        $id = trim($this->_parametro['id']);
        $agencia = preg_replace('/[^A-Za-z0-9-]/', '', $this->_parametro['agencia']);
        $conta = preg_replace('/[^A-Za-z0-9-]/', '', $this->_parametro['conta']);

        $subdominio = ($this->_parametro['sandbox']) ? 'apisandbox' : 'api';

        $this->_x_api_key = $x_api_key;
        $this->_x_api_token = $x_api_token;
        $this->_url = 'https://' . $subdominio . '.paymee.com.br/v1.1/checkout/transparent';
        $this->_verbo = 'POST';
        $this->_dados['currency'] = 'BRL';
        $this->_dados['amount'] = (float) $amount;
        $this->_dados['referenceCode'] = utf8_substr($order_id, 0, 64);
        $this->_dados['maxAge'] = (int) $vencimento;
        $this->_dados['paymentMethod'] = $metodo;
        $this->_dados['callbackURL'] = $url_notificacao;
        if (!empty($id)) {
            $this->_dados['shopper']['id'] = utf8_substr($id, 0, 255);
        }
        $this->_dados['shopper']['email'] = utf8_substr($email, 0, 50);
        $this->_dados['shopper']['name'] = utf8_substr($cliente, 0, 255);
        $this->_dados['shopper']['document']['type'] = (strlen($documento) == 11) ? 'CPF' : 'CNPJ';
        $this->_dados['shopper']['document']['number'] = $documento;
        $this->_dados['shopper']['phone']['type'] = (strlen($telefone) == 10) ? 'HOME' : 'MOBILE';
        $this->_dados['shopper']['phone']['number'] = utf8_substr($telefone, 0, 25);
        if (!empty($agencia)) {
            $this->_dados['shopper']['bankDetails']['branch'] = utf8_substr($agencia, 0, 6);
        }
        if (!empty($conta)) {
            $this->_dados['shopper']['bankDetails']['account'] = utf8_substr($conta, 0, 15);
        }

        $resposta = $this->getCall();

        $debug = ($this->_parametro['debug']) ? $this->debug($resposta) : '';

        return $resposta;
    }

    /**
     * @return object|bool
     */
    public function getTransaction() {
        $requisitos = $this->validar_requisitos();
        if ($requisitos == false) { return false; }

        $campos = array('debug', 'sandbox', 'x_api_key', 'x_api_token', 'uuid');
        $parametros = $this->validar_parametros($campos);
        if ($parametros == false) {
            $this->debug('Erro 412 (Precondition Failed). Não foram enviados todos os dados necessários para a PayMee consultar a transação.');
            return false;
        }

        $x_api_key = trim($this->_parametro['x_api_key']);
        if (empty($x_api_key)) {
            $this->debug('Erro 412 (Precondition Failed). O x_api_key não foi informado.');
            return false;
        }

        $x_api_token = trim($this->_parametro['x_api_token']);
        if (empty($x_api_token)) {
            $this->debug('Erro 412 (Precondition Failed). O x_api_token não foi informado.');
            return false;
        }

        $uuid = trim($this->_parametro['uuid']);
        if (empty($uuid)) {
            $this->debug('Erro 412 (Precondition Failed). O id da transação não é válido.');
            return false;
        }

        $subdominio = ($this->_parametro['sandbox']) ? 'apisandbox' : 'api';

        $this->_x_api_key = $x_api_key;
        $this->_x_api_token = $x_api_token;
        $this->_url = 'https://' . $subdominio . '.paymee.com.br/v1.1/transactions/' . $uuid;
        $this->_verbo = 'GET';
        $this->_dados = array();

        $resposta = $this->getCall();

        $debug = ($this->_parametro['debug']) ? $this->debug($resposta) : '';

        return $resposta;
    }

    /**
     * @return object|bool
     */
    public function setCancel() {
        $requisitos = $this->validar_requisitos();
        if ($requisitos == false) { return false; }

        $campos = array('debug', 'sandbox', 'x_api_key', 'x_api_token', 'uuid');
        $parametros = $this->validar_parametros($campos);
        if ($parametros == false) {
            $this->debug('Erro 412 (Precondition Failed). Não foram enviados todos os dados necessários para a PayMee cancelar a transação.');
            return false;
        }

        $x_api_key = trim($this->_parametro['x_api_key']);
        if (empty($x_api_key)) {
            $this->debug('Erro 412 (Precondition Failed). O x_api_key não foi informado.');
            return false;
        }

        $x_api_token = trim($this->_parametro['x_api_token']);
        if (empty($x_api_token)) {
            $this->debug('Erro 412 (Precondition Failed). O x_api_token não foi informado.');
            return false;
        }

        $uuid = trim($this->_parametro['uuid']);
        if (empty($uuid)) {
            $this->debug('Erro 412 (Precondition Failed). O id da transação não é válido.');
            return false;
        }

        $subdominio = ($this->_parametro['sandbox']) ? 'apisandbox' : 'api';

        $this->_x_api_key = $x_api_key;
        $this->_x_api_token = $x_api_token;
        $this->_url = 'https://' . $subdominio . '.paymee.com.br/v1.1/transactions/' . $uuid . '/void';
        $this->_verbo = 'PUT';
        $this->_dados = array();

        $resposta = $this->getCall();

        $debug = ($this->_parametro['debug']) ? $this->debug($resposta) : '';

        return $resposta;
    }

    /**
     * @return object|bool
     */
    public function setRefund() {
        $requisitos = $this->validar_requisitos();
        if ($requisitos == false) { return false; }

        $campos = array('debug', 'sandbox', 'x_api_key', 'x_api_token', 'uuid', 'amount');
        $parametros = $this->validar_parametros($campos);
        if ($parametros == false) {
            $this->debug('Erro 412 (Precondition Failed). Não foram enviados todos os dados necessários para a PayMee estornar o pagamento da transação.');
            return false;
        }

        $x_api_key = trim($this->_parametro['x_api_key']);
        if (empty($x_api_key)) {
            $this->debug('Erro 412 (Precondition Failed). O x_api_key não foi informado.');
            return false;
        }

        $x_api_token = trim($this->_parametro['x_api_token']);
        if (empty($x_api_token)) {
            $this->debug('Erro 412 (Precondition Failed). O x_api_token não foi informado.');
            return false;
        }

        $uuid = trim($this->_parametro['uuid']);
        if (empty($uuid)) {
            $this->debug('Erro 412 (Precondition Failed). O id da transação não é válido.');
            return false;
        }

        $amount = $this->_parametro['amount'];
        if ($amount <= 0) {
            $this->debug('Erro 412 (Precondition Failed). O valor do pedido não pode ser menor que zero.');
            return false;
        }

        $subdominio = ($this->_parametro['sandbox']) ? 'apisandbox' : 'api';

        $this->_x_api_key = $x_api_key;
        $this->_x_api_token = $x_api_token;
        $this->_url = 'https://' . $subdominio . '.paymee.com.br/v1.1/transactions/' . $uuid . '/refund';
        $this->_verbo = 'PUT';

        $this->_dados['amount'] = (float) $amount;
        //$this->_dados['reason'] = '';

        $resposta = $this->getCall();

        $debug = ($this->_parametro['debug']) ? $this->debug($resposta) : '';

        return $resposta;
    }

    /**
     * @return object|bool
     */
    private function getCall() {
        $code = '0';
        $response = 'Sem resposta.';

        $headers = array();
        $headers[] = 'Content-type: application/json';
        $headers[] = 'x-api-key: ' . $this->_x_api_key;
        $headers[] = 'x-api-token: ' . $this->_x_api_token;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->_verbo);
        curl_setopt($curl, CURLOPT_POSTFIELDS, (count($this->_dados)) ? json_encode($this->_dados) : false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        if ($code == '200' || $code == '201') {
            if (
                version_compare(phpversion(), '7.4.0alpha1', '<')
                && function_exists('get_magic_quotes_gpc')
                && get_magic_quotes_gpc()
            ) {
                $response = stripslashes($response);
            }

            $json = json_decode($response);

            if ($json === false || $json === null) {
                $this->debug('Erro 412 (Precondition Failed). Não foi possível decodificar o json recebido através da API da PayMee.');
                return false;
            }

            return $json;
        } else if ($code == '400') {
            $this->debug('Erro 400 (Bad Request). Erro nos dados do pedido que foram enviados para a API da PayMee.');
            $this->debug($this->_dados);
            ($response) ? $this->debug($response) : '';
            return false;
        } else if ($code == '403') {
            $this->debug('Erro 403 (Forbidden). Entre em contato com a PayMee, e verifique se o x_api_key e o x_api_token são válidos válidos.');
            return false;
        } else if ($code == '404') {
            $this->debug('Erro 404 (Resource Not Found). O recurso solicitado não foi encontrado na API da PayMee.');
            return false;
        } else if ($code == '500') {
            $this->debug('Erro 500 (Internal Server Error). A API da PayMee não respondeu por problemas técnicos. Entre em contato com a PayMee para mais informações.');
            return false;
        } else if ($error) {
            $this->debug($error);
            return false;
        } else {
            $this->debug('Erro não identificado. Código HTTP: ' . $code . '. Resposta: ' . $response);
            return false;
        }
    }

    /**
     * @return bool
     */
    private function validar_requisitos() {
        if (extension_loaded('mbstring')) {
            mb_internal_encoding('UTF-8');
        } else {
            $this->debug('Erro 412 (Precondition Failed). A extensão mbstring do PHP está desabilitada em sua hospedagem. Entre em contato com o suporte de sua hospedagem, e solicite que habilitem a extensão.');
            return false;
        }

        if (!extension_loaded('curl')) {
            $this->debug('Erro 412 (Precondition Failed). A extensão curl do PHP está desabilitada em sua hospedagem. Entre em contato com o suporte de sua hospedagem, e solicite que habilitem a extensão.');
            return false;
        }

        if (!extension_loaded('json')) {
            $this->debug('Erro 412 (Precondition Failed). A extensão json do PHP está desabilitada em sua hospedagem. Entre em contato com o suporte de sua hospedagem e solicite que habilitem a extensão.');
            return false;
        }

        if (!function_exists('json_encode')) {
            $this->debug('Erro 412 (Precondition Failed). A função json_encode do PHP está desabilitada em sua hospedagem. Entre em contato com o suporte de sua hospedagem e solicite que habilitem a função.');
            return false;
        }

        if (!function_exists('json_decode')) {
            $this->debug('Erro 412 (Precondition Failed). A função json_decode do PHP está desabilitada em sua hospedagem. Entre em contato com o suporte de sua hospedagem e solicite que habilitem a função.');
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    private function validar_parametros($campos) {
        $erros = 0;
        foreach ($campos as $campo) {
            if (!isset($this->_parametro[$campo])) {
                $erros++;
                break;
            }
        }

        if ($erros == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return int
     */
    private function utf8_strlen($string) {
        if (extension_loaded('mbstring')) {
            return mb_strlen($string);
        } else {
            return strlen($string);
        }
    }

    /**
     * @return string
     */
    private function utf8_substr($string, $offset, $length = null) {
        if (extension_loaded('mbstring')) {
            if ($length === null) {
                return mb_substr($string, $offset, utf8_strlen($string));
            } else {
                return mb_substr($string, $offset, $length);
            }
        } else {
            return substr($string, $offset, $length);
        }
    }

    /**
     * @return void
     */
    private function debug($log) {
        if (defined('DIR_LOGS')){
            $file = DIR_LOGS . 'paymee.log';
            $handle = fopen($file, 'a');
            fwrite($handle, date('d/m/Y H:i:s (T)') . "\n");
            fwrite($handle, print_r($log, true) . "\n");
            fclose($handle);
        }
    }
}
