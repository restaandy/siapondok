<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="<?=base_url(); ?>">
                <img src="<?=base_url(); ?>assets/images/profile.jpg" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">Full Name</span>
            </div>
        </div>

        <ul class="nav" id="side-menu">
            <li class="">
                <a href="<?=base_url(); ?>">
                    <i class="pe pe-7s-home fa-fw"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="pe pe-7s-attention fa-fw"></i>
                    <span class="nav-label">Data Pemegang Saham</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                   <?php if($this->session->userdata('user_role')=="admin"){
                        ?>
                        <li class="">
                            <a href="<?=base_url().$this->session->userdata('user_role'); ?>/semua_saham">
                                <i class="pe pe-7s-note2 fa-fw"></i>
                                <span class="nav-label">Semua Pemegang Saham</span>
                            </a>
                        </li>
                        <?php
                    }else{
                        ?>
                        <li class="">
                            <a href="<?=base_url().$this->session->userdata('user_role'); ?>/semua_saham">
                                <i class="pe pe-7s-note2 fa-fw"></i>
                                <span class="nav-label">Lihat Pemegang Saham</span>
                            </a>
                        </li>
                        <?php
                    } ?>
                    
                </ul>
            </li>
            <?php if($this->session->userdata('user_role')=="admin"){
                        ?>
             <li>
                <a href="#">
                    <i class="pe pe-7s-attention fa-fw"></i>
                    <span class="nav-label">Laporan</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                   <li class="">
                         <a href="<?=base_url().$this->session->userdata('user_role'); ?>/semua_saham">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Tabel Road Map</span>
                         </a>
                    </li>
                    <li class="">
                         <a href="<?=base_url().$this->session->userdata('user_role'); ?>/semua_saham">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Tabel Realisasi per Periode RUPS</span>
                         </a>
                    </li>
                    <li class="">
                         <a href="<?=base_url().$this->session->userdata('user_role'); ?>/semua_saham">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Laporan Penerimaan Deviden</span>
                         </a>
                    </li>
                    
                </ul>
            </li>            
            <li class="">
                <a href="<?=base_url(); ?><?php echo $this->session->userdata('user_role'); ?>/realisasi">
                    <i class="pe pe-7s-home fa-fw"></i>
                    <span class="nav-label">Realisasi</span>
                </a>
            </li>
            <li class="">
                <a href="<?=base_url(); ?><?php echo $this->session->userdata('user_role'); ?>/periode">
                    <i class="pe pe-7s-home fa-fw"></i>
                    <span class="nav-label">Periode RUPS</span>
                </a>
            </li>
            <li class="">
                <a href="<?=base_url(); ?><?php echo $this->session->userdata('user_role'); ?>/sumber_modal">
                    <i class="pe pe-7s-home fa-fw"></i>
                    <span class="nav-label">Sumber Modal</span>
                </a>
            </li>
                        <?php
                    }else{
                        ?>
             <li class="">
                <a href="<?=base_url(); ?><?php echo $this->session->userdata('user_role'); ?>/simulasi">
                    <i class="pe pe-7s-home fa-fw"></i>
                    <span class="nav-label">Simulasi</span>
                </a>
            </li>           
                        <?php
                    } ?>
            
        </ul>
    </div>
</aside>