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
            <button class="btn btn-success" onclick="history.back(-1)" style="background-color: #f33a77; border-color: #f33a77;">
                <div class="fa fa-arrow-left"></div> Kembali
            </button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahData" style="background-color: #f33a77; border-color: #f33a77;">
                <div class="fa fa-plus"></div> Tambah Data
            </button>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>Periode</th>
                                <?php if($this->session->userdata('level') == 'Administrator') { ?>
                                    <th>User</th>
                                <?php } ?>
                                <th>Nama Kegiatan</th>
                                <th>Keterangan</th>
                                <th>Lampiran</th>
                                <th>Status</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach ($kegiatan->result_array() as $row) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $this->db->where('id', $row['idPeriode'])->get('tb_periode')->row('periode'); ?></td>
                                    <?php if($this->session->userdata('level') == 'Administrator') { ?>
                                        <td><?= $this->db->where('id', $row['idUser'])->get('tb_user')->row('nama'); ?></td>
                                    <?php } ?>
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['keterangan'] ?></td>
                                    <td>
                                        <?php
                                            $this->db->where('idKegiatan', $row['id']);
                                            if(empty($jumlah = $this->db->get('tb_lampiran')->num_rows())) {
                                                echo '<div class="label label-danger">Belum ada</div>';
                                            } else {
                                                echo '<div class="label label-success">'.$jumlah.' lampiran</div>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($row['status'] == 'Terlaksana') {
                                                echo '<div class="label label-success">'.$row['status'].'</div>';
                                            } else {
                                                echo '<div class="label label-danger">'.$row['status'].'</div>';
                                            }
                                        ?>
                                    </td>
                                    <td><?= date('d F Y H:i:s', strtotime($row['terdaftar'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/kegiatan/lampiran/').$idPeriode.'/'.$row['id'] ?>" class="btn btn-pink btn-xs" style="background-color: #ffe2ec; border-color: #ffe2ec;"
                                        >
                                            <div class="fa fa-upload"></div> Lampiran
                                        </a>
                                        <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>" style="background-color: #f1adc4; border-color: #f1adc4;">
                                            <div class="fa fa-edit"></div> Edit
                                        </button>
                                        <?php if($row['status'] == 'Belum Terlaksana') { ?>
                                            <a href="<?= base_url('admin/kegiatan/delete/').$row['id'].'/'.$idPeriode ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Ingin menghapus data ini" style="background-color: #cd4c77; border-color: #cd4c77;">
                                            <div class="fa fa-trash"></div> Delete
                                        </a>
                                        <?php } ?>
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
            <form action="<?= base_url('admin/kegiatan/insert/').$idPeriode ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama Kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="" disabled selected> -- Pilih Status -- </option>
                            <option value="Terlaksana">Terlaksana</option>
                            <option value="Belum Terlaksana">Belum Terlaksana</option>
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

<!-- Modal Edit Data -->
<?php foreach ($kegiatan->result() as $edit) { ?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit <?= $title ?></h4>
                </div>
                <form action="<?= base_url('admin/kegiatan/update/').$edit->id.'/'.$idPeriode ?>" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kegiatan</label>
                            <input type="text" name="nama" class="form-control" value="<?= $edit->nama ?>" placeholder="Nama Kegiatan" required>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="<?= $edit->keterangan ?>" placeholder="Keterangan" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Terlaksana" <?= ($edit->status == 'Terlaksana') ? 'selected' : '' ?>>Terlaksana</option>
                                <option value="Belum Terlaksana" <?= ($edit->status == 'Belum Terlaksana') ? 'selected' : '' ?>>Belum Terlaksana</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="reset" class="btn btn-danger" style="background-color: #f33a77; border-color: #f33a77;">
                        <div class="fa fa-trash"></div> Reset
                    </button>
                    <button type="submit" class="btn btn-primary" style="background-color: #f33a77; border-color: #f33a77;">
                        <div class="fa fa-save"></div> Update
                    </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
