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
            <form class="form-horizontal" action="<?= base_url('admin/kegiatan/search') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Periode</label>

                        <div class="col-sm-10">
                            <select name="idPeriode" class="form-control" required>
                                <option value="" disabled selected> -- Pilih Periode -- </option>
                                <?php foreach ($periode->result_array() as $row) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['periode'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="reset" class="btn btn-danger">
                            <div class="fa fa-trash"></div> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <div class="fa fa-search"></div> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>