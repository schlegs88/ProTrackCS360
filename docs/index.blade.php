<!DOCTYPE html>

<html>
    <head>
        <title>Lab 5: Laravel</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel='stylesheet' href="styles.css">

    </head>
    <body>
        <header>
            <h1>Home</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('index') }}" style="color: red;">Home</a></li>
                    <li><a href="{{ route('photos') }}" >Photos</a></li>
                    <li><a href="{{ route('bio') }}">Bio</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}" >Contact</a></li>
                    <li> <a href="https://www.instagram.com/"> <img src="Instagramlogo.png"  height="24" alt="Instagram logo"></a></li>
                    <li> <a href="https://twitter.com/home"> <img src="xlogo.avif"  height="24" alt="Twitter logo"></a></li>
                    <li> <a href="https://www.facebook.com/"> <img src="Facebooklogo.avif"  height="24" alt="Facebook logo"></a></li>
                </ul>
            </nav>
        </header>
        <h2>Welcome to my website!</h2>
        <div class="row">
            <div class="col">
                <img
                    src="joeui.jpg"
                    class="w-100 shadow-1-strong rounded mb-4"
                    alt="Joe Vandal"
                    />

                <img
                    src="towerui.jpg"
                    class="w-100 shadow-1-strong rounded mb-4"
                    alt="UIdaho Tower"
                    />
                <img
                    src="panaui.jpg"
                    class="w-100 shadow-1-strong rounded mb-4"
                    alt="UIdaho Panoramic"
                    />
            </div>

            <div class="col">
                <img
                    src="oldui.jpg"
                    class="w-100 shadow-1-strong rounded mb-4"
                    alt="Old Admin Building"
                    />

                <img
                    src="logoui.png"
                    class="w-100 shadow-1-strong rounded mb-4"
                    alt="UIdaho Logo"
                    />

            </div>

            <div class="col">
                <img
                    src="clockui.jpg"
                    class="w-100 shadow-1-strong rounded mb-4"
                    alt="UIdaho Clocktower"
                    />

                <img
                    src="brickui.jpg"
                    class="w-100 shadow-1-strong rounded mb-4"
                    alt="UIdaho Brick Building"
                    />
            </div>
        </div>

    </body>
</html>
