-- Apply once to an existing db_toko_online. Nullable/defaulted fields preserve legacy invoices.
ALTER TABLE tb_invoice
    ADD COLUMN order_id VARCHAR(64) NULL,
    ADD COLUMN status_pembayaran VARCHAR(24) NOT NULL DEFAULT 'pending',
    ADD COLUMN metode_pembayaran VARCHAR(32) NOT NULL DEFAULT 'manual',
    ADD COLUMN payment_url TEXT NULL,
    ADD COLUMN no_telp VARCHAR(32) NULL,
    ADD UNIQUE KEY uq_tb_invoice_order_id (order_id);
