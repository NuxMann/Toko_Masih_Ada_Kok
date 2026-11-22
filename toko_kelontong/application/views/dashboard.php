<div class="container-fluid">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
             <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
             <img src="<?php echo base_url('assets/img/slider1.jpg')?>"  class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="<?php echo base_url('assets/img/slider2.jpg')?>" class="d-block w-100" alt="...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>

        <?php
        $kategoriToko = array(
            array('Elektronik', 'kategori/elektronik', 'fa-laptop'),
            array('Pakaian Pria', 'kategori/pakaian_pria', 'fa-tshirt'),
            array('Pakaian Wanita', 'kategori/pakaian_wanita', 'fa-female'),
            array('Pakaian Anak', 'kategori/pakaian_anak', 'fa-child'),
            array('Peralatan Olahraga', 'kategori/peralatan_olahraga', 'fa-futbol')
        );
        ?>
        <section class="mt-4 mb-4" aria-labelledby="category-heading">
            <h2 id="category-heading" class="h5 font-weight-bold text-gray-800 mb-3">KATEGORI</h2>
            <div class="row">
                <?php foreach ($kategoriToko as $kategori): ?>
                    <div class="col-6 col-md-4 col-lg mb-3">
                        <a class="category-tile" href="<?php echo site_url($kategori[1]); ?>">
                            <span class="category-icon"><i class="fas <?php echo $kategori[2]; ?>" aria-hidden="true"></i></span>
                            <span class="font-weight-bold small"><?php echo html_escape($kategori[0]); ?></span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    <div class="row text-center mt-3 ">
        
        <?php foreach ($barang as $brg) : ?>
            
            <div class="card ml-2 mr-1 mt-3 mb-3  " style="width: 300px;">
             <img src="<?php echo base_url(). '/uploads/'.$brg->gambar ?>" class="card-img-top" alt="...">
                 <div class="card-body ">
                      <h5 class="card-title mb-1"><?php echo $brg->nama_brg ?></h5>
                      <small><?php echo $brg->keterangan ?></small><br>
                      <span class="badge badge-success mb-3 mt-2">Rp. <?php echo number_format($brg->harga, 0, ',' , '.') ?></span><br>
                      <?php echo anchor('dashboard/tambah_ke_keranjang/'.$brg->id_brg,'<div class="btn btn-sm btn-primary">Tambah Ke Keranjang</div>')  ?>
                      <?php echo anchor('dashboard/detail/'.$brg->id_brg,'<div class="btn btn-sm btn-success">Detail</div>')  ?>
                      
             </div>
         </div>
            
        <?php endforeach; ?>
    </div>
</div>
