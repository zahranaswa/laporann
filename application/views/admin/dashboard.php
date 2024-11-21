<div class="content-wrapper" style="background-color: #ffe4e1;">
    <section class="content-header">
        <h1 style="color: #d5006d;">
            <?= $title ?>
            <small><?= $subtitle ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin/dashboard') ?>" style="color: #d5006d;"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active" style="color: #d5006d;"><?= $title ?></li>
        </ol>
    </section>
    
    <section class="content">
        <?php if($this->session->userdata('level') == 'Administrator') { ?>
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box" style="background-color: rgba(255, 179, 179, 0.8);">
                        <div class="inner">
                            <h3>
                                <?= $this->db->get('tb_periode')->num_rows() ?>
                            </h3>
                            <p>Total Periode</p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-list" style="color: #b30000;"></div>
                        </div>
                        <a href="<?= base_url('admin/periode') ?>" class="small-box-footer" style="color: #d5006d;">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box" style="background-color: rgba(204, 230, 255, 0.8);">
                        <div class="inner">
                            <h3>
                                <?= $this->db->get('tb_kegiatan')->num_rows() ?>
                            </h3>
                            <p>Total Kegiatan</p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-book" style="color: #004080;"></div>
                        </div>
                        <a href="<?= base_url('admin/kegiatan') ?>" class="small-box-footer" style="color: #005cbf;">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box" style="background-color: rgba(179, 255, 179, 0.8);">
                        <div class="inner">
                            <h3>
                                <?= $this->db->where('status', 'Terlaksana')->get('tb_kegiatan')->num_rows() ?>
                            </h3>
                            <p>Total Kegiatan Terlaksana</p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-check" style="color: #006600;"></div>
                        </div>
                        <a href="<?= base_url('admin/kegiatan') ?>" class="small-box-footer" style="color: #004d00;">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box" style="background-color: rgba(255, 255, 204, 0.8);">
                        <div class="inner">
                            <h3>
                                <?= $this->db->where('status', 'Belum Terlaksana')->get('tb_kegiatan')->num_rows() ?>
                            </h3>
                            <p>Total Kegiatan Belum Terlaksana</p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-close" style="color: #cc9900;"></div>
                        </div>
                        <a href="<?= base_url('admin/kegiatan') ?>" class="small-box-footer" style="color: #b38b00;">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-lg-4 col-xs-12">
                    <div class="small-box" style="background-color: rgba(255, 179, 179, 0.8);">
                        <div class="inner">
                            <h3>
                                <?= $this->db->where('idUser', $this->session->userdata('id'))->get('tb_kegiatan')->num_rows() ?>
                            </h3>
                            <p>Total Kegiatan Saya</p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-book" style="color: #b30000;"></div>
                        </div>
                        <a href="<?= base_url('admin/kegiatan') ?>" class="small-box-footer" style="color: #d5006d;">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box" style="background-color: rgba(204, 230, 255, 0.8);">
                        <div class="inner">
                            <h3>
                                <?php
                                    $this->db->where('idUser', $this->session->userdata('id'));
                                    $this->db->where('status', 'Terlaksana');
                                    echo $this->db->get('tb_kegiatan')->num_rows();
                                ?>
                            </h3>
                            <p>Total Kegiatan Terlaksana</p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-check" style="color: #004080;"></div>
                        </div>
                        <a href="<?= base_url('admin/kegiatan') ?>" class="small-box-footer" style="color: #005cbf;">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6">
                    <div class="small-box" style="background-color: rgba(179, 255, 179, 0.8);">
                        <div class="inner">
                            <h3>
                                <?php
                                    $this->db->where('idUser', $this->session->userdata('id'));
                                    $this->db->where('status', 'Belum Terlaksana');
                                    echo $this->db->get('tb_kegiatan')->num_rows();
                                ?>
                            </h3>
                            <p>Total Kegiatan Belum Terlaksana</p>
                        </div>
                        <div class="icon">
                            <div class="fa fa-close" style="color: #006600;"></div>
                        </div>
                        <a href="<?= base_url('admin/kegiatan') ?>" class="small-box-footer" style="color: #004d00;">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
</div>
