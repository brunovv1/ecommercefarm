<?php
class ModelExtensionPaymentPaymee extends Model {
    public function install() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "order_paymee` (
                `order_paymee_id` INT(11) NOT NULL AUTO_INCREMENT,
                `order_id` INT(11) NULL,
                `uuid` VARCHAR(100) NULL,
                `chosen` VARCHAR(30) NULL,
                `amount` DECIMAL(15,4) NULL,
                `status` VARCHAR(10) NULL,
                PRIMARY KEY (`order_paymee_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
        ");
    }

    public function update() {
        $this->install();

        $fields = array(
            'order_paymee_id' => 'int(11)',
            'order_id' => 'int(11)',
            'uuid' => 'varchar(100)',
            'chosen' => 'varchar(30)',
            'amount' => 'decimal(15,4)',
            'status' => 'varchar(10)'
        );

        $table = DB_PREFIX . "order_paymee";

        $field_query = $this->db->query("SHOW COLUMNS FROM `" . $table . "`");
        foreach ($field_query->rows as $field) {
            $field_data[$field['Field']] = $field['Type'];
        }

        foreach ($field_data as $key => $value) {
            if (!array_key_exists($key, $fields)) {
                $this->db->query("ALTER TABLE `" . $table . "` DROP COLUMN `" . $key . "`");
            }
        }

        $this->session->data['after_column'] = 'order_paymee_id';
        foreach ($fields as $key => $value) {
            if (!array_key_exists($key, $field_data)) {
                $this->db->query("ALTER TABLE `" . $table . "` ADD `" . $key . "` " . $value . " AFTER `" . $this->session->data['after_column'] . "`");
            }
            $this->session->data['after_column'] = $key;
        }
        unset($this->session->data['after_column']);

        foreach ($fields as $key => $value) {
            if ($key == 'order_paymee_id') {
                $this->db->query("ALTER TABLE `" . $table . "` CHANGE COLUMN `" . $key . "` `" . $key . "` " . $value . " NOT NULL AUTO_INCREMENT");
            } else {
                $this->db->query("ALTER TABLE `" . $table . "` CHANGE COLUMN `" . $key . "` `" . $key . "` " . $value);
            }
        }
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "order_paymee`;");
    }

    public function getColumns($data = array()) {
        $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "order`";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTransactions() {
        $query = $this->db->query("
            SELECT op.order_id, op.order_paymee_id, o.date_added, CONCAT(o.firstname, ' ', o.lastname) as customer, op.chosen, op.status
            FROM `" . DB_PREFIX . "order_paymee` op 
            INNER JOIN `" . DB_PREFIX . "order` o ON (o.order_id = op.order_id)
            WHERE op.order_id > '0' ORDER BY op.order_id DESC;
        ");

        return $query->rows;
    }

    public function getTransaction($paymee_id) {
        $query = $this->db->query("
            SELECT o.store_id, op.*
            FROM `" . DB_PREFIX . "order_paymee` op
            INNER JOIN `" . DB_PREFIX . "order` o ON (o.order_id = op.order_id)
            WHERE op.order_paymee_id = '" . (int) $paymee_id . "'
        ");

        if ($query->num_rows) {
            return $query->row;
        } else {
            return false;
        }
    }

    public function editTransaction($data) {
        $this->db->query("
            UPDATE `" . DB_PREFIX . "order_paymee`
            SET status = '" . $this->db->escape($data['status']) . "'
            WHERE order_paymee_id = '" . (int) $data['paymee_id'] . "'
        ");
    }

    public function deleteTransaction($paymee_id) {
        $this->db->query("
            DELETE FROM `" . DB_PREFIX . "order_paymee`
            WHERE order_paymee_id = '" . (int) $paymee_id . "'"
        );
    }
}