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

    /* COURSES SECTION */
    .courses-section {
      background: #fff;
      padding: 80px 0;
    }
    .course-card {
      background: #fff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      height: 100%;
      border: 1px solid #f0f0f0;
    }
    .course-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(133, 14, 53, 0.15);
    }
    .course-img {
      height: 200px;
      width: 100%;
      object-fit: cover;
    }
    .course-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #850E35;
      color: white;
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }
    .course-type-free {
      background: #4CAF50;
    }
    .course-type-premium {
      background: #850E35;
    }
    .course-content {
      padding: 25px;
    }
    .course-age {
      color: #EE6983;
      font-weight: 600;
      font-size: 0.9rem;
    }
    .course-price {
      color: #850E35;
      font-weight: 700;
      font-size: 1.2rem;
    }
    .course-price-free {
      color: #4CAF50;
    }
    
    /* PLANS SECTION */
    .plans-section {
      background: linear-gradient(135deg, #FFE8E8 0%, #FFC4C4 100%);
      padding: 80px 0;
      position: relative;
      overflow: hidden;
    }
    .plans-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, #850E35, #EE6983, #850E35);
    }
    .plan-card {
      background: white;
      border-radius: 20px;
      padding: 40px 30px;
      box-shadow: 0 20px 50px rgba(133, 14, 53, 0.1);
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
      height: 100%;
    }
    .plan-card:hover {
      transform: translateY(-15px);
      box-shadow: 0 30px 60px rgba(133, 14, 53, 0.2);
    }
    .plan-card.popular {
      border: 3px solid #850E35;
      transform: scale(1.05);
    }
    .plan-card.popular:hover {
      transform: scale(1.05) translateY(-15px);
    }
    .plan-badge {
      position: absolute;
      top: 20px;
      right: -35px;
      background: #850E35;
      color: white;
      padding: 8px 40px;
      transform: rotate(45deg);
      font-weight: 700;
      font-size: 0.8rem;
      letter-spacing: 1px;
    }
    .plan-price {
      font-size: 3.5rem;
      font-weight: 800;
      color: #850E35;
      margin: 20px 0;
    }
    .plan-period {
      font-size: 1.2rem;
      color: #666;
      font-weight: 500;
    }
    .plan-feature {
      padding: 12px 0;
      border-bottom: 1px solid #f0f0f0;
      display: flex;
      align-items: center;
    }
    .plan-feature i {
      color: #4CAF50;
      margin-right: 10px;
      font-size: 1.2rem;
    }
    .plan-feature.disabled i {
      color: #ccc;
    }
    .btn-plan {
      background: #850E35;
      color: white;
      padding: 15px 40px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 1.1rem;
      transition: all 0.3s;
      border: 2px solid #850E35;
      margin-top: 30px;
      width: 100%;
    }
    .btn-plan:hover {
      background: transparent;
      color: #850E35;
    }
    .btn-plan-secondary {
      background: transparent;
      color: #850E35;
      border: 2px solid #850E35;
    }
    .btn-plan-secondary:hover {
      background: #850E35;
      color: white;
    }
    
    /* BENEFITS SECTION */
    .benefits-section {
      padding: 80px 0;
      background: #fff;
    }
    .benefit-item {
      padding: 25px;
      border-radius: 15px;
      background: #f9f9f9;
      margin-bottom: 20px;
      transition: all 0.3s;
    }
    .benefit-item:hover {
      background: #FFE8E8;
      transform: translateX(5px);
    }
    .benefit-icon {
      width: 60px;
      height: 60px;
      background: #850E35;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      color: white;
      font-size: 1.5rem;
    }
    
  
    
    /* CERTIFICATIONS */
    .certification-section {
      padding: 80px 0;
      background: #f9f9f9;
    }
    .cert-badge {
      background: white;
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      height: 100%;
      transition: all 0.3s;
    }
    .cert-badge:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .cert-icon {
      font-size: 3rem;
      color: #850E35;
      margin-bottom: 20px;
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
        <img src="img/bg.png" class="img-fluid" style="max-width:700px;">
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
          <p>Track your child's performance, activities, and reports.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- COURSES SECTION -->
<section class="py-5" id="courses" style="background:#FFE8E8;">
  <div class="container">
    <h2 class="section-title">Explore Our Courses</h2>
    <p class="text-center mb-5">
      Browse our handpicked selection of courses designed for different age groups and skill levels. 
      Start with free introductory courses or unlock premium content with our subscription plans.
    </p>

    <div class="row g-4">
      <?php
      // DB connection assumed already included
      $courseQry = mysqli_query($conn,"SELECT * FROM courses ORDER BY created_at DESC LIMIT 6");
      while($c = mysqli_fetch_assoc($courseQry)){
      ?>
      <div class="col-md-4">
        <div class="feature-box text-start h-100">
          <img src="<?php echo $c['course_image']; ?>" class="img-fluid rounded mb-3" style="height:250px;object-fit:cover;">
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
          <a href="user/user_login.php?id=<?php echo $c['id']; ?>" class="btn btn-main btn-sm w-100">
            View Course
          </a>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</section>

<!-- PREMIUM PLANS SECTION -->
<section class="plans-section" id="plans">
  <div class="container">
    <h2 class="section-title">Unlock Premium Learning</h2>
    <p class="text-center mb-5" style="color:#850E35; max-width:800px; margin:0 auto 50px; font-size:1.1rem;">
      Get unlimited access to all premium courses, live classes, certifications, and exclusive features. 
      Choose the plan that fits your learning journey.
    </p>
    
    <div class="row justify-content-center g-4">
      <!-- Monthly Plan -->
      <div class="col-lg-5 col-md-6">
        <div class="plan-card">
          <h3 style="color:#850E35; font-weight:800;">Monthly Plan</h3>
          <p class="text-muted">Perfect for trying out premium features</p>
          <div class="plan-price">500<span style="font-size:1rem;"> RS</span></div>
          <p class="plan-period">per month • Cancel anytime</p>
          
          <div class="mt-4">
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Access to all premium courses</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Live interactive classes</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Assignments & quizzes</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>24/7 doubt support</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Monthly progress reports</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Course completion certificates</span>
            </div>
            <div class="plan-feature disabled">
              <i class="fa fa-times-circle"></i>
              <span class="text-muted">Annual certification (STEM accredited)</span>
            </div>
            <div class="plan-feature disabled">
              <i class="fa fa-times-circle"></i>
              <span class="text-muted">Priority parent-teacher meetings</span>
            </div>
          </div>
          
          <button class="btn btn-plan-secondary" onclick="subscribePlan('monthly')">
            <i class="fa fa-shopping-cart me-2"></i> Choose Monthly Plan
          </button>
        </div>
      </div>
      
      <!-- Yearly Plan (Most Popular) -->
      <div class="col-lg-5 col-md-6">
        <div class="plan-card popular">
          <div class="plan-badge">MOST POPULAR</div>
          <h3 style="color:#850E35; font-weight:800;">Yearly Plan</h3>
          <p class="text-muted">Best value - Save 2 months free!</p>
          <div class="plan-price">5,000<span style="font-size:1rem;"> RS</span></div>
          <p class="plan-period">per year • Only 417 RS/month</p>
          
          <div class="mt-4">
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span><strong>Everything in Monthly Plan +</strong></span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>STEM.org accredited certificates</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Priority parent-teacher meetings</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Advanced project portfolios</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Dedicated learning path advisor</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Early access to new courses</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Gamified learning dashboard</span>
            </div>
            <div class="plan-feature">
              <i class="fa fa-check-circle"></i>
              <span>Career guidance sessions</span>
            </div>
          </div>
          
          <button class="btn btn-plan" onclick="subscribePlan('yearly')">
            <i class="fa fa-crown me-2"></i> Choose Yearly Plan
          </button>
          <p class="text-center mt-3" style="color:#4CAF50; font-weight:600;">
            <i class="fa fa-gift me-1"></i> Save 1,000 RS compared to monthly!
          </p>
        </div>
      </div>
    </div>
    

  </div>
</section>

<!-- BENEFITS SECTION -->
<section class="benefits-section">
  <div class="container">
    <h2 class="section-title">Why Choose Our LMS Platform?</h2>
    <p class="text-center mb-5" style="color:#666; max-width:800px; margin:0 auto;">
      Every learner on our platform gets these amazing benefits designed for success
    </p>
    
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fa fa-user-check"></i>
          </div>
          <h5>Handpicked Top Instructors</h5>
          <p>Learn from verified, experienced instructors chosen specifically for their expertise and teaching skills.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fa fa-clock"></i>
          </div>
          <h5>24/7 Doubt Support</h5>
          <p>Get unlimited doubt sessions with round-the-clock support from our dedicated team of educators.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fa fa-video"></i>
          </div>
          <h5>Lifetime Class Access</h5>
          <p>Review anytime with lifetime access to all class recordings, materials, and resources.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fa fa-certificate"></i>
          </div>
          <h5>Accredited Certificates</h5>
          <p>Earn recognized certificates upon course completion to showcase your skills and achievements.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fa fa-chart-line"></i>
          </div>
          <h5>Progress Tracking</h5>
          <p>Receive detailed monthly progress reports and attend regular parent-teacher meetings.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fa fa-gamepad"></i>
          </div>
          <h5>Gamified Learning</h5>
          <p>Engage with interactive projects, quizzes, and challenges on our fun learning dashboard.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- INTERACTIVE LEARNING -->
<section class="py-5">
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

<!-- CERTIFICATIONS -->
<section class="certification-section">
  <div class="container">
    <h2 class="section-title">Earn Certifications That Stand Out</h2>
    <p class="text-center mb-5" style="color:#666; max-width:800px; margin:0 auto;">
      Our young learners earn accredited certificates that celebrate achievements while unlocking special badges 
      and leaderboard rankings, making learning a fun and rewarding experience.
    </p>
    
    <div class="row g-4">
      <div class="col-md-4">
        <div class="cert-badge">
          <div class="cert-icon">
            <i class="fa fa-code"></i>
          </div>
          <h5>Young Web Developer</h5>
          <p>Master HTML, CSS and create your first websites with professional certification.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="cert-badge">
          <div class="cert-icon">
            <i class="fa fa-robot"></i>
          </div>
          <h5>Young AI Programmer</h5>
          <p>Introduction to AI and machine learning concepts with hands-on projects.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="cert-badge">
          <div class="cert-icon">
            <i class="fa fa-gamepad"></i>
          </div>
          <h5>Game Development Pro</h5>
          <p>Create interactive games and animations with professional development tools.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function subscribePlan(planType) {
    alert("Please login first to activate any plan.");
    window.location.href = "user/user_login.php";
}
</script>

</script>
</body>
</html>