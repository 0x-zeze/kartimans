<div class="auth-page">
    <div class="auth-logo">
        <img src="<?= base_url('assets/img/logos.jpeg'); ?>" alt="Kartimans Barbershop">
    </div>

    <div class="auth-card">
        <?php if ($this->session->userdata('error')) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" data-autohide="2000">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->userdata('error') ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" data-autohide="2000">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php } ?>

        <h1 class="auth-title">Login</h1>
        <p class="auth-subtitle">Kartimans Barbershop</p>

        <form action="<?= base_url('ControllerLogin'); ?>" method="post">
            <div class="auth-field mb-3">
                <span class="auth-field-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="3.2"></circle>
                        <path d="M5.5 19.2c.7-3.2 3.3-5.2 6.5-5.2s5.8 2 6.5 5.2"></path>
                    </svg>
                </span>
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?= set_value('username'); ?>" autocomplete="username">
            </div>
            <?= form_error('username', '<small class="text-danger d-block mb-2">', '</small>'); ?>

            <div class="auth-field mb-3">
                <span class="auth-field-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="5" y="11" width="14" height="9" rx="2"></rect>
                        <path d="M8 11V8.2A4 4 0 0 1 16 8.2V11"></path>
                    </svg>
                </span>
                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="current-password">
            </div>
            <?= form_error('password', '<small class="text-danger d-block mb-2">', '</small>'); ?>

            <button type="submit" class="btn btn-login btn-block">Login</button>
        </form>

        <div class="auth-links">
            <a href="<?= base_url('ControllerLogin/register'); ?>">Buat akun baru</a>
            <span class="text-muted mx-2">·</span>
            <a href="<?= base_url('Home'); ?>">Beranda</a>
        </div>
    </div>
</div>
