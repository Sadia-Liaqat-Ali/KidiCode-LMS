<!-- nav.php : Modern clean pastel theme with icons -->

<style>
  .navbar {
    background-color: #43334C; /* dark purple */
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    padding: 0.9rem 1rem;

    position: sticky; /* sticky top */
    top: 0;           /* top se chipka rahe */
    z-index: 9999;    /* upar dikhne ke liye */
  }

  .navbar-brand {
    font-size: 1.8rem;
    color: #EE6983 !important;
    font-weight: 700;
  }

  .navbar-brand i {
    color: #FFC4C4;
  }

  .nav-link {
    position: relative;
    margin: 0 14px;
    font-size: 1.05rem;
    color: #FFC4C4 !important;
    font-weight: 500;
    transition: 0.3s ease;
    display: flex;
    align-items: center;
  }

  .nav-link i {
    margin-right: 6px;
    font-size: 1.1rem;
  }

  .nav-link::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -5px;
    width: 0;
    height: 2px;
    background-color: #EE6983;
    transition: width 0.3s ease-in-out;
    border-radius: 4px;
  }

  .nav-link:hover {
    color: #EE6983 !important;
  }

  .nav-link:hover::after {
    width: 100%;
  }

  .navbar-toggler {
    border: none;
  }

  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 30 30' fill='%23FFC4C4' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255,196,196,0.7)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
  }
</style>


<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">
      <i class="fas fa-graduation-cap me-2"></i>KidiCode LMS
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto fw-semibold">
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home"></i>Home</a></li>
        <li class="nav-item"><a class="nav-link" href="user/register.php"><i class="fas fa-user-graduate"></i>Student/Parent</a></li>
        <li class="nav-item"><a class="nav-link" href="instructor_register.php"><i class="fas fa-chalkboard-teacher"></i>Instructor</a></li>
        <li class="nav-item"><a class="nav-link" href="admin/admin_login.php"><i class="fas fa-user-shield"></i>Admin</a></li>
        <li class="nav-item"><a class="nav-link" href="portfolio.php"><i class="fas fa-briefcase"></i>Portfolio</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fas fa-envelope"></i>Contact Us</a></li>
      </ul>
    </div>
  </div>
</nav>
