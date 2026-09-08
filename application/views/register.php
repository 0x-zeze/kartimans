<div class="auth-page">
    <div class="auth-logo">
        <img src="<?= base_url('assets/img/logos.jpeg'); ?>" alt="Kartimans Barbershop">
    </div>

    <div class="auth-card">
        <h1 class="auth-title">Register</h1>
        <p class="auth-subtitle">Kartimans Barbershop</p>

        <form action="<?= base_url('ControllerLogin/register'); ?>" method="post">
            <div class="form-group mb-3">
                <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?= set_value('nama'); ?>">
            </div>
            <div class="form-group mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" value="<?= set_value('email'); ?>">
            </div>
            <div class="form-group mb-3">
                <input type="text" class="form-control" name="no_wa" placeholder="Nomor WhatsApp" value="<?= set_value('no_wa'); ?>">
            </div>
            <div class="form-group mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username" value="<?= set_value('username'); ?>">
                <?= form_error('username', '<small class="text-danger d-block mt-1">', '</small>'); ?>
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <?= form_error('password', '<small class="text-danger d-block mt-1">', '</small>'); ?>
            </div>
            <button type="submit" class="btn btn-login btn-block">Register</button>
        </form>

        <div class="auth-links">
            <a href="<?= base_url('ControllerLogin'); ?>">Sudah punya akun? Login</a>
        </div>
    </div>
</div>
