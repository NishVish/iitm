<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout Page</h1>
    <p>Review your order before payment.</p>

    <form method="POST" action="/checkout">
        @csrf
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>