<footer class="exhibition-footer mt-5">
    <div class="container pt-5 pb-4">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand mb-3">
                    <span class="brand-text">EXPO<span>CORE</span></span>
                </div>
                <p class="text-muted footer-description">
                    Redefining the exhibition experience through immersive technology and seamless event management.
                    Building bridges between industries since 2010.
                </p>
                <div class="social-links d-flex gap-3">
                    <a href="#" class="social-icon">Instagram</a>
                    <a href="#" class="social-icon">LinkedIn</a>
                    <a href="#" class="social-icon">Twitter</a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3">Exhibitions</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Upcoming Expos</a></li>
                    <li><a href="#">Past Highlights</a></li>
                    <li><a href="#">Floor Plans</a></li>
                    <li><a href="#">Sponsorship</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3">Resources</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Exhibitor Guide</a></li>
                    <li><a href="#">Visitor FAQ</a></li>
                    <li><a href="#">Media Kit</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6">
                <h6 class="fw-bold mb-3">Stay in the Loop</h6>
                <p class="small text-muted">Get early bird access to major tech expos.</p>
                <form action="#" class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email Address">
                        <button class="btn btn-primary" type="button">Join</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="my-4 border-secondary opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small text-muted mb-0">
                    &copy; {{ date('Y') }} ExpoCore Exhibitions Pvt Ltd. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="small text-muted mb-0">
                    Built with <span style="color: #6366f1;">&hearts;</span> for the Event Industry.
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    .exhibition-footer {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        color: #1e293b;
    }

    .brand-text {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .brand-text span {
        color: #6366f1;
    }

    .footer-description {
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .footer-links li {
        margin-bottom: 0.5rem;
    }

    .footer-links a {
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s ease;
    }

    .footer-links a:hover {
        color: #6366f1;
    }

    .social-icon {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #1e293b;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .social-icon:hover {
        opacity: 0.7;
    }

    .newsletter-form .form-control {
        border-radius: 10px 0 0 10px;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
        background: rgba(255, 255, 255, 0.9);
    }

    .newsletter-form .btn {
        border-radius: 0 10px 10px 0;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        border: none;
        padding: 0 20px;
    }

    /* Dark mode support if needed */
    @media (prefers-color-scheme: dark) {
        .exhibition-footer {
            background: rgba(15, 23, 42, 0.9);
            color: #f8fafc;
        }

        .footer-links a {
            color: #94a3b8;
        }

        .footer-brand {
            color: #fff;
        }
    }
</style>