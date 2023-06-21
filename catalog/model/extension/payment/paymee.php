<?php
class ModelExtensionPaymentPaymee extends Model {
    public function getMethod($address, $total) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('payment_paymee_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

        if ($total <= 0) {
            $status = false;
        } elseif ($this->config->get('payment_paymee_total') > 0 && $this->config->get('payment_paymee_total') > $total) {
            $status = false;
        } elseif (!$this->config->get('payment_paymee_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $currencies = array('BRL');
        $currency_code = $this->session->data['currency'];
        if (!in_array(strtoupper($currency_code), $currencies)) {
            $status = false;
        }

        if (!in_array($this->config->get('config_store_id'), $this->config->get('payment_paymee_stores'))) {
            $status = false;
        }

        if ($this->customer->isLogged()) {
            $customer_group_id = $this->customer->getGroupId();
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }
        if (!in_array($customer_group_id, $this->config->get('payment_paymee_customer_groups'))) {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            if (strlen(trim($this->config->get('payment_paymee_imagem'))) > 0) {
                $title = '<img src="'.HTTPS_SERVER.'image/'.$this->config->get('payment_paymee_imagem').'" alt="'.$this->config->get('payment_paymee_titulo').'" />';
            } else {
                $title = $this->config->get('payment_paymee_titulo');
            }

            $method_data = array(
                'code' => 'paymee',
                'title' => $title,
                'terms' => '',
                'sort_order' => $this->config->get('payment_paymee_sort_order')
            );
        }

        return $method_data;
    }

    public function editOrder($order_id, $data) {
        $this->db->query("
            UPDATE `" . DB_PREFIX . "order`
            SET custom_field = '" . $this->db->escape(json_encode($data['custom_field'])) . "'
            WHERE order_id = '" . (int) $order_id . "'
        ");
    }

    public function getOrder($data, $order_id) {
        $columns = implode(", ", array_values($data));

        $query = $this->db->query("
            SELECT " . $columns . "
            FROM `" . DB_PREFIX . "order`
            WHERE `order_id` = '" . (int) $order_id . "'
        ");

        if ($query->num_rows) {
            return $query->row;
        } else {
            return false;
        }
    }

    public function getTransaction($order_id) {
        $query = $this->db->query("
            SELECT * FROM `" . DB_PREFIX . "order_paymee`
            WHERE order_id = '" . (int) $order_id . "'
        ");

        if ($query->num_rows) {
            return $query->row;
        } else {
            return false;
        }
    }

    public function addTransaction($data) {
        $columns = implode(", ", array_keys($data));
        $values = "'".implode("', '", array_values($data))."'";
        $this->db->query("INSERT INTO `" . DB_PREFIX . "order_paymee` ($columns) VALUES ($values)");
    }

    public function editTransaction($data) {
        $this->db->query("
            UPDATE `" . DB_PREFIX . "order_paymee`
            SET amount = '" . (float) $data['amount'] . "',
                status = '" . $this->db->escape($data['status']) . "'
            WHERE order_id = '" . (int) $data['order_id'] . "'
        ");
    }
}