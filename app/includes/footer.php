<!-- footer -->
<?php
include(ROOT_PATH . "/app/includes/session.php");

?>
<?php if (isset($_SESSION['success'])): ?>
  <div class="alert success">
    <?= $_SESSION['success']; ?>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert error">
    <?= $_SESSION['error']; ?>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="footer">
  <div class="footer-content">
    <div class="footer-section about">
      <h1 class="logo-text"><span>Fitness</span> And Health</h1>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente
        blanditiis nobis maxime iusto aspernatur, architecto labore vitae,
        cupiditate ipsam omnis pariatur rem minima, assumenda iste!
      </p>
      <div class="contact">
        <span><i class="fas fa-phone"></i> &nbsp; 081-689-619-05</span>
        <span><i class="fas fa-envelope"></i> &nbsp;
          auduchukwuma82@gmail.com</span>
      </div>
      <div class="socials">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>
    </div>

    <div class="footer-section links">
      <h2>Quick Links</h2>
      <br />
      <ul>
        <a href="#">
          <li>Events</li>
        </a>
        <a href="#">
          <li>Team</li>
        </a>
        <a href="#">
          <li>Mentors</li>
        </a>
        <a href="#">
          <li>Gallery</li>
        </a>
        <a href="#">
          <li>Terms And Conditions</li>
        </a>
      </ul>
    </div>

    <div class="footer-section contact-form">
      <h2>Contact Us</h2>
      <br />

      <?php if (isset($_SESSION['id'])): ?>

        <form action="http://localhost:5001/blog/app/includes/contact_process.php" method="POST">


          <?php include(ROOT_PATH . '/app/includes/messages.php'); ?>

          <!-- Show success/error if redirected back -->

          <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success">
              <?= $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
          <?php endif; ?>

          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error">
              <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
          <?php endif; ?>

          <input
            type="email"
            name="email" required
            class="text-input contact-input"
            placeholder="Your email address..." />

          <input type="text" name="name" placeholder="Your Name" class="text-input contact-input">

          <textarea
            rows="4"
            name="message"
            class="text-input contact-input"
            placeholder="Your Message..."></textarea>

          <button type="submit" class="btn btn-big contact-btn" name="send-message">
            <i class="fas fa-envelop"> Send</i>
          </button>
        </form>

      <?php else: ?>
        <p>Please <a href="login.php">login</a> to contact us.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="footer-bottom">
    &copy; FitnessandHealth.com | Designed By Audu Gregory
  </div>
</div>

<!--// footer -->