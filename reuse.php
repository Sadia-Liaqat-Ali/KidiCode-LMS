<?php
session_start();
include 'db_connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>LMS Portal | Learn • Grow • Achieve</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body{
      font-family: 'Segoe UI', sans-serif;
      background:#FCF5EE;
      margin:0;
      padding:0;
    }

    /* Hero */
    .hero{
      background:#FFC4C4;
      padding:90px 0;
      color:#850E35;
    }
    .hero h1{
      font-weight:800;
      font-size:3.2rem;
    }
    .hero p{
      font-size:1.1rem;
    }
    .btn-main{
      background:#850E35;
      color:#fff;
      border-radius:40px;
      padding:12px 30px;
      font-weight:600;
    }
    .btn-main:hover{
      background:#EE6983;
      color:#fff;
    }

    /* Section Title */
    .section-title{
      color:#850E35;
      font-weight:800;
      margin-bottom:40px;
      text-align:center;
    }

    /* Feature Box */
    .feature-box{
      background:#FFF;
      border-radius:12px;
      padding:25px;
      box-shadow:0 4px 10px rgba(0,0,0,0.08);
      text-align:center;
      transition:.3s;
    }
    .feature-box:hover{
      transform:translateY(-6px);
      background:#FFE8E8;
    }
    .feature-box i{
      font-size:2.5rem;
      color:#EE6983;
      margin-bottom:15px;
    }

    /* Portfolio / Blog Highlight */
    .portfolio{
      background:#FFE8E8;
      padding:60px 0;
    }
    .blog-card{
      background:#FFF;
      border-radius:12px;
      padding:20px;
      box-shadow:0 4px 10px rgba(0,0,0,0.05);
      transition:.3s;
    }
    .blog-card:hover{
      transform:translateY(-6px);
    }

    /* Footer */
    .footer{
      background:#850E35;
      color:#FCF5EE;
      padding:40px 0;
    }
    .footer a{
      color:#FFC4C4;
      text-decoration:none;
    }
    .footer a:hover{
      text-decoration:underline;
    }
  </style>
</head>

<body>

<?php include 'navbar.php'; ?>

<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center justify-content-between">

      <div class="col-lg-6 mb-4">
        <h1>Smart LMS for Students, Parents & Instructors</h1>
        <p>Track progress, access interactive lessons, manage courses, attempt quizzes, and explore training programs — all in one intelligent system.</p>
        <a href="#courses" class="btn btn-main">
          <i class="fa fa-book-open me-2"></i> Explore Courses
        </a>
      </div>

      <div class="col-lg-5 text-center">
        <img src="img/bg.png" class="img-fluid" style="max-width:500px;">
      </div>

    </div>
  </div>
</section>

<!-- FEATURES (User Roles & LMS Tools) -->
<section class="py-5">
  <div class="container">
    <h2 class="section-title">Platform Features</h2>

    <div class="row g-4">

      <div class="col-md-3">
        <div class="feature-box">
          <i class="fa fa-user-shield"></i>
          <h5 class="mb-2">Admin Panel</h5>
          <p>Manage users, content, analytics, and subscriptions.</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="feature-box">
          <i class="fa fa-chalkboard-teacher"></i>
          <h5 class="mb-2">Instructor Dashboard</h5>
          <p>Upload courses, monitor student progress, assignments & scores.</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="feature-box">
          <i class="fa fa-graduation-cap"></i>
          <h5 class="mb-2">Student Dashboard</h5>
          <p>Access lessons, attempt quizzes, earn badges & certificates.</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="feature-box">
          <i class="fa fa-users"></i>
          <h5 class="mb-2">Parent Portal</h5>
          <p>Track your child’s performance, activities, and reports.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- INTERACTIVE LEARNING -->
<section class="py-5" id="courses">
  <div class="container">
    <h2 class="section-title">Interactive Learning Tools</h2>

    <div class="row g-4">

      <div class="col-md-4">
        <div class="feature-box">
          <i class="fa fa-layer-group"></i>
          <h5>Course Creation</h5>
          <p>Create courses with difficulty levels including Beginner to Advanced.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-box">
          <i class="fa fa-question-circle"></i>
          <h5>Quizzes & Challenges</h5>
          <p>MCQs, coding challenges, assignments, and subjective tests.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-box">
          <i class="fa fa-trophy"></i>
          <h5>Gamification</h5>
          <p>Earn badges, points, achievements, and appear on leaderboards.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-box mt-4">
          <i class="fa fa-code-branch"></i>
          <h5>SCORM / xAPI</h5>
          <p>Track learning progress with modern learning standards.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-box mt-4">
          <i class="fa fa-credit-card"></i>
          <h5>Payments & Subscriptions</h5>
          <p>Free & paid courses + monthly or yearly subscription access.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-box mt-4">
          <i class="fa fa-wallet"></i>
          <h5>Secure Gateway</h5>
          <p>Integrated online payment system for fast checkout.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ================= COURSES SECTION ================= -->
