{{-- Hero Section --}}
<section class="hero-section position-relative overflow-hidden">
    {{-- Animated Background Blobs --}}
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container h-100">
        <div class="row min-vh-100 align-items-center">
            <div class="col-lg-12 text-center text-lg-start">
                <span class="badge rounded-pill mb-3 px-3 py-2"
                    style="background: #fff1f2; color: #AA2324; border: 1px solid rgba(170, 35, 36, 0.1);">
                    ✨ 20+ Years of Industry Leadership
                </span>

                <h1 class="display-1 fw-black tracking-tight mb-4">
                    Next-Gen <br>
                    <span class="text-gradient">Exhibition Ecosystem</span>
                </h1>

                <p class="lead text-muted mb-5 max-w-550">
                    Discover India's most influential trade shows. Whether you're scaling your brand or exploring
                    innovations, we bridge the gap.
                </p>

                {{-- Role Selection Cards --}}
                <div class="d-flex justify-content-center justify-content-lg-start gap-4 flex-wrap">
                    <div class="role-card shadow-sm" onclick="selectRole('exhibitor')">
                        <div class="icon-box">🚀</div>
                        <h5 class="fw-bold">Exhibitor</h5>
                        <p class="small text-muted mb-0">Showcase products and capture premium business leads.</p>
                    </div>

                    <a href="{{ url('/events') }}" class="role-card shadow-sm text-decoration-none">
                        <div class="icon-box">🎫</div>
                        <h5 class="fw-bold">Visitor</h5>
                        <p class="small text-muted mb-0">Network with leaders and explore latest industry trends.</p>
                    </a>
                </div>

                {{-- City Quick-Links --}}
                <div class="mt-5">
                    <p class="small fw-bold text-uppercase tracking-widest text-muted mb-3">Explore Major Hubs</p>
                    <div class="city-grid d-flex flex-wrap justify-content-center justify-content-lg-start gap-2">
                        @php $cities = ['Mumbai', 'Delhi', 'Bengaluru', 'Chennai', 'Kolkata', 'Hyderabad', 'Pune']; @endphp
                        @foreach($cities as $city)
                            <button class="city-chip" onclick="goToCity('{{ strtolower($city) }}')">
                                {{ $city }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .fw-black {
        font-weight: 900;
    }

    .tracking-tight {
        letter-spacing: -0.05em;
    }

    .max-w-550 {
        max-width: 550px;
    }

    .text-gradient {
        background: linear-gradient(135deg, #AA2324 0%, #4338ca 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Hero Layout */
    .hero-section {
        min-height: 90vh;
    }

    /* Role Cards */
    .role-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 24px;
        padding: 30px;
        width: 280px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
    }

    .role-card:hover {
        transform: translateY(-10px);
        background: #fff;
        border-color: #AA2324;
        box-shadow: 0 20px 40px rgba(170, 35, 36, 0.1) !important;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        background: #fff1f2;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    /* City Chips */
    .city-chip {
        padding: 8px 20px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 100px;
        font-weight: 600;
        font-size: 14px;
        color: #64748b;
        transition: all 0.3s ease;
    }

    .city-chip:hover {
        background: #AA2324;
        color: white;
        border-color: #AA2324;
        transform: translateY(-2px);
    }

    /* Blobs */
    .blob {
        position: absolute;
        z-index: -1;
        filter: blur(100px);
        opacity: 0.3;
        animation: blobMove 20s infinite alternate;
    }

    .blob-1 {
        width: 500px;
        height: 500px;
        background: #AA2324;
        top: -10%;
        right: -5%;
    }

    .blob-2 {
        width: 400px;
        height: 400px;
        background: #6366f1;
        bottom: 5%;
        left: -5%;
    }

    @keyframes blobMove {
        from {
            transform: translate(0, 0) rotate(0deg);
        }

        to {
            transform: translate(50px, 100px) rotate(30deg);
        }
    }
</style>

<script>
    function selectRole(role) {
        window.location.href = `/register?role=${role}`;
    }

    function goToCity(city) {
        window.location.href = `/${city}/events`;
    }
</script>