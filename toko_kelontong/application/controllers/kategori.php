<?php

    class Kategori extends CI_Controller{
        private function render_kategori($method, $label)
        {
            $data['judul_kategori'] = $label;
            $data['produk'] = $this->model_kategori->$method()->result();
            foreach ($data['produk'] as &$produk) {
                $filename = trim((string) $produk->gambar);
                $diskPath = FCPATH.'uploads'.DIRECTORY_SEPARATOR.$filename;
                if ($filename === '' || !is_file($diskPath)) {
                    $filename = '0.jpg';
                }
                $produk->image_url = base_url('uploads/'.rawurlencode($filename));
            }
            unset($produk);
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('templates/product_grid', $data);
            $this->load->view('templates/footer');
        }

        public function elektronik()
        {
            $this->render_kategori('data_elektronik', 'Elektronik');
        }

        public function pakaian_pria()
        {
            $this->render_kategori('data_pakaian_pria', 'Pakaian Pria');
        }

        public function pakaian_wanita()
        {
            $this->render_kategori('data_pakaian_wanita', 'Pakaian Wanita');
        }

        public function pakaian_anak()
        {
            $this->render_kategori('data_pakaian_anak', 'Pakaian Anak');
        }

        public function peralatan_olahraga()
        {
            $this->render_kategori('data_peralatan_olahraga', 'Peralatan Olahraga');
        }
    }

    ?>
