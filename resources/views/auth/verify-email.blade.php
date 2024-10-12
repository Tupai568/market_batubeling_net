<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello!!</title>
</head>
{{-- 
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        width: 100%;
        padding: 5rem;
        background: #EDF2F7;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .box {
        padding: 2rem;
        width: 100%;
        background: #fff;
    }

    h1 {
        color: #3D4852;
        font-size: 1.2rem;
    }

    a {
        color: green
    }

    p {
        margin: 1rem 0;
        color: gray;
        font-size: .9rem;
    }

    p:nth-child(6) {
        font-size: .7rem;
    }

    button {
        display: block;
        background: #2D3748;
        color: #fff;
        outline: none;
        border: none;
        margin: auto;
        border-radius: 10px;
        font-size: .9rem;
        padding: .6rem 1rem;
    }
</style> --}}

<body style="margin: 0; padding: 0; box-sizing: border-box;">
    <div class="container"
        style="width: 100%; padding: 1rem 0; background: #EDF2F7;display: flex;justify-content: center; align-items: center;">
        <div class="box" style="padding: 2rem; width: 100%; background: #fff;">
            <h1 style="color: #3D4852; font-size: 1.2rem;">Haloo!!</h1>
            <p style="margin: 1rem 0;color: gray;font-size: .9rem;">Please click the button below to verify your email
                address</p>
            <a href="{{ $user }}"><button
                    style="display: block;background: #2D3748;color: #fff;outline: none;border: none;margin: auto;border-radius: 10px;font-size: .9rem;padding: 1rem;">Verify
                    Email Adress</button>
            </a>
            <p style="margin: 1rem 0; color: gray; font-size: .9rem;">If you did not create an account, no further
                action is required.</p>
            <hr>
            <p style="margin: 1rem 0; color: gray; font-size: .7rem;">If you're having trouble clicking the "Verify
                Email Address" button, copy and paste the URL below
                into
                your
                web browser: <a href="{{ $user }}" style="color: green">Link verify email address</a></p>
        </div>
    </div>
    </div>
</body>

</html>
