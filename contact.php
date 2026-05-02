<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - KidiCode</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Fredoka+One&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg: #F8F4EC;
      --pink-light: #FF8FB7;
      --pink-dark: #E83C91;
      --purple-dark: #43334C;
    }

    body {
    font-family: 'Segoe UI', sans-serif;
      background-color: var(--bg);
      color: var(--purple-dark);
    }

    h1, h2, h3 {
  font-family: 'Segoe UI', sans-serif;
      color: var(--purple-dark);
    }

    .contact-hero {
      background: linear-gradient(135deg, rgba(255,143,183,0.70), rgba(232,60,145,0.70)),
      url('img/bg.png');
      background-size: cover;
      padding: 100px 0;
      text-align: center;
      color: white;
    }

    .contact-card {
      background: white;
      border-radius: 20px;
      padding: 35px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      transition: 0.3s;
    }

    .contact-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }

    .contact-info-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: var(--pink-light);
      color: white;
      font-size: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }

    .form-control {
      border-radius: 12px;
      border: 1px solid #ddd;
      height: 50px;
      padding-left: 15px;
    }

    textarea.form-control {
      height: auto;
      padding-top: 15px;
    }

    .form-control:focus {
      border-color: var(--pink-dark);
      box-shadow: 0 0 0 0.25rem rgba(232,60,145,0.2);
    }

    .btn-send {
      background: var(--pink-dark);
      border-radius: 50px;
      padding: 12px 30px;
      border: none;
      color: white;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-send:hover {
      background: var(--pink-light);
      transform: translateY(-3px);
    }

    .accordion-button:not(.collapsed) {
      background: var(--pink-light);
      color: white;
    }

    .section-box {
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      margin-top: 50px;
    }

    .values-box {
      text-align: center;
      padding: 20px;
      border-radius: 15px;
      background: var(--pink-light);
      color: white;
      margin-bottom: 20px;
    }
    
  </style>
</head>

<body>

<?php include 'navbar.php'; ?>

<section class="contact-hero">
  <div class="container">
    <h1>Contact KidiCode</h1>
    <p style="max-width:700px;margin:auto;">We're always here to help! Reach out anytime — learning should always feel fun and easy.</p>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row g-4">

      <div class="col-lg-5">
        <div class="contact-card">
          <h3>Get in Touch</h3>
          <p class="text-muted">We're happy to answer all your questions</p>

          <div class="contact-info mt-4">
            <div class="d-flex mb-3">
              <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
              <div><h5>Location</h5><p>KidiCode HQ, Tech Learning Lane</p></div>
            </div>

            <div class="d-flex mb-3">
              <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
              <div><h5>Phone</h5><a style="color:var(--pink-dark);">+92 300 1234567</a></div>
            </div>

            <div class="d-flex mb-3">
              <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
              <div><h5>Email</h5><a style="color:var(--pink-dark);">support@kidicode.com</a></div>
            </div>
          </div>

          <div class="social-links mt-4">
            <a><i class="fab fa-facebook-f me-3"></i></a>
            <a><i class="fab fa-instagram me-3"></i></a>
            <a><i class="fab fa-youtube me-3"></i></a>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="contact-card">
          <h3>Send Us a Message</h3>
          <p class="text-muted">Fill out the form and we’ll reply quickly</p>

          <form>
            <div class="row">
              <div class="col-md-6"><input class="form-control" placeholder="Your Name"></div>
              <div class="col-md-6"><input class="form-control" placeholder="Your Email"></div>
            </div>

            <input class="form-control" placeholder="Subject">
            <textarea class="form-control" placeholder="Message"></textarea>

            <button class="btn-send mt-3"><i class="fas fa-paper-plane me-2"></i>Send Message</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="section-box py-5" style="background:#FFE8E8;">
  <div class="container">

    <div class="row align-items-center g-5">

      <!-- LHS IMAGE -->
      <div class="col-lg-5 text-center">
        <img src="img/pic.png" class="img-fluid rounded-4 shadow"
             style="max-width:650px;" alt="Our Mission & Vision">
      </div>

      <!-- RHS CONTENT -->
      <div class="col-lg-7">

        <h2 class="fw-bold mb-3" style="color:#850E35;">Our Mission</h2>
        <p class="mb-4">
          Our mission is to empower the next generation of learners by nurturing
          creativity, logical thinking, and problem-solving skills through
          structured, interactive, and engaging digital education.
          We focus on hands-on learning, real-world projects, and continuous
          progress tracking so every student grows with confidence.
        </p>

        <h2 class="fw-bold mb-3" style="color:#850E35;">Our Vision</h2>
        <p class="mb-4">
          Our vision is to make high-quality coding and digital skills education
          accessible, enjoyable, and impactful for children and teens worldwide.
          We aim to build a future-ready learning ecosystem where students,
          parents, and instructors collaborate seamlessly through technology,
          innovation, and personalized learning paths.
        </p>

        <ul class="list-unstyled">
          <li class="mb-2">
            <i class="fa fa-check-circle me-2" style="color:#EE6983;"></i>
            Industry-aligned curriculum with beginner to advanced pathways
          </li>
          <li class="mb-2">
            <i class="fa fa-check-circle me-2" style="color:#EE6983;"></i>
            Gamified learning with quizzes, projects, badges & certificates
          </li>
          <li class="mb-2">
            <i class="fa fa-check-circle me-2" style="color:#EE6983;"></i>
            Strong parent involvement through progress reports & dashboards
          </li>
        </ul>

      </div>

    </div>

  </div>
</section>


<section class="section-box">
  <div class="container">
    <h2 class="text-center mb-4">Our Values</h2>

    <div class="row">
      <div class="col-md-4"><div class="values-box"><h4>Creativity</h4></div></div>
      <div class="col-md-4"><div class="values-box"><h4>Innovation</h4></div></div>
      <div class="col-md-4"><div class="values-box"><h4>Learning</h4></div></div>
      <div class="col-md-4"><div class="values-box"><h4>Confidence</h4></div></div>
      <div class="col-md-4"><div class="values-box"><h4>Fun</h4></div></div>
      <div class="col-md-4"><div class="values-box"><h4>Growth</h4></div></div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Frequently Asked Questions</h2>

    <div class="accordion" id="faq">

      <!-- 10+ FAQs -->
      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f1">How does KidiCode work?</button></h2><div id="f1" class="accordion-collapse collapse"><div class="accordion-body">Kids learn coding through games, puzzles, lessons and challenges.</div></div></div>

      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f2">Do you offer trial classes?</button></h2><div id="f2" class="accordion-collapse collapse"><div class="accordion-body">Yes! We offer a 1-day trial for every new learner.</div></div></div>

      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f3">What age group is KidiCode for?</button></h2><div id="f3" class="accordion-collapse collapse"><div class="accordion-body">Suitable for ages 5 to 16.</div></div></div>

      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f4">Are classes online or physical?</button></h2><div id="f4" class="accordion-collapse collapse"><div class="accordion-body">We offer both online and onsite programs.</div></div></div>

      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f5">Do you provide certificates?</button></h2><div id="f5" class="accordion-collapse collapse"><div class="accordion-body">Yes, certificates are awarded at completion.</div></div></div>

      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f6">How do I enroll?</button></h2><div id="f6" class="accordion-collapse collapse"><div class="accordion-body">Simply contact us or register through our website.</div></div></div>

      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f7">Is coding difficult for kids?</button></h2><div id="f7" class="accordion-collapse collapse"><div class="accordion-body">Not at all! We teach through play-based learning.</div></div></div>

      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f8">Do you offer group discounts?</button></h2><div id="f8" class="accordion-collapse collapse"><div class="accordion-body">Yes, special packages are available.</div></div></div>

      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f9">What coding languages do you teach?</button></h2><div id="f9" class="accordion-collapse collapse"><div class="accordion-body">We teach Scratch, Python, HTML, AI concepts and more.</div></div></div>

      <div class="accordion-item mb-2"><h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#f10">Do parents receive updates?</button></h2><div id="f10" class="accordion-collapse collapse"><div class="accordion-body">Yes, parents receive progress reports.</div></div></div>

    </div>
  </div>
</section>

<?php include 'footer.php' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
