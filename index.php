<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Paw Stay | Pet Boarding</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Navigation -->
  <header>
    <nav>
      <div class="nav-left">
        <img src="img/logo.png" alt="PawStay Logo" class="logo">
        <span class="brand-name">PawStay</span>
      </div>
      <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#services">Our Services</a></li>
        <li><a href="#review">Review</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="login.php" class="login-btn">Login</a></li>
      </ul>
    </nav>
  </header>

  <!-- Home Section with Slideshow -->
  <section id="home" class="slideshow">
    <div class="slide" style="background-image: url('img/testdog71.jpeg');"></div>
    <div class="slide" style="background-image: url('img/testdog101.jpeg');"></div>
    <div class="slide" style="background-image: url('img/testdog111.jpeg');"></div>

    <div class="overlay">
      <div class="overlay-box">
        <h1>Welcome to Paw Stay</h1>
        <p>Your pet's second home</p>
        <div class="hero-buttons">
          <a href="#about" class="btn-filled">About Us</a>
          <a href="#services" class="btn-filled">Check Services</a>
        </div>
      </div>
    </div>
  </section>

  <!-- About -->
  <section id="about">
    <div class="about-container">
      <div class="about-image-box">
        <img src="img/testdog811.png" alt="About Paws Stay">
        <div class="image-caption">
          <p>We started since 2023.</p>
          <p>Best Pet Boarding in Malaysia.</p>
        </div>
      </div>

      <div class="about-text">
        <h2>Paw Stay</h2>
        <p>At Paws Stay, we believe pets deserve a second home that’s just as cozy and loving as the first. We offer home-style boarding, personalized care, and a safe, happy environment for your furry friends. Because here, every pet is treated like family.</p>
        <p>Whether it’s for a weekend getaway or an extended holiday, you can trust us to keep your pets comfortable, engaged, and cared for — just like you would at home.</p>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section id="services">
    <h2>Our Services</h2>
    <div class="menu-card">
      <div class="menu-item"><span class="item-name">Boarding</span><span class="item-price">RM40 / night</span></div>
      <div class="menu-item"><span class="item-name">Food</span><span class="item-price">RM15 / DAY</span></div>
      <div class="menu-item"><span class="item-name">Bath Service</span><span class="item-price">RM50</span></div>
      <div class="menu-item highlight"><span class="item-name">Full Grooming <span class="badge">Popular</span></span><span class="item-price">RM80</span></div>
      <div class="menu-item"><span class="item-name">Check-In Time</span><span class="item-price">8:00 AM</span></div>
      <div class="menu-item"><span class="item-name">Check-Out Time</span><span class="item-price">10:00 PM</span></div>
    </div>
  </section>

  <!-- Reviews -->
  <section id="review" class="testimonial-section">
    <p class="subheading">Reviews by Customers</p>
    <h2>Testimonials</h2>
    <div class="timeline">
      <div class="container left">
        <div class="card">
          <div class="top">
            <img src="img/customer1.png" alt="Sandra">
            <div><h4>Sandra</h4><p>Customer</p></div>
          </div>
          <p>“I was so nervous about leaving my dog for the weekend, but PawStay made it so easy. The staff updated me with photos and videos every day. My dog looked so happy! Will definitely come again.”</p>
          <div class="bottom"><span>5.0 Rating</span><span>★★★★★</span></div>
        </div>
      </div>

      <div class="container right">
        <div class="card">
          <div class="top">
            <img src="img/customer2.png" alt="Don">
            <div><h4>Don</h4><p>Customer</p></div>
          </div>
          <p>“Professional and friendly service. My cat is usually shy with strangers, but she warmed up quickly here. I was really impressed with how clean and cozy the environment was.”</p>
          <div class="bottom"><span>4.5 Rating</span><span>★★★★☆</span></div>
        </div>
      </div>

      <div class="container left">
        <div class="card">
          <div class="top">
            <img src="img/customer3.png" alt="Olivia">
            <div><h4>Olivia</h4><p>Customer</p></div>
          </div>
          <p>“PawStay is a lifesaver! I travel often for work and this is the only place I trust with my two dogs. They even remembered their favorite snacks. Highly recommended!”</p>
          <div class="bottom"><span>4.3 Rating</span><span>★★★★☆</span></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact" class="contact-section">
    <div class="contact-content">
      <div class="form-info">
        <h3>Say Hello</h3>
        <h2>Contact</h2>
        <form action="contact.php" method="POST" class="contact-form">
          <div class="form-row">
            <div class="input-group">
              <label for="name">Name <span style="color: red">*</span></label>
              <input type="text" name="name" id="name" placeholder="Jackson" required>
            </div>
            <div class="input-group">
              <label for="email">Email Address</label>
              <input type="email" name="email" id="email" placeholder="Jack@gmail.com" required>
            </div>
          </div>
          <div class="input-group full-width">
            <label for="message">How can we help?</label>
            <textarea name="message" id="message" placeholder="Message" required></textarea>
          </div>
          <button type="submit">Send Message</button>
        </form>
      </div>

      <div class="map-box">
        <iframe src="https://www.google.com/maps/embed?..." width="100%" height="200" style="border:0; border-radius: 10px;" allowfullscreen loading="lazy"></iframe>
      </div>
    </div>

    <div class="contact-footer">
      <div class="footer-column">
        <h4>Where to find us?</h4>
        <p>📍 10, jalan usj1/27, 47600 subang selangor, Malaysia</p>
        <div class="social-icons">
          <a href="#">🐦</a>
          <a href="#">📘</a>
          <a href="#">💬</a>
        </div>
      </div>
      <div class="footer-column">
        <h4>Contact</h4>
        <p><strong>Phone:</strong> +60 12-345 6789</p>
        <p><strong>Email:</strong> hello@pawstay.my</p>
      </div>
      <div class="footer-column">
        <h4>Opening Hours</h4>
        <p>Mon - Fri: <strong>9:00 – 18:00</strong></p>
        <p>Saturday: <strong>11:00 – 16:30</strong></p>
        <p>Sunday: <strong>Closed</strong></p>
      </div>
    </div>

    <div class="copyright">
      © 2025 PawStay. All rights reserved.
    </div>
  </section>

  <script src="js/script.js"></script>
</body>
</html>