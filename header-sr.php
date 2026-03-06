    <div class="preloader">
      <div class="preloader-inner">
        <img
          src="assets/img/berg-membership-program-ig.svg"
          alt="logo"
          style="height: 300px"
        />
        <span class="loader"></span>
      </div>
    </div>
    <!--=================
    Mobile Menu
================= -->
    <div class="vs-menu-wrapper">
      <div class="vs-menu-area text-center">
        <div class="mobile-logo">
          <a href="index.php">
            <img
              src="assets/img/berg-membership-program-ig.svg"
              alt="BERG Membership"
              class="logo"
            />
          </a>
          <button class="vs-menu-toggle" aria-label="Close menu">
            <i class="fal fa-times"></i>
          </button>
        </div>

        <div class="vs-mobile-menu">
          <ul>
            <!-- Početna -->
            <li><a href="index-sr.php">Početna</a></li>

            <!-- Benefiti -->
            <li>
              <a href="benefiti.php" title="Benefiti">Benefiti</a>
            </li>

            <!-- Članstvo -->
            <li>
              <a href="clanstvo.php" title="Članstvo">Članstvo</a>
            </li>

            <!-- Kursevi -->
            <li>
              <a href="kursevi-dogadjaji.php" title="Kursevi">Kursevi</a>
            </li>

            <!-- Oprema -->
            <li class="menu-item-has-children">
              <a href="https://rentaplaninarskeopreme.rs/" title="Oprema">Oprema</a>
              <ul class="sub-menu">
                <li>
                  <a href="https://rentaplaninarskeopreme.rs/">Iznajmi opremu</a>
                </li>
                <li>
                  <a href="https://rentaplaninarskeopreme.rs/"
                    >Kompleti prve pomoći</a
                  >
                </li>
              </ul>
            </li>

            <!-- O nama -->
            <li>
              <a href="o-nama.php" title="O nama">O nama</a>
            </li>

            <!-- Kontakt -->
            <li>
              <a href="kontakt.php" title="Kontakt">Kontakt</a>
            </li>
            
            <?php if ($isUserLoggedIn): ?>
                <li><a href="moj-profil.php" title="Profile">Profil</a></li>
            <?php endif; ?>


            <!-- Prijava / Odjava -->
            <li>
              <a href="<?php echo h($authHref); ?>" title="<?php echo h($authText); ?>">
                <?php echo h($authText); ?>
              </a>
            </li>

            <!-- Jezik -->
            <li class="menu-item-has-children">
              <a href="#">
                <img
                  src="assets/img/internet-white.png"
                  alt="language"
                  style="height: 25px"
                />
              </a>
              <ul class="sub-menu">
                <li>
                  <a href="index.php">
                    <img
                      src="assets/img/berg-membership-program-serbian-flag.png"
                      alt="Serbian flag"
                      style="height: 15px"
                    />
                    &nbsp;Srpski
                  </a>
                </li>
                <li>
                  <a href="index.php">
                    <img
                      src="assets/img/berg-membership-program-uk-flag.webp"
                      alt="UK flag"
                      style="height: 15px"
                    />
                    &nbsp;English
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- =================
     Sticky Navbar
