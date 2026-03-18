<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | IITM India</title>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
*{box-sizing:border-box;-webkit-tap-highlight-color:transparent;}
html,body{margin:0;padding:0;font-family:'Roboto',Arial,sans-serif;height:100%;background:#F5F7FA;color:#2D3436;}
.page-wrapper{display:flex;flex-direction:column;justify-content:center;align-items:center;min-height:100vh;width:100%;padding:24px;}
.container{width:100%;max-width:360px;background:#ffffff;border-radius:28px;box-shadow:0 12px 40px rgba(0,0,0,0.06);padding:40px 24px;text-align:center;animation:slideUp 0.6s ease-out;}
.logo{width:85px;height:85px;border-radius:50%;object-fit:contain;margin-bottom:16px;}
.header-section{margin-bottom:24px;}
.title{font-size:22px;font-weight:700;margin-bottom:6px;}
.subtitle{font-size:14px;color:#7F8C8D;}
.tabs{display:flex;background:#F1F3F5;border-radius:16px;overflow:hidden;margin-bottom:20px;}
.tab{flex:1;padding:12px;cursor:pointer;font-weight:600;font-size:14px;}
.tab.active{background:#6200EE;color:#fff;}
.input-group{margin-bottom:16px;text-align:left;}
input{width:100%;padding:16px;border-radius:16px;font-size:16px;border:2px solid #F1F3F5;background:#F8F9FA;outline:none;}
input:focus{border-color:#6200EE;background:#fff;box-shadow:0 0 0 4px rgba(98,0,238,0.08);}
.primary-btn{width:100%;padding:16px;border:none;background:#6200EE;color:#fff;font-size:16px;font-weight:700;border-radius:16px;cursor:pointer;box-shadow:0 6px 20px rgba(98,0,238,0.25);margin-top:10px;}
.primary-btn:active{transform:scale(.97);background:#4B00D1;}
.divider{display:flex;align-items:center;margin:24px 0;color:#BDC3C7;font-size:12px;font-weight:500;text-transform:uppercase;letter-spacing:1px;}
.divider::before,.divider::after{content:"";flex:1;height:1px;background:#EDF2F7;}
.divider span{padding:0 15px;}
.secondary-btn{display:block;width:100%;padding:14px;border:2px solid #E2E8F0;background:transparent;color:#4A5568;font-size:14px;font-weight:700;border-radius:16px;text-decoration:none;}
.hidden{display:none;}
@keyframes slideUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
</style>
</head>

<body>

<div class="page-wrapper">
<div class="container">

<img class="logo" src="https://iitmindia.com/wp-content/uploads/2024/03/image-1.png">

<div class="header-section">
<h1 class="title">Secure Login</h1>
<p class="subtitle">Login using mobile number</p>
</div>

<div class="tabs">
<div class="tab active" onclick="switchTab('otp')">OTP Login</div>
<div class="tab" onclick="switchTab('password')">Password</div>
</div>

<!-- OTP LOGIN -->
<form id="otpForm" onsubmit="event.preventDefault(); handleSendOTP();">

<div class="input-group">
<input type="tel" id="mobile_number" placeholder="Mobile Number" required>
</div>

<div id="otp-area" class="input-group hidden">
<input type="text" id="otp_input" placeholder="Enter 6-digit OTP">
</div>

<button type="submit" id="btn-send-otp" class="primary-btn">Send OTP</button>

<button type="button" id="btn-verify-otp" class="primary-btn hidden" onclick="handleVerifyOTP()">Verify OTP</button>

<p id="otp-subtitle" class="subtitle"></p>

</form>

<!-- PASSWORD LOGIN -->
<form id="passwordForm" class="hidden" method="POST" action="{{ route('login.post') }}">
@csrf

<div class="input-group">
<input type="tel" name="mobile" placeholder="Mobile Number" required>
</div>

<div class="input-group">
<input type="password" name="password" placeholder="Password" required>
</div>

<button type="submit" class="primary-btn">Login</button>

</form>

<div class="divider"><span>New here?</span></div>

<a href="{{ route('register', ['location' => 'x']) }}" class="secondary-btn">
    Create an Account
</a>
</div>
</div>

<script>
function switchTab(type){
const otpForm=document.getElementById("otpForm");
const passwordForm=document.getElementById("passwordForm");
const tabs=document.querySelectorAll(".tab");
tabs.forEach(tab=>tab.classList.remove("active"));

if(type==="otp"){
otpForm.classList.remove("hidden");
passwordForm.classList.add("hidden");
tabs[0].classList.add("active");
}else{
passwordForm.classList.remove("hidden");
otpForm.classList.add("hidden");
tabs[1].classList.add("active");
}
}

function handleSendOTP(){
const mobile=document.getElementById('mobile_number').value;

if(!/^[6-9]\d{9}$/.test(mobile)){
alert("Enter valid 10-digit mobile number");
return;
}

const btn=document.getElementById('btn-send-otp');
btn.innerText="Sending...";
btn.disabled=true;

fetch("{{ route('login.otp') }}",{
method:"POST",
headers:{
"Content-Type":"application/json",
"X-CSRF-TOKEN":"{{ csrf_token() }}"
},
body:JSON.stringify({mobile_number:mobile})
})
.then(res=>res.json())
.then(data=>{
if(data.status==='success'){
document.getElementById('otp-area').classList.remove('hidden');
document.getElementById('btn-verify-otp').classList.remove('hidden');
document.getElementById('btn-send-otp').classList.add('hidden');
document.getElementById('otp-subtitle').innerText="OTP sent to "+mobile;
document.getElementById('mobile_number').disabled=true;
}else{
alert(data.message||"Failed to send OTP");
btn.innerText="Send OTP";
btn.disabled=false;
}
})
.catch(()=>{
alert("Server error");
btn.innerText="Send OTP";
btn.disabled=false;
});
}

</script>

<script>
function handleVerifyOTP() {
    const otp = document.getElementById('otp_input').value.trim();
    const mobile = document.getElementById('mobile_number').value.trim();
    const btn = document.getElementById('btn-verify-otp');

    if (otp.length !== 6) {
        alert("Enter 6-digit OTP");
        return;
    }

    btn.innerText = "Verifying...";
    btn.disabled = true;

    // Create hidden form dynamically
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "{{ route('login.verify') }}";

    // CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = "_token";
    csrfInput.value = "{{ csrf_token() }}";
    form.appendChild(csrfInput);

    // Mobile number
    const mobileInput = document.createElement('input');
    mobileInput.type = 'hidden';
    mobileInput.name = "mobile_number";
    mobileInput.value = mobile;
    form.appendChild(mobileInput);

    // OTP
    const otpInput = document.createElement('input');
    otpInput.type = 'hidden';
    otpInput.name = "otp";
    otpInput.value = otp;
    form.appendChild(otpInput);

    // Type = login
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = "type";
    typeInput.value = "login";
    form.appendChild(typeInput);

    // Append form to body and submit
    document.body.appendChild(form);
    form.submit();
}
</script>







</body>
</html>