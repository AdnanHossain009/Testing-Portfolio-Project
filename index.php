<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Adnan Hossain Siraz - Portfolio</title>

    <link rel="stylesheet" href="assets/css/style.css">

    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Navigation Bar  -->
     
    <nav class="navbar">

        <div class="nav-container">
            <div class="nav-logo">
                <a href="#home">AHS</a>
            </div>

            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#home" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="#skills" class="nav-link">Skills</a>
                </li>
                <li class="nav-item">
                    <a href="#education" class="nav-link">Education</a>
                </li>
                <li class="nav-item">
                    <a href="#certificates" class="nav-link">Certificates</a>
                </li>
                <li class="nav-item">
                    <a href="#projects" class="nav-link">Projects</a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="nav-link">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="admin/login.php" class="nav-link">Admin</a>
                </li>

            </ul>

            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- the hero section (dynamic) -->

    <section id="home" class="hero">
        <div class="hero-container">
            <div class="hero-content">

                <?php
                require_once __DIR__ . '/includes/db.php';
                $pdo = null;
                try { $pdo = get_pdo_connection(); } catch (Throwable $e) {}
                $profile = null;
                
                if ($pdo) {
                    $profile = $pdo->query('SELECT * FROM profile ORDER BY id ASC LIMIT 1')->fetch();
                }

                $fullName = $profile['full_name'] ?? 'Adnan Hossain Siraz';

                $title = $profile['title'] ?? 'Full Stack Developer & Creative Problem Solver';
                ?>

                <h1 class="hero-title">
                    Hi, I'm <?php echo $fullName; ?>
                </h1>


                <p class="hero-subtitle"><?php echo htmlspecialchars($title); ?></p>

                <p class="hero-description">
                    I create innovative digital solutions that make a difference.
                    Passionate about clean code, user experience, and cutting-edge technology.
                </p>

                <div class="hero-buttons">
                    <a href="#projects" class="btn btn-primary">View My Work</a>
                    <a href="#contact" class="btn btn-secondary">Get In Touch</a>
                </div>

            </div>

            <!-- my img will be uploaded here later -->
             <!-- <i class="fas fa-code"></i> -->

<div class="hero-image">
    <div class="floating-card">
        <div class="profile-wrapper">
            <img src="assets/images/img1.jpg" alt="Your Name - Developer" class="profile-image">
        </div>
    </div>
