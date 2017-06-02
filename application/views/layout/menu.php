<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="<?=base_url(); ?>">
                <img src="<?=base_url(); ?>assets/images/profile.jpg" class="img-circle m-b" alt="logo">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase"><?php echo $this->session->userdata("sebagai"); ?></span>
            </div>
        </div>

        <ul class="nav" id="side-menu">
            <li class="">
                <a href="<?=base_url(); ?>">
                    <i class="pe pe-7s-home fa-fw"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <?php  
            if($this->session->userdata("sebagai")=="admin"){
              ?>
            <li>
                <a href="#">
                    <i class="pe pe-7s-attention fa-fw"></i>
                    <span class="nav-label">Administrator</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                   <li class="">
                        <a href="<?=base_url().$this->session->userdata('sebagai'); ?>/tahunajaran">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Tahun Ajaran</span>
                        </a>
                   </li>
                   <li class="">
                        <a href="<?=base_url().$this->session->userdata('sebagai'); ?>/kelas">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Kelas</span>
                        </a>
                   </li>
                   <li class="">
                        <a href="<?=base_url().$this->session->userdata('sebagai'); ?>/mapel">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Mapel</span>
                        </a>
                   </li>
                   <li class="">
                        <a href="<?=base_url().$this->session->userdata('sebagai'); ?>/kompetensi_dasar">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Kompetensi Dasar</span>
                        </a>
                   </li>
                   <li class="">
                        <a href="<?=base_url().$this->session->userdata('sebagai'); ?>/jadwal">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">jadwal</span>
                        </a>
                   </li> 
                </ul>
            </li>
            <?php  
            }else if($this->session->userdata("sebagai")=="petugas"){
              ?>
            <li>
                <a href="#">
                    <i class="pe pe-7s-attention fa-fw"></i>
                    <span class="nav-label">Petugas</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                   <li class="">
                        <a href="<?=base_url().$this->session->userdata('sebagai'); ?>/tahunajaran">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Tahun Ajaran</span>
                        </a>
                   </li>
                </ul>
            </li>            
              <?php  
            }else if($this->session->userdata("sebagai")=="guru"){
              ?>
            <li>
                <a href="#">
                    <i class="pe pe-7s-attention fa-fw"></i>
                    <span class="nav-label">Guru</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                   <li class="">
                        <a href="<?=base_url().$this->session->userdata('sebagai'); ?>/tahunajaran">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Tahun Ajaran</span>
                        </a>
                   </li>
                </ul>
            </li> 
              <?php  
            }else if($this->session->userdata("sebagai")=="siswa"){
              ?>
            <li>
                <a href="#">
                    <i class="pe pe-7s-attention fa-fw"></i>
                    <span class="nav-label">Siswa</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                   <li class="">
                        <a href="<?=base_url().$this->session->userdata('sebagai'); ?>/tahunajaran">
                            <i class="pe pe-7s-note2 fa-fw"></i>
                            <span class="nav-label">Tahun Ajaran</span>
                        </a>
                   </li>
                </ul>
            </li>  
              <?php  
            }
            ?>
        </ul>
    </div>
</aside>