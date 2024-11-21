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
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <button class="btn btn-success" onclick="history.back(-1)" style="background-color: #f33a77; border-color: #f33a77;"
                        >
                            <div class="fa fa-arrow-left" ></div> Kembali
                        </button>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <?php foreach ($kegiatan->result_array() as $row) { ?>
                                    <tr>
                                        <td>Periode</td>
                                        <td>:</td>
                                        <td><?= $this->db->where('id', $row['idPeriode'])->get('tb_periode')->row('periode'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Kegiatan</td>
                                        <td>:</td>
                                        <td><?= $row['nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>:</td>
                                        <td><?= $row['keterangan'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                                if($row['status'] == 'Terlaksana') {
                                                    echo '<div class="label label-success">'.$row['status'].'</div>';
                                                } else {
                                                    echo '<div class="label label-danger">'.$row['status'].'</div>';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Diinput Pada</td>
                                        <td>:</td>
                                        <td><?= date('d F Y H:i:s', strtotime($row['terdaftar'])) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box">
                    <div class="box-header">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahData" style="background-color: #f33a77; border-color: #f33a77;"
                        >
                            <div class="fa fa-plus"></div> Tambah Data
                        </button>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th width="10px">#</th>
                                        <th>Nama File</th>
                                        <th>File</th>
                                        <th>Terdaftar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        foreach ($lampiran->result_array() as $row) {
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama'] ?></td>
                                            <td>
                                                <a href="<?= base_url('assets/file/').$row['file'] ?>" class="btn btn-success btn-xs">
                                                    <div class="fa fa-eye"></div> Lampiran
                                                </a>
                                            </td>
                                            <td><?= date('d F Y H:i:s', strtotime($row['terdaftar'])) ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editData<?= $row['id'] ?>">
                                                    <div class="fa fa-edit"></div> Edit
                                                </button>
                                                <a href="<?= base_url('admin/kegiatan/deletelampiran/').$row['id'].'/'.$idPeriode.'/'.$idData ?>" class="btn btn-danger btn-xs tombol-yakin" data-isidata="Ingin menghapus data ini">
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
            <form action="<?= base_url('admin/kegiatan/insertlampiran/').$idPeriode.'/'.$idData ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama File</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama File" required>
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" name="file" class="form-control-file" placeholder="File" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger"><div class="fa fa-trash"></div> Reset</button>
                    <button type="submit" class="btn btn-primary"><div class="fa fa-save"></div> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<?php foreach ($lampiran->result() as $edit) { ?>
    <div class="modal fade" id="editData<?= $edit->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit <?= $title ?></h4>
                </div>
                <form action="<?= base_url('admin/kegiatan/updatelampiran/').$idPeriode.'/'.$edit->id.'/'.$edit->idKegiatan ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama File</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama File" value="<?= $edit->nama ?>" required>
                        </div>
                        <div class="form-group">
                            <label>File <font color="red"></font></label>
                            <input type="file" name="file" class="form-control-file" placeholder="File">
                        </div>
                        <font color="red">
                            <small><b><i>Kosongkan jika tidak ingin diubah!</i></b></small>
                        </font>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger"><div class="fa fa-trash"></div> Reset</button>
                        <button type="submit" class="btn btn-primary"><div class="fa fa-save"></div> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>