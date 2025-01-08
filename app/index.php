<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Health Trak</title>


  <!-- Favicons -->
  <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<link rel="manifest" href="/site.webmanifest" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
 
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@healthtrack.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+254 798 798 543</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="../views/dashboard.php" class="logo d-flex align-items-center me-auto">
          <img src="assets/img/logo.png" alt="" height="200" width="60">
          <h1 class="sitename">Healthtrak</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="#hero" class="active">Home<br></a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#departments">Departments</a></li>
            <li><a href="#doctors">Doctors</a></li>
            <li><a href="addition1.php">Fill in your form</a></li>
              
            <li class="dropdown"><a href="#"><span>Quick Links</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
    <ul>
    <li><a href="../views/dashboard.php">Dashboard</a></li>
    <li><a href="../views/appointments.php">Appointments</a></li>
    <li><a href="../views/prescriptions.php">Prescriptions</a></li>
    <li><a href="../views/records.php">My Records</a></li>
              </ul>
            </li>
                
            <li><a href="#contact">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

        </nav>

        <a class="cta-btn d-none d-sm-block" href="#appointment">Make an Appointment</a>

        <?php include '../config/log-state.php'; ?>

      </div>
    </div>
<ul>

  </header>

  <main class="main">

    <section id="hero" class="hero section light-background">
      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          <h2>WELCOME TO HEALTHTRAK</h2>
        </div>
        <!-- End Welcome -->

        <div class="content row gy-4">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
              <h3>Why Choose Healthtrak?</h3>
              <p>
                  It's reliable,
                  efficient 
                  and 
                  personalized helthcare tracking ,
                  ensuring your wellbeing is 
                  always our 
                  top priority
              </p>
              <div class="text-center">
                <a href="#about" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div><!-- End Why Box -->

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="d-flex flex-column justify-content-center">
              <div class="row gy-4">

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                      <i class="bi bi-clipboard-data"></i>
                      <h4>Project Planning and Management</h4>
                      <p>Efficiently plan and manage your project tasks with our comprehensive tools designed to enhance productivity and collaboration.</p>
                  </div>
              </div><!-- End Icon Box -->
              
              <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                      <i class="bi bi-gem"></i>
                      <h4>Quality Assurance and Testing</h4>
                      <p>Ensure the highest quality of your deliverables through rigorous testing and validation processes, tailored to meet your project’s needs.</p>
                  </div>
              </div><!-- End Icon Box -->
              
              <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                      <i class="bi bi-inboxes"></i>
                      <h4>Resource Allocation and Tracking</h4>
                      <p>Optimize the use of resources and track progress with real-time updates and detailed reports to keep your project on schedule and within budget.</p>
                  </div>
              </div><!-- End Icon Box -->
              

              </div>
            </div>
          </div>
        </div><!-- End  Content-->

      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
            <a href="" class="glightbox pulsating-play-btn"></a>
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3>About Us</h3>
<p>
  We are dedicated to delivering innovative solutions and exceptional service. Our team is driven by passion and commitment to excellence, ensuring that we meet and exceed our clients' expectations.
</p>
<ul>
  <li>
    <i class="fa-solid fa-vial-circle-check"></i>
    <div>
      <h5>Reliable and Efficient Solutions</h5>
      <p>We provide reliable and efficient solutions tailored to meet your specific needs and enhance your business operations.</p>
    </div>
  </li>
  <li>
    <i class="fa-solid fa-pump-medical"></i>
    <div>
      <h5>Expertise and Innovation</h5>
      <p>Our team leverages their expertise and innovative approach to deliver cutting-edge solutions that drive success.</p>
    </div>
  </li>
  <li>
    <i class="fa-solid fa-heart-circle-xmark"></i>
    <div>
      <h5>Patient-Centric Approach</h5>
      <p>We prioritize our clients' needs, providing personalized support and ensuring their satisfaction at every step.</p>
    </div>
  </li>
</ul>
</div>

</div>

