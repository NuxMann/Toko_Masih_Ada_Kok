<?php

    class Model_invoice extends CI_Model{
        public function create_order($shipping)
        {
            $items = $this->cart->contents();
            if (!$items) return FALSE;
            $this->db->trans_begin();
            foreach ($items as $item) {
                $product = $this->db->query('SELECT stok FROM tb_barang WHERE id_brg = ? FOR UPDATE', array($item['id']))->row();
                if (!$product || (int) $product->stok < (int) $item['qty']) { $this->db->trans_rollback(); return FALSE; }
            }
            $orderId = 'TK-'.date('YmdHis').'-'.mt_rand(100,999);
            $this->db->insert('tb_invoice', array(
                'nama' => $shipping['nama'], 'alamat' => $shipping['alamat'],
                'tgl_pesan' => date('Y-m-d H:i:s'), 'batas_bayar' => date('Y-m-d H:i:s', strtotime('+1 day')),
                'order_id' => $orderId, 'status_pembayaran' => 'pending',
                'metode_pembayaran' => $shipping['metode_pembayaran'] ?? 'manual',
                'payment_url' => '', 'no_telp' => $shipping['no_telp']
            ));
            $invoiceId = $this->db->insert_id();
            foreach ($items as $item) {
                if (!$this->db->insert('tb_pesanan', array('id_invoice'=>$invoiceId,'id_brg'=>$item['id'],'nama_brg'=>$item['name'],'jumlah'=>$item['qty'],'harga'=>$item['price'],'pilihan'=>''))) { $this->db->trans_rollback(); return FALSE; }
            }
            if ($this->db->trans_status() === FALSE) { $this->db->trans_rollback(); return FALSE; }
            $this->db->trans_commit();
            return array('invoice_id'=>$invoiceId, 'order_id'=>$orderId);
        }

        public function invoice_total($invoiceId)
        {
            $row = $this->db->select('SUM(jumlah * harga) AS total')->where('id_invoice', (int)$invoiceId)->get('tb_pesanan')->row();
            return (int) ($row ? $row->total : 0);
        }

        public function save_payment_url($invoiceId, $url, $status)
        {
            return $this->db->where('id', (int)$invoiceId)->update('tb_invoice', array('payment_url'=>$url ?: '', 'status_pembayaran'=>$status));
        }

        public function update_payment_status($orderId, $status)
        {
            $map = array('capture'=>'paid','settlement'=>'paid','pending'=>'pending','deny'=>'failed','cancel'=>'cancelled','expire'=>'expired');
            if (!isset($map[$status])) return FALSE;
            return $this->db->where('order_id', $orderId)->update('tb_invoice', array('status_pembayaran'=>$map[$status]));
        }

        public function index()
        {
            date_default_timezone_set('Asia/Jakarta');
            $nama   = $this->input->post('nama');
            $alamat   = $this->input->post('alamat');
           
            $invoice = array(
                'nama'        => $nama,
                'alamat'      => $alamat,
                'tgl_pesan'   => date('Y-m-d H:i:s'),
                'batas_bayar' => date('Y-m-d H:i:s', mktime( date('H'),
                 date('i'), date('s'), date('m'), date('d') + 1 ,date('Y'))),
            );
            $this->db->insert('tb_invoice', $invoice);
            $id_invoice = $this->db->insert_id();

            foreach ($this->cart->contents() as $item){
                $data = array (
                     'id_invoice'   => $id_invoice,
                     'id_brg'       => $item['id'],
                     'nama_brg'     => $item['name'],
                     'jumlah'       => $item['qty'],
                     'harga'        => $item['price'],
                );
                $this->db->insert('tb_pesanan', $data);
            }
            return TRUE;
        }
    
        public function tampil_data()
        {
            $result = $this->db->get('tb_invoice');
            if($result->num_rows() > 0){
                return $result->result();
            } else {
                return false;
            }
        }

        public function ambil_id_invoice($id_invoice)
        {
            $result = $this->db->where('id' , $id_invoice)->limit(1)->get('tb_invoice');
            if($result->num_rows() > 0){
                return $result->row();
            } else {
                return false;
            }
        }

        public function ambil_id_pesanan($id_invoice)
        {
            $result = $this->db->where('id_invoice', $id_invoice)->get('tb_pesanan');
            if($result->num_rows()  >  0){
                return $result->result();
            } else {
                return false;
            }
        }

    }

?>
