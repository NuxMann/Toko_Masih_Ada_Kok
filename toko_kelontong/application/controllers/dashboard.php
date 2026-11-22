<?php

class Dashboard extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        redirect('welcome');
    }

    public function tambah_ke_keranjang($id)
    {
        $barang = $this->model_barang->find($id);
        if (empty($barang) || (int) $barang->stok < 1) {
            $this->session->set_flashdata('pesan', 'Produk tidak tersedia atau stok habis.');
            redirect('welcome');
            return;
        }

        $data = array(

            'id'      => $barang->id_brg,
            'qty'     => 1,
            'price'   => $barang->harga,
            'name'    => $barang->nama_brg
            
    );
    
        $this->cart->insert($data);
    redirect('welcome');

    }

    public function detail_keranjang()
    {
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar'); 
        $this->load->view('keranjang'); 
        $this->load->view('templates/footer');
    }
    
    public function hapus_keranjang()
    {
        $this->cart->destroy();
        redirect('welcome');
    }

    public function pembayaran()
    {
        if (!$this->cart->contents()) { redirect('dashboard/detail_keranjang'); return; }
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar'); 
        $this->load->view('pembayaran'); 
        $this->load->view('templates/footer');
    }

    public function proses_pesanan()
    {
        if ($this->input->method(TRUE) !== 'POST') { redirect('dashboard/pembayaran'); return; }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Nama lengkap', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor telepon', 'required|trim');
        if (!$this->form_validation->run() || !$this->cart->contents()) {
            $this->session->set_flashdata('pesan', validation_errors() ?: 'Keranjang masih kosong.');
            redirect('dashboard/pembayaran'); return;
        }
        $result = $this->model_invoice->create_order($this->input->post(NULL, TRUE));
        if (!$result) { show_error('Pesanan gagal dibuat. Silakan periksa stok dan coba kembali.', 409); return; }
        $this->cart->destroy();
        if ($this->input->post('metode_pembayaran', TRUE) === 'midtrans_snap') {
            try {
                $this->load->library('midtrans_snap');
                $invoice = $this->model_invoice->ambil_id_invoice($result['invoice_id']);
                $payment = $this->midtrans_snap->create($result['order_id'], $this->model_invoice->invoice_total($result['invoice_id']), array('first_name'=>$invoice->nama,'phone'=>$invoice->no_telp));
                $this->model_invoice->save_payment_url($result['invoice_id'], $payment['payment_url'], $payment['simulated'] ? 'manual_pending' : 'pending');
                $this->session->set_flashdata('payment_simulated', $payment['simulated']);
            } catch (Exception $e) {
                log_message('error', 'Midtrans: '.$e->getMessage());
                $this->session->set_flashdata('pesan', 'Gateway belum dapat dihubungi. Pesanan tersimpan dengan status menunggu pembayaran manual.');
            }
        }
        redirect('dashboard/status_pembayaran/'.$result['invoice_id']);
    }

    public function notifikasi_midtrans()
    {
        $payload = json_decode($this->input->raw_input_stream, TRUE);
        if (!$payload || empty($payload['order_id']) || empty($payload['transaction_status'])) { show_error('Invalid notification', 400); return; }
        $this->config->load('midtrans', TRUE);
        $serverKey = $this->config->item('midtrans_server_key', 'midtrans');
        $expected = hash('sha512', $payload['order_id'].$payload['status_code'].$payload['gross_amount'].$serverKey);
        if ($serverKey === '' || empty($payload['signature_key']) || !hash_equals($expected, $payload['signature_key'])) { show_error('Invalid signature', 401); return; }
        $this->model_invoice->update_payment_status($payload['order_id'], $payload['transaction_status']);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('ok'=>TRUE)));
    }

    public function status_pembayaran($id = NULL)
    {
        $invoice = $this->model_invoice->ambil_id_invoice((int) $id);
        if (!$invoice) { show_404(); return; }
        $data['invoice'] = $invoice;
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('pembayaran_status', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id_brg)
    {
        $data['barang'] = $this->model_barang->detail_brg($id_brg);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar'); 
        $this->load->view('detail_barang',$data); 
        $this->load->view('templates/footer');
    }

}