</div>


    </section><!-- /About Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-solid fa-user-doctor"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="85" data-purecounter-duration="1" class="purecounter"></span>
              <p>Doctors</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-regular fa-hospital"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="18" data-purecounter-duration="1" class="purecounter"></span>
              <p>Departments</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-flask"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>
              <p>Research Labs</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-award"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1" class="purecounter"></span>
              <p>Awards</p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item  position-relative">
              <div class="icon">
                <i class="fas fa-heartbeat"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Our Vision</h3>
              </a>
              <p>We strive to innovate and excel in our field, ensuring our solutions not only meet but exceed industry standards. Our goal is to deliver exceptional value and make a positive impact through our services.</p>
            </div>

          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-pills"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Innovative Solutions</h3>
              </a>
              <p>We provide cutting-edge solutions tailored to meet the unique needs of our clients. Our team is dedicated to delivering exceptional service and driving success through innovation.</p>
            </div>
          </div><!-- End Service Item -->


          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-hospital-user"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Transformative Solutions</h3>
              </a>
              <p>Our cutting-edge solutions are crafted to tackle your unique challenges and drive impactful results. We harness the power of innovation and integrity to consistently exceed expectations and deliver exceptional value.</p>
            </div>

          </div><!-- End Service Item -->
  <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-wheelchair"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Dynamic Innovations</h3>
              </a>
              <p>Our forward-thinking solutions cater to the diverse needs of our clients, guaranteeing top-notch efficiency and remarkable outcomes. Our unwavering commitment to progress drives success in all our endeavors.</p>
              <a href="#" class="stretched-link"></a>
            </div>

          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-notes-medical"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Architectural Excellence</h3>
              </a>
              <p>We specialize in creating innovative architectural designs that blend functionality and aesthetics. Our commitment to excellence ensures each project meets the highest standards of quality and integrity.</p>

              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section>

    <!-- Appointment Section -->
    <section id="appointment" class="appointment section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Appointment</h2>
        <p>Book your appointments with ease and convenience. Our streamlined process ensures you get the service you need at a time that works best for you.</p>
      </div><!-- End Section Title -->


      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <form action="forms/appointments.php" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-4 form-group">
              <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Your First Name" required="">
            </div>
            <div class="col-md-4 form-group">
              <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Your Last Name" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
              <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
            <legend class="col-form-label pt-0">-Gender-</legend>
            <label>
            <input type="radio"name="gender" name name="gender" value="male">
            Male
            </label>
            <label>
            <input type="radio"name="gender" name name="gender" value="female">
             Female
            </label>
            <label>
            <input type="radio"name="gender" name name="gender" value="other">
            Other
          </label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 form-group mt-3">
              <input type="datetime-local" name="date" class="form-control datepicker" id="date" placeholder="Appointment Date" required="">
            </div>
            <div class="col-md-4 form-group mt-3">
              <select name="department" id="department" class="form-select" required="">
                <option value="">Select Department</option>
                <option value="Department 1">General Medicine</option>
                <option value="Department 2">Specialist Consultation</option>
                <option value="Department 3">Mental Health & Counseling</option>
              </select>
            </div>
            <div class="col-md-4 form-group mt-3">
              <select name="doctor" id="doctor" class="form-select" required="">
                <option value="">Select Doctor</option>
                <option value="Doctor 1">Dr. Macharia</option>
                <option value="Doctor 2">Dr. Njoki</option>
                <option value="Doctor 3">Dr. Mwangi</option>
              </select>
            </div>
          </div>

          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Message (Optional)"></textarea>
          </div>
          <div class="mt-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your appointment request has been sent successfully. Thank you!</div>
            <div class="text-center"><button type="submit">Make an Appointment</button></div>
          </div>
        </form>

      </div>

    </section><!-- /Appointment Section -->

    <!-- Departments Section -->
    <section id="departments" class="departments section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Departments</h2>
        <p>Explore our diverse departments, each dedicated to providing top-notch services and innovative solutions tailored to meet your needs.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" href="#departments-tab-1">Cardiology</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-2">Neurology</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-3">Hepatology</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-4">Pediatrics</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-5">Eye Care</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9 mt-4 mt-lg-0">
            <div class="tab-content">
              <div class="tab-pane active show" id="departments-tab-1">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Cardiology</h3>
                    <p class="fst-italic">Dedicated to the diagnosis and treatment of heart conditions with cutting-edge technology and expert care.</p>
                    <p>Our cardiology department offers comprehensive services for the prevention, diagnosis, and treatment of heart diseases. We provide personalized care, leveraging the latest advancements in medical technology to ensure the best possible outcomes for our patients.</p>
                </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-1.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-2">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Comprehensive Solutions</h3>
                    <p class="fst-italic">We offer a wide range of services designed to meet your unique needs and drive success in every project.</p>
                    <p>Our team is dedicated to providing innovative solutions that address complex challenges. We leverage our expertise and cutting-edge technology to deliver exceptional results, ensuring your satisfaction and success.</p>
                </div>                
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-2.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-3">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Seamless Integration Services</h3>
                    <p class="fst-italic">We specialize in providing seamless integration services to ensure all components of your project work together flawlessly. Our expertise ensures optimal performance and reliability.</p>
                    <p>Our dedicated team offers customized integration solutions, addressing the unique needs and complexities of your project. We work diligently to ensure compatibility and smooth functionality, delivering results that exceed expectations.</p>
                </div>
                
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-3.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-4">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Exceptional Project Management</h3>
                    <p class="fst-italic">We excel in managing projects with precision and dedication, ensuring all aspects are handled efficiently and effectively.</p>
                    <p>Our expertise in project management allows us to navigate challenges smoothly, delivering successful outcomes every time. We prioritize clear communication, strategic planning, and meticulous execution to exceed client expectations.</p>
                </div>                
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-4.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-5">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Innovative Technological Solutions</h3>
                    <p class="fst-italic">We are dedicated to providing state-of-the-art technology that meets the evolving demands of our clients.</p>
                    <p>Our comprehensive approach ensures we deliver solutions that enhance efficiency and drive progress. We prioritize continuous improvement and innovation, addressing challenges effectively and ensuring optimal performance and satisfaction.</p>
                </div>
                
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="assets/img/departments-5.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
   </section> <!--Departments Section  -->
    <!-- Doctors Section -->
   <section id="doctors" class="doctors section">

      <!-- Section Title  -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Doctors</h2>
  
        <p>We are dedicated to delivering high-quality solutions that cater to your specific needs, ensuring exceptional results and satisfaction.</p>

       </div><!-- End Section Title -->

       <div class="container"> 

        <div class="row gy-4">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="assets/img/doctors/newton.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Newton Irungu </h4>
                <span>Chief Medical Officer</span>
                <p>Leading our medical team with expertise and dedication, ensuring the highest standards of patient care and medical excellence.</p>

                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
          </div> <!--End Team Member -->

         <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="assets/img/doctors/caleb.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Caleb Muriithi</h4>
                <span>Surgical doctor</span>
                <p>Overcoming challenges leads to personal growth and success.</p>

                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
           </div> <!--End Team Member -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="assets/img/doctors/mogaka.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Peter Mogaka</h4>
                <span>Cardiology</span>
                <p>We prioritize simplicity and integrity in our services, ensuring that we address your needs effectively and efficiently.</p>

                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="assets/img/doctors/washington.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Washington</h4>
                <span>Neurosurgeon</span>
                <p>Embrace learning opportunities to enhance skills and expertise.</p>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section> <!--Doctors Section-->

    <!-- Faq Section -->
    <section id="faq" class="faq section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
        <p>Find answers to common questions about our services and solutions, helping you make informed decisions.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>What services do you offer?</h3>
                <div class="faq-content">
                  <p>We offer a wide range of services including project management, technical consulting, and customized solutions to meet your unique needs.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>How can I get started with your services?</h3>
                <div class="faq-content">
                  <p>To get started, you can contact us through our website or give us a call. Our team will guide you through the initial consultation and onboarding process.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Do you provide customer support?</h3>
                <div class="faq-content">
                  <p>Yes, we offer 24/7 customer support to ensure all your queries and issues are addressed promptly and effectively.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>What sets you apart from other service providers?</h3>
                <div class="faq-content">
                  <p>Our commitment to innovation, quality, and customer satisfaction sets us apart. We tailor our solutions to fit your specific needs, ensuring the best outcomes.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>How can I provide feedback on your services?</h3>
                <div class="faq-content">
                  <p>We welcome your feedback! You can share your thoughts and suggestions through our feedback form on the website or by contacting our support team directly.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->


              <div class="faq-item">
                <h3>What should I do if I encounter an issue with your service?</h3>
                <div class="faq-content">
                    <p>If you encounter any issues, please contact our support team. We are here to help and will work diligently to resolve your concerns promptly and effectively.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->
            

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->

   <!-- Testimonials Section -->
