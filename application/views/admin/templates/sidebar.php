<aside class="main-sidebar" style="background-color: pink; color: black;">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li>
                <a href="<?= base_url('admin/dashboard') ?>" style="color: black;">
                    <i class="fa fa-tachometer"></i> <span class="hover-pink">Dashboard</span>
                </a>
            </li>
            <?php if($this->session->userdata('level') == 'Administrator') { ?>
                <li>
                    <a href="<?= base_url('admin/periode') ?>" style="color: black;">
                        <i class="fa fa-list"></i> <span class="hover-pink">Data Periode</span>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="<?= base_url('admin/kegiatan') ?>" style="color: black;">
                    <i class="fa fa-book"></i> <span class="hover-pink">Data Kegiatan</span>
                </a>
            </li>
            <?php if($this->session->userdata('level') == 'Administrator') { ?>
                <li class="treeview">
                    <a href="#" style="color: black;">
                        <i class="fa fa-cogs"></i> <span class="hover-pink">Pengaturan</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= base_url('admin/user') ?>" style="color: black;"><i class="fa fa-circle-o"></i> <span class="hover-pink">Manajemen User</span></a></li>
                        <li><a href="<?= base_url('admin/aplikasi') ?>" style="color: black;"><i class="fa fa-circle-o"></i> <span class="hover-pink">Tentang Aplikasi</span></a></li>
                        <!-- 
<li><a href="<?= base_url('admin/backupdatabase') ?>" style="color: black;"><i class="fa fa-circle-o"></i> <span class="hover-pink">Backup Database</span></a></li> 
-->
                        <li><a href="<?= base_url('admin/log') ?>" style="color: black;"><i class="fa fa-circle-o"></i> <span class="hover-pink">Log Status</span></a></li>
                    </ul>
                </li>
            <?php } ?>
            <li>
                <a href="<?= base_url('admin/profil') ?>" style="color: black;">
                    <i class="fa fa-user"></i> <span class="hover-pink">Profil</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('home/logout') ?>" class="tombol-yakin" data-isidata="Ingin keluar dari sistem ini?" style="color: black;">
                    <i class="fa fa-sign-out"></i> <span class="hover-pink">Sign Out</span>
                </a>
            </li>
        </ul>
    </section>
</aside>


<style>
.hover-pink {
    transition: color 0.3s ease;
}

.hover-pink:hover {
    color: pink;
}
</style>
