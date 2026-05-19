<?php error_reporting(0) ?>
<?php require 'session.php' ?>
  <div class="left side-menu">
            <div class="slimscroll-menu" id="remove-scroll">
                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="index.html" class="logo">
                        <span>
                            <img src="assets/images/smlogo.png" alt="logo" height="25">
                        </span>
                        <i>
                            <img src="assets/images/logo_sm.png" alt="" height="28">
                        </i>
                    </a>
                </div>
                <!-- User box -->
                <div class="user-box">
                    <div class="user-img">
                      <?php 
                        if (isset($_SESSION['img'])) {
                            ?>
                              <img src="img/user/<?php echo $_SESSION['img'] ?>" alt="user-img" title="Mat Helme" width="150" height="70px" style="border-radius: 50%"> 
                            <?php
                        }
                       ?>
                    </div>
                    <h5><a href="#">
                    <?php 
                        if (isset($_SESSION['name'])) {
                            echo $_SESSION['name'];
                        }
                     ?>
                         
                     </a> </h5>
                    <p class="text-muted">
                        <?php 
                        if (isset($_SESSION['role'])) {
                            if ($_SESSION['role'] == 2) {
                                echo 'Admin';
                            }
                            else{
                                echo 'User';
                            }
                        }
                     ?>
                    </p>
                </div>
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <ul class="metismenu" id="side-menu">
                        <!--<li class="menu-title">Navigation</li>-->
                        <li>
                            <a href="dashboard.php">
                                <i class="fi-air-play"></i><span class="badge badge-danger badge-pill float-right">7</span> <span> Dashboard </span>
                            </a>
                        </li>
                        <?php 
                            if ($_SESSION['role']==2) {
                                ?>

                             <li>
                            <a href="javascript: void(0);"><i class="fi-layers"></i> <span>Bagian Tampilan Depan</span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="banner.php">Tampilan Depan</a></li>
                                <li><a href="social.php">Sosial</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fi-mail"></i><span> Tentang </span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="about-me.php">Tentang Saya</a></li>
                                <li><a href="education.php">Tambahkan Pendidikan</a></li>
                                <li><a href="view-education.php">Lihat Pendidikan</a></li>
                            </ul>
                        </li> 
                        
                        <!-- ================== MENU TENTANG DETAIL BARU ================== -->
                        <li>
                            <a href="javascript: void(0);"><i class="fi-info"></i><span> Tentang Detail </span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="javascript: void(0);">Pengalaman & Keahlian <span class="menu-arrow"></span></a>
                                    <ul class="nav-third-level" aria-expanded="false">
                                        <li><a href="detail-about.php">Tambah Konten</a></li>
                                        <li><a href="view-detail-about.php">Tampilan Detail</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!-- ================== END MENU TENTANG DETAIL ================== -->

                        <li>
                            <a href="javascript: void(0);"><i class="fi-mail"></i><span>Tampilan Layanan</span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="services-title.php">Judul Layanan</a></li>
                                <li><a href="services.php">Tambahkan Layanan</a></li>
                                <li><a href="view-services.php">Lihat Layanan</a></li>
                            </ul>
                        </li>

                        <!-- ================== MENU DETAIL LAYANAN BARU ================== -->
                        <li>
                            <a href="javascript: void(0);"><i class="fi-list-alt"></i><span> Detail Layanan </span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="service_details.php">Tambah Detail Layanan</a></li>
                                <li><a href="service_details_view.php">Lihat Detail Layanan</a></li>
                            </ul>
                        </li>
                        <!-- ================== END MENU DETAIL LAYANAN ================== -->








                        <li>
                            <a href="#"><i class="fi-bar-graph-2"></i><span> Portfolio </span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="portfolio-edit.php">Tambahkan Item Portofolio</a></li>                           
                            </ul>
                        </li>
        

                        <li>
                            <a href="javascript: void(0);"><i class="fi-camera"></i><span> Dokumentasi Proyek </span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                           <li><a href="backend/quality-menu.php">Kelola Dokumentasi</a></li>
                           <li><a href="../index.php#quality" target="_blank">Lihat Tampilan Web</a></li>
                        </ul>
                    </li>



                        <li>
                            <a href="#"><i class="fi-bar-graph-2"></i><span> Kualitas </span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="backend/edit-quality-add.php">Tambahkan Item Kualitas</a></li>
                                <li><a href="view-quality.php">Tampilan Kualitas</a></li>
                              </ul>
                        </li>
                       

                         <?php
                            }
                         ?>
                     <?php 
                        require 'backend/db.php';
                            if ($_SESSION['role']==2) {
                                ?>
                            <li>
                            <a href="contact-section.php"><i class="fi-box"></i><span> Tampilan Kontak </span></a>
                            
                        </li>
                        <li>
                            <a href="javascript: void(0);"><i class="fi-paper"></i> <span> Komunikasi
                                
                                <?php 
                                    $sel ="SELECT COUNT(*) as total_unread FROM msg where status=1";
                                    $q= mysqli_query($db,$sel);
                                    $unread = mysqli_fetch_assoc($q);
                                    if ($unread['total_unread']>0) {
                                        ?>
                                        <span class="badge badge-danger badge-pill float-right"><?= $unread['total_unread']?></span>
                                    <?php 
                                    }
                                 ?>
                            </span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="view-msg.php">Pesan</a></li>
                                <li><a href="view-review.php">Lihat Pesan</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);"><i class="fi-location-2"></i> <span> Peta </span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="maps-google.html">Google Maps</a></li>
                                <li><a href="maps-vector.html">Vector Maps</a></li>
                                <li><a href="maps-mapael.html">Mapael Maps</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);"><i class="fi-paper-stack"></i><span> Pages </span> <span class="menu-arrow"></span></a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="page-starter.html">Starter Page</a></li>
                                <li><a href="page-login.html">Login</a></li>
                                <li><a href="page-register.html">Register</a></li>
                                <li><a href="page-logout.html">Logout</a></li>
                                <li><a href="page-recoverpw.html">Recover Password</a></li>
                                <li><a href="page-lock-screen.html">Lock Screen</a></li>
                                <li><a href="page-confirm-mail.html">Confirm Mail</a></li>
                                <li><a href="page-404.html">Error 404</a></li>
                                <li><a href="page-404-alt.html">Error 404-alt</a></li>
                                <li><a href="page-500.html">Error 500</a></li>
                            </ul>
                        </li>

                            <?php
                            }else{
                                ?>
                                   <li>
                            <a href="review.php"><i class="fi-bar-graph-2"></i><span> Beri Ulasan </span> <span class="menu-arrow"></span></a>
                        </li>

                        <li>
                            <a href="review.php"><i class="fi-bar-graph-2"></i><span> Kirim Pesan</span></a>
                        </li>
                        <li>
                            <a href="review.php"><i class="fi-bar-graph-2"></i><span>Akun saya</span></a>
                        </li>
                        <li>
                            <a href="review.php"><i class="fi-bar-graph-2"></i><span>Pengaturan</span></a>
                        </li>
                        <li>
                            <a href="review.php"><i class="fi-bar-graph-2"></i><span>Keluar</span></a>
                        </li>
                                <?php
                            }
                         ?>
                    </ul>
                </div>
                <!-- Sidebar -->
                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -left -->
        </div>