<section id="testimonials" class="testimonials section">

  <div class="container">

    <div class="row align-items-center">

      <div class="col-lg-5 info" data-aos="fade-up" data-aos-delay="100">
        <h3>Testimonials</h3>
        <p>
          Hear from our satisfied clients who have experienced the transformative power of our services. Their stories inspire us to continue delivering excellence every day.
        </p>
      </div>

      <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="d-flex">
                  <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img flex-shrink-0" alt="">
                  <div>
                    <h3>Saul Goodman</h3>
                    <h4>CEO &amp; Founder</h4>
                    <div class="stars">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                  </div>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>The professionalism and expertise of the team are unmatched. They transformed our vision into reality, exceeding all expectations. Highly recommended!</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="d-flex">
                  <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img flex-shrink-0" alt="">
                  <div>
                    <h3>Sara Wilsson</h3>
                    <h4>Designer</h4>
                    <div class="stars">
                      <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                  </div>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Working with this team was a delight. Their creativity and dedication resulted in a stunning design that truly represents our brand. I couldn’t be happier!</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                  <div class="d-flex">
                    <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img flex-shrink-0" alt="">
                    <div>
                      <h3>Jena Karlis</h3>
                      <h4>Store Owner</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                    </div>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    <span>Running my store was never easier thanks to the amazing support and tools provided by this service. Their dedication to excellence is evident in every detail.</span>
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                  <div class="d-flex">
                    <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img flex-shrink-0" alt="">
                    <div>
                      <h3>Matt Brandon</h3>
                      <h4>Freelancer</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                    </div>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    <span>The flexibility and features offered have truly transformed the way I manage my freelance work. A game-changer for independent professionals like me!</span>
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                  <div class="d-flex">
                    <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img flex-shrink-0" alt="">
                    <div>
                      <h3>John Larson</h3>
                      <h4>Entrepreneur</h4>
                      <div class="stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                      </div>
                    </div>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    <span>This team’s commitment to innovation and customer satisfaction has propelled my business to new heights. I’m incredibly grateful for their support and expertise.</span>
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

            </div>
            <div class="swiper-pagination"></div>
          </div>

        </div>

      </div>
      </div>

    </section><!-- /Testimonials Section -->
    <!-- Contact Section -->
    <section id="contact" class="contact section">

     <!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Contact</h2>
  <p>Get in touch with us to learn more, ask questions, or share your thoughts. We're here to help!</p>
</div><!-- End Section Title -->

      <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
      <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25568.377006612463!2d36.95385204686194!3d-0.39554889986225483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1828677a4955ff13%3A0x7ae4dae9615396a6!2sDEDAN%20KIMATHI%20UNIVERSITY%20OF%20TECHNOLOGY!5e0!3m2!1sen!2ske!4v1734629046568!5m2!1sen!2ske" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div><!-- End Google Maps -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Location</h3>
                <p>Kiganjo/Mathari, B5, Nyeri</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+254 746 422 150 /<br> +254 713 440 774</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>info@HealthTrak.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="forms/process_contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">HealthTrak</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Along Nyeri Mweiga road</p>
            <p>Mweiga, NYERI</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+254 746 422 150/ +254 713 440 774</span></p>
            <p><strong>Email:</strong> <span>info@HealthTrak.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <?php echo date('Y'); ?> <span>DeKUT-CS-GRP-11 ||</span> <strong class="px-1 sitename">HealtTrak</strong> <span>|| All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->

      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>