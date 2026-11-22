<div class="container-fluid py-4">
    <div class="card shadow-sm"><div class="card-body">
        <h1 class="h4">Pesanan dibuat</h1>
        <p>Nomor pesanan: <strong><?php echo html_escape($invoice->order_id ?: $invoice->id); ?></strong></p>
        <p>Status pembayaran: <span class="badge badge-warning"><?php echo html_escape($invoice->status_pembayaran ?: 'pending'); ?></span></p>
        <?php if ($this->session->flashdata('payment_simulated')): ?><div class="alert alert-info">Mode simulasi aktif: belum ada pembayaran nyata. Atur kredensial Midtrans untuk membuka Snap Checkout.</div><?php endif; ?>
        <?php if ($this->session->flashdata('pesan')): ?><div class="alert alert-warning"><?php echo html_escape($this->session->flashdata('pesan')); ?></div><?php endif; ?>
        <?php if (!empty($invoice->payment_url)): ?><a class="btn btn-primary" href="<?php echo html_escape($invoice->payment_url); ?>" target="_blank" rel="noopener">Lanjutkan Pembayaran</a><?php else: ?><p>Silakan lakukan transfer sesuai instruksi admin. Pembayaran belum dikonfirmasi.</p><?php endif; ?>
        <a class="btn btn-outline-secondary" href="<?php echo site_url('welcome'); ?>">Kembali ke toko</a>
    </div></div>
</div>