<section class="py-5" id="popular-courses" style="background:#FFE8E8;">
  <div class="container">
    <h2 class="section-title">Explore Our Courses</h2>
    <p class="text-center mb-5">
      Carefully designed courses for kids & teens — from basics to advanced,
      taught by verified instructors with real progress tracking.
    </p>

    <div class="row g-4">
      <?php
      // DB connection assumed already included
      $courseQry = mysqli_query($conn,"SELECT * FROM courses ORDER BY created_at DESC LIMIT 6");
      while($c = mysqli_fetch_assoc($courseQry)){
      ?>
      <div class="col-md-4">
        <div class="feature-box text-start h-100">
          <img src="<?php echo $c['course_image']; ?>" class="img-fluid rounded mb-3" style="height:180px;object-fit:cover;">
          <span class="badge bg-<?php echo ($c['course_type']=='Premium')?'danger':'success'; ?>">
            <?php echo $c['course_type']; ?>
          </span>
          <h5 class="mt-3"><?php echo $c['course_title']; ?></h5>
          <p class="small text-muted"><?php echo $c['course_description']; ?></p>
          <ul class="small">
            <li>Age Group: <?php echo $c['age_group']; ?></li>
            <li>Quizzes & Assignments</li>
            <li>Gamified Learning</li>
          </ul>
          <a href="course-details.php?id=<?php echo $c['id']; ?>" class="btn btn-main btn-sm w-100">
            View Course
          </a>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</section>

<!-- ================= WHY CHOOSE US ================= -->
<section class="py-5">
  <div class="container">
    <h2 class="section-title">Why Parents & Students Trust Us</h2>

    <div class="row g-4">
      <div class="col-md-4"><div class="feature-box">
        <i class="fa fa-user-check"></i>
        <p>Learn from handpicked, verified instructors with real industry experience.</p>
      </div></div>

      <div class="col-md-4"><div class="feature-box">
        <i class="fa fa-headset"></i>
        <p>24/7 doubt resolution, student support & parent communication.</p>
      </div></div>

      <div class="col-md-4"><div class="feature-box">
        <i class="fa fa-video"></i>
        <p>Lifetime access to class recordings, quizzes & assignments.</p>
      </div></div>

      <div class="col-md-4"><div class="feature-box">
        <i class="fa fa-certificate"></i>
        <p>Earn certificates, badges & leaderboard recognition.</p>
      </div></div>

      <div class="col-md-4"><div class="feature-box">
        <i class="fa fa-gamepad"></i>
        <p>Gamified dashboards with projects, challenges & rewards.</p>
      </div></div>

      <div class="col-md-4"><div class="feature-box">
        <i class="fa fa-shield-alt"></i>
        <p>Secure system with parent portal & detailed progress reports.</p>
      </div></div>
    </div>
  </div>
</section>

<!-- ================= PLANS SECTION ================= -->
<section class="py-5" id="plans" style="background:#FFC4C4;">
  <div class="container">
    <h2 class="section-title">Our Plans</h2>

    <div class="row g-4 justify-content-center">

      <!-- Monthly -->
      <div class="col-md-4">
        <div class="feature-box text-center">
          <h4>Monthly Plan</h4>
          <h2 class="fw-bold">Rs 500</h2>
          <p class="text-muted">per month</p>
          <ul class="list-unstyled small">
            <li>✔ Access to all Premium Courses</li>
            <li>✔ Quizzes & Assignments</li>
            <li>✔ Certificates & Badges</li>
            <li>✔ Parent Progress Tracking</li>
          </ul>
          <a href="subscribe.php?plan=monthly" class="btn btn-main w-100">Choose Monthly</a>
        </div>
      </div>

      <!-- Yearly -->
      <div class="col-md-4">
        <div class="feature-box text-center border border-danger">
          <span class="badge bg-danger mb-2">Best Value</span>
          <h4>Yearly Plan</h4>
          <h2 class="fw-bold">Rs 5000</h2>
          <p class="text-muted">per year</p>
          <ul class="list-unstyled small">
            <li>✔ Unlimited Premium Access</li>
            <li>✔ Advanced Courses & SCORM</li>
            <li>✔ Priority Support</li>
            <li>✔ Detailed Reports & PTMs</li>
          </ul>
          <a href="subscribe.php?plan=yearly" class="btn btn-main w-100">Choose Yearly</a>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ================= MONEY BACK GUARANTEE ================= -->
<section class="py-5">
  <div class="container">
    <div class="feature-box text-center">
      <i class="fa fa-hand-holding-usd"></i>
      <h4>100% Money-Back Guarantee</h4>
      <p>
        If our platform does not meet your expectations, cancel anytime and get
        a refund for remaining lessons — no questions asked.
      </p>
    </div>
  </div>
</section>

<!-- ================= EXTENDED FOOTER ================= -->
<footer class="footer mt-5">
  <div class="container">
    <div class="row g-4">

      <div class="col-md-3">
        <h6 class="fw-bold">Resources</h6>
        <ul class="list-unstyled small">
          <li>Coding Courses</li>
          <li>Coding Quizzes</li>
          <li>Competitions</li>
          <li>Worksheets</li>
          <li>Webinars</li>
        </ul>
      </div>

      <div class="col-md-3">
        <h6 class="fw-bold">Technologies</h6>
        <ul class="list-unstyled small">
          <li>Scratch • Python • JavaScript</li>
          <li>HTML • CSS • Bootstrap</li>
          <li>React • Node</li>
          <li>AI & Machine Learning</li>
        </ul>
      </div>

      <div class="col-md-3">
        <h6 class="fw-bold">Learning Paths</h6>
        <ul class="list-unstyled small">
          <li>Elementary Coding</li>
          <li>Middle School</li>
          <li>High School</li>
          <li>Teens & Advanced</li>
        </ul>
      </div>

      <div class="col-md-3">
        <h6 class="fw-bold">Company</h6>
        <ul class="list-unstyled small">
          <li>About Us</li>
          <li>Careers</li>
          <li>Become an Instructor</li>
          <li>Reviews</li>
        </ul>
      </div>

    </div>

    <hr>
    <p class="text-center small mb-0">
      © 2025 Kidicode LMS • Learn • Build • Lead
    </p>
  </div>
</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```