================= -->
    <div id="navbars" class="header-sticky navbars">
      <div class="container custom-container">
        <div class="row align-items-center flex-nowrap">
          <!-- LOGO -->
          <div class="col-auto d-flex align-items-center">
            <div class="logo">
              <a href="index.php">
                <img
                  src="assets/img/berg-membership-logo-white-2.png"
                  alt="BERG"
                  class="logo"
                />
              </a>
            </div>
          </div>

          <!-- MAIN NAV (DESKTOP) -->
          <div class="col d-none d-lg-flex justify-content-center">
            <nav class="main-menu menu-style1">
              <ul class="d-flex justify-content-center align-items-center">
                <!-- Početna -->
                <li><a href="index-sr.php">Početna</a></li>

                <!-- Benefiti -->
                <li>
                  <a href="benefiti.php" title="Benefiti">Benefiti</a>
                </li>

                <!-- Članstvo -->
                <li>
                  <a href="clanstvo.php" title="Članstvo">Članstvo</a>
                </li>

                <!-- Kursevi -->
                <li>
                  <a href="kursevi-dogadjaji.php" title="Kursevi">Kursevi</a>
                </li>

                <!-- Oprema -->
                <li class="menu-item-has-children">
                  <a href="https://rentaplaninarskeopreme.rs/" title="Oprema"
                    >Oprema</a
                  >
                  <ul class="sub-menu">
                    <li>
                      <a href="https://rentaplaninarskeopreme.rs/">Iznajmi opremu</a>
                    </li>
                    <li>
                      <a href="https://rentaplaninarskeopreme.rs/"
                        >Kompleti prve pomoći</a
                      >
                    </li>
                  </ul>
                </li>

                <!-- O nama -->
                <li>
                  <a href="o-nama.php" title="O nama">O nama</a>
                </li>

                <!-- Kontakt -->
                <li>
                  <a href="kontakt.php" title="Kontakt">Kontakt</a>
                </li>
                
                <?php if ($isUserLoggedIn): ?>
                    <li><a href="moj-profil.php" title="Profile">Profil</a></li>
                <?php endif; ?>


                <!-- Jezik -->
                <li class="menu-item-has-children">
                  <a href="#">
                    <img
                      src="assets/img/internet-white.png"
                      alt="language"
                      style="height: 25px"
                    />
                  </a>
                  <ul class="sub-menu">
                    <li>
                      <a href="index.php">
                        <img
                          src="assets/img/berg-membership-program-serbian-flag.png"
                          alt="Serbian flag"
                          style="height: 15px"
                        />
                        &nbsp;Srpski
                      </a>
                    </li>
                    <li>
                      <a href="index.php">
                        <img
                          src="assets/img/berg-membership-program-uk-flag.webp"
                          alt="UK flag"
                          style="height: 15px"
                        />
                        &nbsp;English
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>

          <!-- RIGHT: LOGIN + HAMBURGER (MOBILE) -->
          <div class="col-auto ms-auto">
            <div class="header-wc style2 d-flex align-items-center gap-3">
              <!-- DIVIDER (DESKTOP) -->
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="6"
                height="39"
                viewBox="0 0 6 39"
                fill="none"
                class="d-none d-lg-block"
              >
                <rect
                  x="5"
                  width="1"
                  height="39"
                  fill="#D9D9D9"
                  fill-opacity="0.7"
                ></rect>
                <rect
                  y="9"
                  width="1"
                  height="20"
                  fill="#D9D9D9"
                  fill-opacity="0.7"
                ></rect>
              </svg>

              <!-- PRIJAVA / ODJAVA (DESKTOP) -->
              <div class="logo d-none d-lg-block">
                <a href="<?php echo h($authHref); ?>" class="vs-btn style10">
                  <span><?php echo h($authText); ?></span>
                </a>
              </div>

              <!-- HAMBURGER (MOBILE ONLY) -->
              <button
                class="vs-menu-toggle d-inline-block d-lg-none"
                aria-label="Open menu"
              >
                <i class="fal fa-bars"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <main class="main">
      <!--================= Header Area =================-->
      <header class="vs-header layout1">
        <!-- Main Menu Area -->
        <div class="sticky-wrapper position-relative">
          <div class="header-top-wrap">
            <div class="container custom-container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="header-top">
                    <div
                      class="row g-3 justify-content-between align-items-center"
                    >
                      <div class="col-md-6 d-none d-md-block">
                        <div class="contact-info">
                          <ul class="custom-ul">
                            <li>
                              <i class="fa-solid fa-phone-volume"></i>
                              <a href="tel:+381691516160">(+381)69 151 6160</a>
                            </li>
                            <li>
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="4"
                                height="22"
                                viewBox="0 0 4 22"
                                fill="none"
                              >
                                <line
                                  x1="0.75"
                                  y1="2.774e-08"
                                  x2="0.749999"
                                  y2="21.6114"
                                  stroke="white"
                                  stroke-opacity="0.3"
                                  stroke-width="1.5"
                                />
                                <line
                                  x1="3.5"
                                  y1="3.92926"
                                  x2="3.5"
                                  y2="17.682"
                                  stroke="white"
                                  stroke-opacity="0.3"
                                />
                              </svg>
                            </li>
                            <li>
                              <i class="fa-solid fa-envelope"></i>
                              <a href="mailto:info@bergmembership.com"
                                >info@bergmembership.com</a
                              >
                            </li>
                          </ul>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="social-share">
                          <span class="info-share">Pratite nas:</span>
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="4"
                            height="22"
                            viewBox="0 0 4 22"
                            fill="none"
                          >
                            <line
                              x1="0.75"
                              y1="2.774e-08"
                              x2="0.749999"
                              y2="21.6114"
                              stroke="white"
                              stroke-opacity="0.3"
                              stroke-width="1.5"
                            />
                            <line
                              x1="3.5"
                              y1="3.92941"
                              x2="3.5"
                              y2="17.6821"
                              stroke="white"
                              stroke-opacity="0.3"
                            />
                          </svg>
                          <ul class="custom-ul">
                            <li>
                              <a
                                href="https://www.facebook.com/"
                                target="_blank"
                                rel="noopener"
                              >
                                <i class="fab fa-facebook-f"></i>
                              </a>
                            </li>
                            <li>
                              <a
                                href="https://www.linkedin.com/"
                                target="_blank"
                                rel="noopener"
                              >
                                <i class="fab fa-instagram"></i>
                              </a>
                            </li>
                            <li>
                              <a
                                href="https://www.linkedin.com/"
                                target="_blank"
                                rel="noopener"
                              >
                                <i class="fab fa-linkedin-in"></i>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <!-- row -->
                  </div>
                  <!-- header-top -->
                </div>
              </div>
            </div>
          </div>

          <div class="container custom-container">
            <div class="row justify-content-between align-items-center">
              <div class="col-xl-3 col-lg-auto">
                <div
                  class="header-logo d-flex justify-content-between align-items-center"
                >
                  <a href="index.php">
                    <img
                      src="assets/img/berg-membership-logo-white-2.png"
                      alt="BERG Membership"
                      class="logo"
                      style="height: 100px"
                    />
                  </a>

                  <div class="d-flex align-items-center gap-3">
                    <button
                      class="vs-menu-toggle d-inline-block d-lg-none"
                      aria-label="Open menu"
                    >
                      <i class="fal fa-bars"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div
                class="col-xl-9 col-lg-auto d-none d-lg-flex justify-content-end gap-md-4 gap-xl-5"
              >
                <nav class="main-menu menu-style1 d-none d-lg-block">
                  <ul class="d-flex justify-content-center align-items-center">
                    <!-- Početna -->
                    <li><a href="index-sr.php">Početna</a></li>

                    <!-- Benefiti -->
                    <li>
                      <a href="benefiti.php" title="Benefiti">Benefiti</a>
                    </li>

                    <!-- Članstvo -->
                    <li>
                      <a href="clanstvo.php" title="Članstvo">Članstvo</a>
                    </li>

                    <!-- Kursevi -->
                    <li>
                      <a href="kursevi-dogadjaji.php" title="Kursevi">Kursevi</a>
                    </li>

                    <!-- Oprema -->
                    <li class="menu-item-has-children">
                      <a
                        href="https://rentaplaninarskeopreme.rs/"
                        title="Oprema"
                        >Oprema</a
                      >
                      <ul class="sub-menu">
                        <li>
                          <a href="https://rentaplaninarskeopreme.rs/"
                            >Iznajmi opremu</a
                          >
                        </li>
                        <li>
                          <a href="https://rentaplaninarskeopreme.rs/"
                            >Kompleti prve pomoći</a
                          >
                        </li>
                      </ul>
                    </li>

                    <!-- O nama -->
                    <li>
                      <a href="o-nama.php" title="O nama">O nama</a>
                    </li>

                    <!-- Kontakt -->
                    <li>
                      <a href="kontakt.php" title="Kontakt">Kontakt</a>
                    </li>
                    
                    <?php if ($isUserLoggedIn): ?>
                        <li><a href="moj-profil.php" title="Profile">Profil</a></li>
                    <?php endif; ?>

                    <!-- Jezik -->
                    <li class="menu-item-has-children">
                      <a href="#">
                        <img
                          src="assets/img/internet-white.png"
                          alt="language"
                          style="height: 25px"
                        />
                      </a>
                      <ul class="sub-menu">
                        <li>
                          <a href="index.php">
                            <img
                              src="assets/img/berg-membership-program-serbian-flag.png"
                              alt="Serbian flag"
                              style="height: 15px"
                            />
                            &nbsp;Srpski
                          </a>
                        </li>
                        <li>
                          <a href="index.php">
                            <img
                              src="assets/img/berg-membership-program-uk-flag.webp"
                              alt="UK flag"
                              style="height: 15px"
                            />
                            &nbsp;English
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </nav>

                <div class="header-wc style2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="6"
                    height="39"
                    viewBox="0 0 6 39"
                    fill="none"
                  >
                    <rect
                      x="5"
                      width="1"
                      height="39"
                      fill="#D9D9D9"
                      fill-opacity="0.7"
                    />
                    <rect
                      y="9"
                      width="1"
                      height="20"
                      fill="#D9D9D9"
                      fill-opacity="0.7"
                    />
                  </svg>

                  <!-- PRIJAVA / ODJAVA -->
                  <div class="logo d-none d-sm-block">
                    <a href="<?php echo h($authHref); ?>" class="vs-btn style10">
                      <span><?php echo h($authText); ?></span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>