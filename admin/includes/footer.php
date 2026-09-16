<?php if (!isset($base)) { $base = ''; } ?>
        </div><!-- /.content -->
    </div><!-- /.main-area -->
</div><!-- /.admin-wrapper -->

<!-- Modal Konfirmasi Hapus (UI placeholder, belum ada proses database) -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
        </div>
        <h3>Hapus data ini?</h3>
        <p>Kamu akan menghapus <strong id="deleteTargetLabel">item ini</strong>. Tindakan ini tidak dapat dibatalkan setelah data tersimpan di database.</p>
        <div class="modal-actions">
            <button class="btn btn-outline" data-modal-cancel>Batal</button>
            <button class="btn btn-danger-soft" id="deleteConfirmBtn">Ya, Hapus</button>
        </div>
    </div>
</div>

<script src="<?php echo $base; ?>assets/js/admin.js"></script>
</body>
</html>
