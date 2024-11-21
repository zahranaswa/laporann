<div class="content-wrapper" style="background-color: #ffe4e1;">
    <section class="content-header">
        <h1>
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahData"    style="background-color: #f33a77; border-color: #f33a77;">
                    <div class="fa fa-plus"></div> Tambah Data
                </button>
                <button class="btn btn-success" data-toggle="modal" data-target="#importExcel"    style="background-color: #f33a77; border-color: #f33a77;">
                    <div class="fa fa-file-excel-o"></div> Import Excel
                </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Username</th>
                                <th>Telp</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Login?</th>
                                <th>Sebagai</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($user->result_array() as $row) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['jenisKelamin'] ?></td>
                                    <td><?= $row['tptLahir'] . ', ' . date('d F Y', strtotime($row['tglLahir'])) ?></td>
                                    <td><?= $row['username'] ?></td>
                                    <td><?= $row['telp'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['alamat'] ?></td>
                                    <td>
                                        <?php
                                            if($row['login'] == 'Ya') {
                                                echo '<div class="label label-success">'.$row['login'].'</div>';
                                            } else {
                                                echo '<div class="label label-danger">'.$row['login'].'</div>';
                                            }
                                        ?>
                                    </td>
                                    <td><?= $row['level'] ?></td>
                                    <td><?= date('d F Y H:i:s', strtotime($row['terdaftar'])) ?></td>
                                    <td>
                                    <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>" style="background-color: #f1adc4; border-color: #f1adc4;">
                                        <div class="fa fa-edit"></div> Edit
                                    </button>
                                        <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#resetPassword<?= $row['id'] ?>" style="background-color: #f98cb0; border-color: #f98cb0;">
                                            <div class="fa fa-lock"></div> Reset Password
                                        </button>
                                        <a href="<?= base_url('admin/user/delete/').$row['id'] ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Account tidak bisa dipulihkan setelah dihapus" style="background-color: #cd4c77; border-color: #cd4c77;">
                                            <div class="fa fa-trash"></div> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah <?= $title ?></h4>
            </div>
            <form action="<?= base_url('admin/user/insert') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenisKelamin" class="form-control" required>
                            <option value="" disabled selected> -- Pilih Jenis Kelamin -- </option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tptLahir" class="form-control" placeholder="Tempat Lahir" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tglLahir" class="form-control" placeholder="Tanggal Lahir" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telp</label>
                                <input type="number" name="telp" class="form-control" placeholder="Telp" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                    </div>
                    <div class="form-group">
                        <label>Login?</label>
                        <select name="login" class="form-control" required>
                            <option value="" disabled selected> -- Pilih Login -- </option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Sebagai</label>
                        <select name="level" class="form-control" required>
                            <option value="" disabled selected> -- Pilih Sebagai -- </option>
                            <option value="Administrator">Administrator</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="reset" class="btn btn-danger" style="background-color: #f33a77; border-color: #f33a77;">
                    <div class="fa fa-trash"></div> Reset
                </button>
                <button type="submit" class="btn btn-primary" style="background-color: #f33a77; border-color: #f33a77;">
                    <div class="fa fa-save"></div> Save
                </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<?php foreach ($user->result() as $reset) { ?>
    <div class="modal fade" id="resetPassword<?= $reset->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Reset Password : <?= $reset->nama ?></h4>
                </div>
                <form action="<?= base_url('admin/user/resetpassword/').$reset->id ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                            <input type="password" name="password" class="form-control" placeholder="New Password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="reset" class="btn btn-danger" style="background-color: #f33a77; border-color: #f33a77;">
                        <div class="fa fa-trash"></div> Reset
                    </button>
                    <button type="submit" class="btn btn-primary" style="background-color: #f33a77; border-color: #f33a77;">
                        <div class="fa fa-lock"></div> Reset Password
                    </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Edit Data -->
<?php foreach ($user->result() as $edit) { ?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit <?= $title ?></h4>
                </div>
                <form action="<?= base_url('admin/user/update/').$edit->id ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" value="<?= $edit->nama ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenisKelamin" class="form-control" required>
                                <option value="Laki-Laki" <?= ($edit->jenisKelamin == 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
                                <option value="Perempuan" <?= ($edit->jenisKelamin == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tptLahir" class="form-control" placeholder="Tempat Lahir" value="<?= $edit->tptLahir ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tglLahir" class="form-control" placeholder="Tanggal Lahir" value="<?= $edit->tglLahir ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telp</label>
                                    <input type="number" name="telp" class="form-control" placeholder="Telp" value="<?= $edit->telp ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $edit->email ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?= $edit->alamat ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Login?</label>
                            <select name="login" class="form-control" required>
                                <option value="Ya" <?= ($edit->login == 'Ya') ? 'selected' : '' ?>>Ya</option>
                                <option value="Tidak" <?= ($edit->login == 'Tidak') ? 'selected' : '' ?>>Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="reset" class="btn btn-danger" style="background-color: #f33a77; border-color: #f33a77;">
                        <div class="fa fa-trash"></div> Reset
                    </button>
                    <button type="submit" class="btn btn-primary" style="background-color: #f33a77; border-color: #f33a77;">
                        <div class="fa fa-save"></div> Save
                    </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Import Excel <?= $title ?></h4>
            </div>
            <form action="<?= base_url('admin/user/importexcel') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <div class="modal-body">
                    <div class="form-group">
                        <label>File Excel</label>                        
                        <input type="file" name="file" class="form-control-file" placeholder="File Excel" required>
                    </div>
                    <font color="red">
                        <small><i>NB : Hanya file berformat <b>xlsx</b> yang dapat diupload!</i></small>
                    </font>
                </div>
                <div class="modal-footer">
                <a href="<?= base_url('assets/file_excel/example/import_manajemen_user.xlsx') ?>" class="btn btn-success pull-left" style="background-color: #f33a77; border-color: #f33a77;">
                    <div class="fa fa-download"></div> Template
                </a>
                    <button type="reset" class="btn btn-danger" style="background-color: #f33a77; border-color: #f33a77;">
                        <div class="fa fa-trash"></div> Reset
                    </button>
                    <button type="submit" class="btn btn-primary" style="background-color: #f33a77; border-color: #f33a77;">
                        <div class="fa fa-save"></div> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>