<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>150</h3>
                <p>Pesanan Baru</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-cart-fill"></i>
            </div>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Info Lebih Lanjut <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>53<sup class="fs-5">%</sup></h3>
                <p>Bounce Rate</p>
            </div>
            <div class="small-box-icon">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Info Lebih Lanjut <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Judul Kartu</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
            </button>
            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        Selamat! Anda berhasil masuk
    </div>
    <div class="card-footer">
        Footer
    </div>
</div>

<?= $this->endSection() ?>