</div>



        </div>

        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- the education section ( dynamic) -->

    <section id="education" class="projects">

        <div class="container">
            <h2 class="section-title">Education</h2>
            <div class="projects-grid">

                <?php
                if ($pdo) {
                    $stmtEdu = $pdo->query('SELECT * FROM education ORDER BY sort_order, start_year DESC');
                    foreach ($stmtEdu as $edu) { ?>
                        <div class="project-card">

                            <div class="project-image">
                                <i class="fas fa-user-graduate"></i>
                            </div>

                            <div class="project-content">
                                <h3><?php echo htmlspecialchars($edu['degree']); ?></h3>
                                <p><strong><?php echo htmlspecialchars($edu['institution']); ?></strong> (<?php echo htmlspecialchars($edu['start_year'] . ' - ' . $edu['end_year']); ?>)</p>
                                <?php if (!empty($edu['details'])): ?>
                                <p><?php echo htmlspecialchars($edu['details']); ?></p>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php }
                }
                ?>
            </div>
        </div>
    </section>


    <!-- the certificates section ( dynamic) -->


    <section id="certificates" class="projects">
        <div class="container">
            <h2 class="section-title">Certificates</h2>
            <div class="projects-grid">

                <?php
                if ($pdo) {
                    $stmtCert = $pdo->query('SELECT * FROM certificates ORDER BY sort_order, issue_date DESC');
                    foreach ($stmtCert as $cert) { ?>
                        <div class="project-card">

                            <div class="project-image">
                                <i class="fas fa-certificate"></i>
                            </div>

                            <div class="project-content">
                                <h3><?php echo htmlspecialchars($cert['name']); ?></h3>

                                <p><strong><?php echo htmlspecialchars($cert['issuer'] ?? ''); ?></strong><?php if (!empty($cert['issue_date']))
                                    { echo ' • ' . htmlspecialchars($cert['issue_date']); } ?></p>

                                <div class="project-links">
                                    <?php if (!empty($cert['credential_url'])): ?><a href="<?php echo htmlspecialchars($cert['credential_url']); ?>" target="_blank" class="btn btn-small">Verify</a><?php endif; ?>
                                </div>

                            </div>
                        </div>
                    <?php }
                }
                ?>
            </div>
        </div>

    </section>

    <!-- About Section -->

    <section id="about" class="about">
        <div class="container">

            <h2 class="section-title">About Me</h2>

            <div class="about-content">
                <div class="about-text">

                    <p>
                        I'm a passionate developer with a love for creating meaningful digital experiences.
                        With expertise in modern web technologies, I bring ideas to life through clean,
                        efficient code and intuitive user interfaces.
                    </p>

                    <p>
                        My journey in technology started with curiosity and has evolved into a career
                        of continuous learning and innovation. I believe in writing code that not only
                        works but also inspires and empowers others.
                    </p>

                    <div class="about-stats">
                        <div class="stat-item">
                            <span class="stat-number">2+</span>
                            <span class="stat-label">Years Experience</span>
                        </div>

                        <div class="stat-item">
                            <span class="stat-number">30+</span>
                            <span class="stat-label">Projects Completed</span>
                        </div>

                        <div class="stat-item">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">Client Satisfaction</span>
                        </div>
                    </div>
                </div>

                <div class="about-image">
                    <div class="image-placeholder">
                        <!-- <i class="fas fa-user-circle"></i> -->
                        <img src="assets/images/tech-stack.jpg" alt="My tech stack">
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Skills Section -->

    <section id="skills" class="skills">
        <div class="container">
            <h2 class="section-title">Skills & Technologies</h2>
            <div class="skills-grid">

                <div class="skill-category">

                    <h3>Frontend</h3>

                    <div class="skill-items">

                        <div class="skill-item" data-skill="HTML5">
                            <i class="fab fa-html5"></i>
                            <span>HTML5</span>
                        </div>

                        <div class="skill-item" data-skill="CSS3">
                            <i class="fab fa-css3-alt"></i>
                            <span>CSS3</span>
                        </div>

                        <div class="skill-item" data-skill="JavaScript">
                            <i class="fab fa-js-square"></i>
                            <span>JavaScript</span>
                        </div>

                        <div class="skill-item" data-skill="React">
                            <i class="fab fa-react"></i>
                            <span>React</span>
                        </div>

                    </div>
                </div>

                <div class="skill-category">

                    <h3>Backend</h3>

                    <div class="skill-items">

                        <div class="skill-item" data-skill="PHP">
                            <i class="fab fa-php"></i>
                            <span>PHP</span>
                        </div>

                        <div class="skill-item" data-skill="Node.js">
                            <i class="fab fa-node-js"></i>
                            <span>Node.js</span>
                        </div>

                        <div class="skill-item" data-skill="Python">
                            <i class="fab fa-python"></i>
                            <span>Python</span>
                        </div>

                        <div class="skill-item" data-skill="MySQL">
                            <i class="fas fa-database"></i>
                            <span>MySQL</span>
                        </div>

                    </div>
                </div>

                <div class="skill-category">
                    <h3>Tools & Others</h3>
                    <div class="skill-items">

                        <div class="skill-item" data-skill="Git">
                            <i class="fab fa-git-alt"></i>
                            <span>Git</span>
                        </div>

                        <div class="skill-item" data-skill="Docker">
                            <i class="fab fa-docker"></i>
                            <span>Docker</span>
                        </div>

                        <div class="skill-item" data-skill="AWS">
                            <i class="fab fa-aws"></i>
                            <span>AWS</span>
                        </div>

                        <div class="skill-item" data-skill="Figma">
                            <i class="fab fa-figma"></i>
                            <span>Figma</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section (dynamic) -->

    <section id="projects" class="projects">
        <div class="container">

            <h2 class="section-title">Featured Projects</h2>
            <div class="projects-grid">

                <?php
                if ($pdo) {
                    $stmt = $pdo->query('SELECT * FROM projects WHERE featured = 1 ORDER BY sort_order, created_at DESC');
                    foreach ($stmt as $proj) {
                        $techs = array_filter(array_map('trim', explode(',', $proj['tech_stack'] ?? '')));
                        ?>

                        <div class="project-card">

                            <div class="project-image">
                                <i class="<?php echo htmlspecialchars($proj['icon'] ?: 'fas fa-code'); ?>"></i>
                            </div>

                            <div class="project-content">
                                <h3><?php echo htmlspecialchars($proj['title']); ?></h3>
                                <p><?php echo htmlspecialchars($proj['description']); ?></p>

                                <div class="project-tech">
                                    <?php foreach ($techs as $t): ?><span><?php echo htmlspecialchars($t); ?></span><?php endforeach; ?>
                                </div>

                                <div class="project-links">
                                    <?php if (!empty($proj['live_url'])): ?><a href="<?php echo htmlspecialchars($proj['live_url']); ?>" target="_blank" class="btn btn-small">Live Demo</a><?php endif; ?>
                                    <?php if (!empty($proj['source_url'])): ?><a href="<?php echo htmlspecialchars($proj['source_url']); ?>" target="_blank" class="btn btn-small btn-outline">Source Code</a><?php endif; ?>
                                </div>

                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->

    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title">Get In Touch</h2>
            <div class="contact-content">

                <div class="contact-info">
                    <h3>Let's Work Together</h3>
                    <?php $aboutEmail = $profile['email'] ?? 'adnan.siraz@email.com'; ?>
                    <p>I'm always interested in new opportunities and exciting projects. Feel free to reach out!</p>

                    <div class="contact-details">

                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span><?php echo htmlspecialchars($aboutEmail); ?></span>
                        </div>

                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span><?php echo htmlspecialchars($profile['phone'] ?? '+1 (555) 123-4567'); ?></span>
                        </div>

                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($profile['location'] ?? 'Dhaka, Bangladesh'); ?></span>
                        </div>

                    </div>

                    <div class="social-links">
                        <?php if (!empty($profile['github'])): ?><a href="<?php echo htmlspecialchars($profile['github']); ?>" target="_blank" class="social-link"><i class="fab fa-github"></i></a><?php endif; ?>
                        <?php if (!empty($profile['linkedin'])): ?><a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" target="_blank" class="social-link"><i class="fab fa-linkedin"></i></a><?php endif; ?>
                        <?php if (!empty($profile['twitter'])): ?><a href="<?php echo htmlspecialchars($profile['twitter']); ?>" target="_blank" class="social-link"><i class="fab fa-twitter"></i></a><?php endif; ?>
                        <?php if (!empty($profile['instagram'])): ?><a href="<?php echo htmlspecialchars($profile['instagram']); ?>" target="_blank" class="social-link"><i class="fab fa-instagram"></i></a><?php endif; ?>
                    </div>

                </div>

                <div class="contact-form">
                    <form action="process_contact.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Your Name" required>
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" placeholder="Your Email" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="subject" placeholder="Subject" required>
                        </div>

                        <div class="form-group">
                            <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p>&copy; 2024 Adnan Hossain Siraz. All rights reserved.</p>
                <p>Built with ❤️ using modern web technologies</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>


