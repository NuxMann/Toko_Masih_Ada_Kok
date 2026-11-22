<?php 

    class Model_kategori extends CI_Model{
        private function data_kategori($kategori)
        {
            return $this->db->where('kategori', $kategori)->order_by('nama_brg', 'ASC')->get('tb_barang');
        }

        public function data_elektronik()
        {
           return $this->data_kategori('Elektronik');
        }

        public function data_pakaian_pria()
        {
           return $this->data_kategori('Pakaian Pria');
        }

        public function data_pakaian_wanita()
        {
           return $this->data_kategori('Pakaian Wanita');
        }

        public function data_pakaian_anak()
        {
           return $this->data_kategori('Pakaian Anak');
        }

        public function data_peralatan_olahraga()
        {
           return $this->data_kategori('Peralatan Olahraga');
        }
    }

?>
