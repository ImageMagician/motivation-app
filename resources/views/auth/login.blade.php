<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
</head>
<body>
    <div style="max-width:320px; margin:80px auto; font-family: sans-serif">
        <h1>Admin Login</h1>

        @if ($errors->any())
            <p style="color:red">
                {{ $errors->first() }}
            </p>
        @endif

        <form action="/login" method="post">
            @csrf
            <p>
                <input type="email"
                      name="email"
                      placeholder="Email"
                      value="{{ old('email') }}"
                      required
                      style="width:100%; padding:.25rem"
                />
            </p>
            <p>
                <input type="password"
                       name="password"
                       placeholder="Password"
                       required
                       style="width:100%; padding: .25rem"
                />
            </p>
            <p>
                <label for="remember">
                    <input type="checkbox"
                           name="remember"
                    />
                        Remember Me
                </label>
            </p>
            <p>
                <button type="submit">Log In</button>
            </p>
        </form>
    </div>
</body>
</html>
