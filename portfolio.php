<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - KidiCode LMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #850E35;
            --secondary: #EE6983;
            --accent: #FFC4C4;
            --light: #FCF5EE;
            --dark: #2D3047;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }
        
        /* Navigation */
        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            font-size: 1.8rem;
        }
        
        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
            margin: 0 10px;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
        }
        
        /* Hero Section */
        .portfolio-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 100px 0;
        }
        
        /* Section Titles */
        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 40px;
            color: var(--primary);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--secondary);
            border-radius: 2px;
        }
        
        .section-title.center::after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* Training Programs */
        .training-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            height: 100%;
            transition: transform 0.3s;
        }
        
        .training-card:hover {
            transform: translateY(-5px);
        }
        
        .training-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: white;
            font-size: 1.8rem;
        }
        
        /* LMS Features */
        .lms-features-section {
            background: white;
            border-radius: 20px;
            padding: 50px;
            margin: 50px 0;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        
        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .feature-icon-small {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        /* Student Success Stories Carousel */
        .carousel-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 60px 0;
        }
        
        .story-slide {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .student-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--accent);
            margin: 0 auto 20px;
        }
        
        .carousel-control-prev, .carousel-control-next {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.8;
        }
        
        .carousel-control-prev {
            left: -25px;
        }
        
        .carousel-control-next {
            right: -25px;
        }
        
        /* Blog Section */
        .blog-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            height: 100%;
        }
        
        .blog-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        
        .blog-category {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        /* Achievements */
        .achievement-card {
            text-align: center;
            padding: 30px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        
        .achievement-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 1.8rem;
        }
        
        
        /* Responsive */
        @media (max-width: 768px) {
            .portfolio-hero {
                padding: 60px 0;
            }
            
            .lms-features-section {
                padding: 30px;
            }
            
            .carousel-control-prev {
                left: 10px;
            }
            
            .carousel-control-next {
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Hero Section -->
    <section class="portfolio-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">KidiCode Portfolio & Success Stories</h1>
                    <p class="lead mb-4">Discover our training programs, student achievements, platform features, and educational insights - all in one place.</p>
                    <a href="#training" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-graduation-cap me-2"></i>Training Programs
                    </a>
                    <a href="#success" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-star me-2"></i>Success Stories
                    </a>
                </div>
                <div class="col-lg-6">
                    <img src="img/portfolio.jpg" class="img-fluid rounded-3 shadow-lg" alt="Portfolio Hero">
                </div>
            </div>
        </div>
    </section>

    <!-- Training Programs for Instructors -->
    <section class="py-5" id="training">
        <div class="container">
            <h2 class="section-title">Training Programs for Instructors</h2>
            <p class="mb-5">Professional development programs designed to help educators excel in digital teaching</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="training-card">
                        <div class="training-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h4>Digital Teaching Mastery</h4>
                        <p>Learn to create engaging online lessons, manage virtual classrooms, and use LMS tools effectively.</p>
                        <div class="mt-4">
                            <span class="badge bg-primary me-2">8 Weeks</span>
                            <span class="badge bg-success">Certified</span>
                        </div>
                        <a href="#" class="btn btn-sm mt-3 w-100" style="background: var(--primary); color: white;">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="training-card">
                        <div class="training-icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <h4>Gamification in Education</h4>
                        <p>Master techniques to make learning fun through points, badges, leaderboards, and interactive challenges.</p>
                        <div class="mt-4">
                            <span class="badge bg-primary me-2">6 Weeks</span>
                            <span class="badge bg-success">Certified</span>
                        </div>
                        <a href="#" class="btn btn-sm mt-3 w-100" style="background: var(--primary); color: white;">Learn More</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="training-card">
                        <div class="training-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Student Progress Analytics</h4>
                        <p>Learn to interpret LMS analytics, track student performance, and provide data-driven feedback.</p>
                        <div class="mt-4">
                            <span class="badge bg-primary me-2">4 Weeks</span>
                            <span class="badge bg-success">Certified</span>
                        </div>
                        <a href="#" class="btn btn-sm mt-3 w-100" style="background: var(--primary); color: white;">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LMS Features Overview -->
    <section id="lms-overview">
        <div class="container">
            <div class="lms-features-section">
                <h2 class="section-title">KidiCode LMS Platform Features</h2>
                <p class="mb-5">Our comprehensive Learning Management System provides everything you need for effective digital education</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="feature-item">
                            <div class="feature-icon-small">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h5>Multi-Role Management</h5>
                                <p>Separate dashboards for Admins, Instructors, Students, and Parents with appropriate permissions.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon-small">
                                <i class="fas fa-video"></i>
                            </div>
                            <div>
                                <h5>Live Class Integration</h5>
                                <p>Schedule and conduct live classes with Zoom integration, recording, and attendance tracking.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon-small">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div>
                                <h5>Assignment Management</h5>
                                <p>Create, distribute, and grade assignments with deadline tracking and submission alerts.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="feature-item">
                            <div class="feature-icon-small">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div>
                                <h5>Quiz & Assessment System</h5>
                                <p>Create multiple choice, coding challenges, and subjective questions with automatic grading.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon-small">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div>
                                <h5>Progress Tracking</h5>
                                <p>Monitor student progress with visual analytics, performance reports, and achievement tracking.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon-small">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div>
                                <h5>Certificate Generation</h5>
                                <p>Automatically generate and distribute completion certificates with verification codes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </section>

    <!-- Student Success Stories Carousel -->
    <section class="carousel-section py-5" id="success">
        <div class="container">
            <h2 class="section-title center">Student Success Stories</h2>
            <p class="text-center mb-5">Real achievements from our talented young learners</p>
            
            <div id="successCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="story-slide">
                            <img src="img/student1.jpg" class="student-avatar" alt="Ayesha Khan">
                            <h4 class="mb-3">Ayesha Khan, Age 12</h4>
                            <span class="badge bg-primary mb-3">Young Web Developer Certified</span>
                            <p class="lead mb-4">"I started learning web development with KidiCode when I was 10. Now I've built 5 websites for local businesses and won the National Young Coder Competition 2024!"</p>
                            <p><i class="fas fa-calendar me-2"></i> Graduated: June 2024</p>
                        </div>
                    </div>
                    
                    <div class="carousel-item">
                        <div class="story-slide">
                            <img src="img/student2.jpg" class="student-avatar" alt="Ali Hassan">
                            <h4 class="mb-3">Ali Hassan, Age 14</h4>
                            <span class="badge bg-primary mb-3">Game Development Champion</span>
                            <p class="lead mb-4">"My first mobile game reached 10,000+ downloads on Play Store. KidiCode's project-based approach helped me learn Python and game development concepts easily."</p>
                            <p><i class="fas fa-calendar me-2"></i> Graduated: March 2024</p>
                        </div>
                    </div>
                    
                    <div class="carousel-item">
                        <div class="story-slide">
                            <img src="img/student3.jpg" class="student-avatar" alt="Sara Ahmed">
                            <h4 class="mb-3">Sara Ahmed, Age 16</h4>
                            <span class="badge bg-primary mb-3">AI Programmer Prodigy</span>
                            <p class="lead mb-4">"I developed an AI model that detects plant diseases with 92% accuracy. Won 1st prize at National Science Fair and received a scholarship for advanced AI studies."</p>
                            <p><i class="fas fa-calendar me-2"></i> Graduated: January 2024</p>
                        </div>
                    </div>
                    
                    <div class="carousel-item">
                        <div class="story-slide">
                            <img src="img/student4.webp" class="student-avatar" alt="Zain Malik">
                            <h4 class="mb-3">Fatima, Age 13</h4>
                            <span class="badge bg-primary mb-3">Scratch Programming Expert</span>
                            <p class="lead mb-4">"Created 15+ interactive games and animations. My Scratch project was featured in the local newspaper and I now teach basic coding to my classmates."</p>
                            <p><i class="fas fa-calendar me-2"></i> Graduated: August 2024</p>
                        </div>
                    </div>
                    
                    <div class="carousel-item">
                        <div class="story-slide">
                            <img src="img/student5.jpg" class="student-avatar" alt="Fatima Noor">
                            <h4 class="mb-3">Zain Malik, Age 13</h4>
                            <span class="badge bg-primary mb-3">Robotics Champion</span>
                            <p class="lead mb-4">"Built a solar-powered cleaning robot that won the International Youth Robotics Competition. KidiCode's hands-on approach made complex concepts easy to understand."</p>
                            <p><i class="fas fa-calendar me-2"></i> Graduated: May 2024</p>
                        </div>
                    </div>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#successCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#successCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                
                <div class="carousel-indicators position-static mt-4">
                    <button type="button" data-bs-target="#successCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#successCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#successCarousel" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#successCarousel" data-bs-slide-to="3"></button>
                    <button type="button" data-bs-target="#successCarousel" data-bs-slide-to="4"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements Section -->
    <section class="py-5 bg-light" id="achievements">
        <div class="container">
            <h2 class="section-title center">Our Achievements & Recognition</h2>
            <p class="text-center mb-5">Celebrating our journey and milestones in educational technology</p>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="achievement-card">
                        <div class="achievement-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3 class="text-primary fw-bold">15+</h3>
                        <h5>Awards Won</h5>
                        <p>National & international recognition for educational innovation</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="achievement-card">
                        <div class="achievement-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="text-primary fw-bold">2,500+</h3>
                        <h5>Students Trained</h5>
                        <p>Young learners transformed into confident coders</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="achievement-card">
                        <div class="achievement-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3 class="text-primary fw-bold">50+</h3>
                        <h5>Expert Instructors</h5>
                        <p>Certified educators passionate about teaching coding</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="achievement-card">
                        <div class="achievement-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h3 class="text-primary fw-bold">98%</h3>
                        <h5>Success Rate</h5>
                        <p>Students completing courses with positive outcomes</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="py-5" id="blog">
        <div class="container">
            <h2 class="section-title">Educational Insights & Blog</h2>
            <p class="mb-5">Latest articles and resources on kids coding education and technology</p>
            
            <div class="row g-4">
                <!-- Blog 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <img src="img/blog1.jpg" class="blog-image" alt="AI in Education">
                        <div class="p-4">
                            <span class="blog-category">AI & Technology</span>
                            <h5 class="my-2">The Future of AI in Kids Education</h5>
                            <p class="text-muted">How artificial intelligence is transforming how children learn coding and problem-solving skills.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="far fa-calendar me-1"></i> Nov 15, 2024</small>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#blogModal1">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Blog 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <img src="img/blog2.jpg" class="blog-image" alt="Coding Projects">
                        <div class="p-4">
                            <span class="blog-category">Tutorials</span>
                            <h5 class="my-2">5 Coding Projects for Beginners</h5>
                            <p class="text-muted">Easy and fun coding projects that kids can build in their first month of learning.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="far fa-calendar me-1"></i> Nov 10, 2024</small>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#blogModal2">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Blog 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <img src="img/blog3.jpg" class="blog-image" alt="Digital Literacy">
                        <div class="p-4">
                            <span class="blog-category">Parenting</span>
                            <h5 class="my-2">Parent's Guide to Digital Literacy</h5>
                            <p class="text-muted">How parents can support their children's coding journey in the digital age.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="far fa-calendar me-1"></i> Nov 5, 2024</small>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#blogModal3">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Blog 4 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <img src="img/blog4.jpg" class="blog-image" alt="Game Development">
                        <div class="p-4">
                            <span class="blog-category">Game Development</span>
                            <h5 class="my-2">Game Development for Kids: Where to Start</h5>
                            <p class="text-muted">Step-by-step guide to introducing game development concepts to young learners.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="far fa-calendar me-1"></i> Oct 28, 2024</small>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#blogModal4">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Blog 5 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <img src="img/blog5.jpg" class="blog-image" alt="Scratch Programming">
                        <div class="p-4">
                            <span class="blog-category">Visual Programming</span>
                            <h5 class="my-2">Why Scratch is Perfect for Young Coders</h5>
                            <p class="text-muted">Exploring the benefits of block-based programming for developing logical thinking.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="far fa-calendar me-1"></i> Oct 20, 2024</small>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#blogModal5">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Blog 6 -->
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <img src="img/blog6.jpg" class="blog-image" alt="STEM Education">
                        <div class="p-4">
                            <span class="blog-category">STEM Education</span>
                            <h5 class="my-2">Integrating Coding with School Curriculum</h5>
                            <p class="text-muted">How coding complements traditional subjects and enhances overall learning.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="far fa-calendar me-1"></i> Oct 15, 2024</small>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#blogModal6">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
         
        </div>
    </section>

    <!-- Blog Modals -->
    <?php
    $blog_modals = [
        1 => [
            'title' => 'The Future of AI in Kids Education',
            'category' => 'AI & Technology',
            'date' => 'Nov 15, 2024',
            'author' => 'Dr. Sarah Khan',
            'content' => 'Artificial intelligence is revolutionizing education by providing personalized learning experiences. At KidiCode, we are integrating AI algorithms that adapt to each student\'s learning pace and style. Our AI tutors can identify areas where students struggle and provide targeted exercises to improve those skills.<br><br>Key benefits of AI in kids education:<br>1. Personalized learning paths<br>2. Instant feedback on coding exercises<br>3. Adaptive difficulty levels<br>4. Early identification of learning gaps<br>5. Enhanced engagement through interactive AI characters'
        ],
        2 => [
            'title' => '5 Coding Projects for Beginners',
            'category' => 'Tutorials',
            'date' => 'Nov 10, 2024',
            'author' => 'Ali Raza',
            'content' => 'Starting with coding can be overwhelming, but with the right projects, it becomes fun and engaging. Here are 5 beginner-friendly projects:<br><br>1. <strong>Simple Calculator</strong> - Learn basic operations and user input<br>2. <strong>Number Guessing Game</strong> - Practice loops and conditionals<br>3. <strong>Digital Storybook</strong> - Combine coding with creativity<br>4. <strong>Animated Greeting Card</strong> - Learn basic animation principles<br>5. <strong>Weather App Interface</strong> - Practice API concepts and UI design<br><br>Each project teaches fundamental programming concepts while keeping young learners motivated.'
        ],
        3 => [
            'title' => 'Parent\'s Guide to Digital Literacy',
            'category' => 'Parenting',
            'date' => 'Nov 5, 2024',
            'author' => 'Fatima Ahmed',
            'content' => 'Digital literacy is no longer optional - it\'s essential. As parents, you play a crucial role in guiding your children through their digital learning journey.<br><br><strong>Key areas to focus on:</strong><br>1. Setting healthy screen time limits<br>2. Choosing age-appropriate learning resources<br>3. Creating a supportive learning environment at home<br>4. Understanding online safety and privacy<br>5. Encouraging balanced digital and physical activities<br><br>Remember, the goal isn\'t just screen time, but quality learning time.'
        ],
        4 => [
            'title' => 'Game Development for Kids: Where to Start',
            'category' => 'Game Development',
            'date' => 'Oct 28, 2024',
            'author' => 'Game Development Team',
            'content' => 'Game development combines creativity with logical thinking - making it perfect for young learners. Here\'s a step-by-step approach:<br><br>1. <strong>Start with Scratch</strong> - Visual programming for complete beginners<br>2. <strong>Move to Construct 3</strong> - 2D game development without coding<br>3. <strong>Try GameMaker Studio</strong> - Drag-and-drop with optional coding<br>4. <strong>Explore Unity with C#</strong> - For advanced young learners<br>5. <strong>Python with PyGame</strong> - Text-based game development<br><br>Each platform offers age-appropriate tools and learning curves.'
        ],
        5 => [
            'title' => 'Why Scratch is Perfect for Young Coders',
            'category' => 'Visual Programming',
            'date' => 'Oct 20, 2024',
            'author' => 'Visual Programming Expert',
            'content' => 'Scratch, developed by MIT, is the ideal starting point for children aged 8-16. Here\'s why:<br><br><strong>Benefits of Scratch:</strong><br>1. <strong>Visual Programming</strong> - No syntax errors, just drag-and-drop blocks<br>2. <strong>Immediate Feedback</strong> - See results instantly<br>3. <strong>Creative Expression</strong> - Combine art, music, and animation<br>4. <strong>Community Support</strong> - Millions of projects to learn from<br>5. <strong>Foundation Skills</strong> - Teaches loops, conditionals, variables<br><br>Scratch builds confidence before moving to text-based programming.'
        ],
        6 => [
            'title' => 'Integrating Coding with School Curriculum',
            'category' => 'STEM Education',
            'date' => 'Oct 15, 2024',
            'author' => 'STEM Education Specialist',
            'content' => 'Coding isn\'t just a standalone subject - it complements and enhances traditional learning.<br><br><strong>Integration Examples:</strong><br>1. <strong>Math</strong> - Use coding to visualize geometry and algebra<br>2. <strong>Science</strong> - Create simulations and data visualizations<br>3. <strong>Language Arts</strong> - Build interactive stories and digital books<br>4. <strong>Art</strong> - Code-generated art and animations<br>5. <strong>Social Studies</strong> - Historical simulations and maps<br><br>This integrated approach shows students the real-world applications of their learning.'
        ]
    ];
    
    foreach ($blog_modals as $id => $blog) {
        echo '<div class="modal fade" id="blogModal' . $id . '" tabindex="-1">';
        echo '<div class="modal-dialog modal-lg modal-dialog-centered">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white;">';
        echo '<h5 class="modal-title">' . $blog['title'] . '</h5>';
        echo '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>';
        echo '</div>';
        echo '<div class="modal-body p-4">';
        echo '<div class="row mb-4">';
        echo '<div class="col-md-6">';
        echo '<span class="badge bg-primary">' . $blog['category'] . '</span>';
        echo '</div>';
        echo '<div class="col-md-6 text-end">';
        echo '<small class="text-muted"><i class="far fa-calendar me-1"></i>' . $blog['date'] . '</small>';
        echo '</div>';
        echo '</div>';
        echo '<p><strong>By ' . $blog['author'] . '</strong></p>';
        echo '<div class="mt-3">';
        echo '<p>' . $blog['content'] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>

    <!-- CTA Section -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--primary), var(--secondary));">
        <div class="container text-center text-white">
            <h2 class="mb-4">Join Our Community of Successful Learners</h2>
            <p class="mb-4 lead">Start your child's coding journey today with our proven learning platform</p>
            <a href="user/register.php" class="btn btn-light btn-lg me-3">
                <i class="fas fa-user-plus me-2"></i>Register Now
            </a>
            <a href="index.php#courses" class="btn btn-outline-light btn-lg">
                <i class="fas fa-book me-2"></i>Browse Courses
            </a>
        </div>
    </section>

    <?php include 'footer.php' ?>


    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Initialize carousel
        var successCarousel = new bootstrap.Carousel(document.getElementById('successCarousel'), {
            interval: 5000,
            wrap: true
        });
    </script>
</body>
</html>