<div class="container-fluid py-3">
    <h1 class="h3 mb-4 text-gray-800"><?php echo html_escape($judul_kategori); ?></h1>
    <div class="row">
        <?php if (empty($produk)): ?>
            <div class="col-12"><div class="alert alert-info">Belum ada produk pada kategori ini.</div></div>
        <?php else: ?>
            <?php foreach ($produk as $brg): ?>
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm product-card">
                        <img class="card-img-top product-image" src="<?php echo html_escape($brg->image_url); ?>" alt="<?php echo html_escape($brg->nama_brg); ?>" loading="lazy">
                        <div class="card-body d-flex flex-column">
                            <div class="text-muted small mb-1"><?php echo html_escape($brg->kategori); ?> · Stok <?php echo (int) $brg->stok; ?></div>
                            <h5 class="card-title"><?php echo html_escape($brg->nama_brg); ?></h5>
                            <p class="card-text text-muted product-description"><?php echo html_escape($brg->keterangan); ?></p>
                            <div class="mt-auto">
                                <div class="font-weight-bold text-success mb-3">Rp <?php echo number_format($brg->harga, 0, ',', '.'); ?></div>
                                <a class="btn btn-sm btn-primary" href="<?php echo site_url('dashboard/tambah_ke_keranjang/'.$brg->id_brg); ?>">Tambah ke keranjang</a>
                                <a class="btn btn-sm btn-outline-secondary" href="<?php echo site_url('dashboard/detail/'.$brg->id_brg); ?>">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<style>
.product-image { height: 220px; object-fit: contain; padding: 12px; background: #fff; }
.product-description { min-height: 3rem; }
</style>
