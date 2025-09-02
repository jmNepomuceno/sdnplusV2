<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("../links/header_link.php") ?>
    <link rel="stylesheet" href="../assets/css/login.css?v=<?php echo time(); ?>">
    <title>Document</title>

    <style>
        .custom-box-shadow {
            box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;  
        }

        canvas{ 
            display: block; vertical-align: bottom; 
        } /* ---- particles.js container ---- */ 

        #particles-js{ 
            position:absolute; width: 100%; height: 100%; background-color: #86A789; background-repeat: no-repeat; background-size: cover; background-position: 50% 50%; 
        } 
        /* ---- stats.js ---- */ 

        .js-count-particles{ 
            font-size: 1.1em; 
        } 

        #stats, .count-particles{ 
            -webkit-user-select: none; margin-top: 5px; margin-left: 5px; 
        } 

        #stats{ border-radius: 3px 3px 0 0; overflow: hidden; 
        } 

        .count-particles{ 
            border-radius: 0 0 3px 3px; 
        }

        .custom-modal-width {
            max-width: 80vw; /* Adjust the width as per your requirements */
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div> 
    <div class="count-particles"> <span class="js-count-particles">--</span> particles </div> <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> 

    <div class="header-title">
        <h1>Service Delivery Network Plus (SDN+)</h1>
        <h2>Bataan General Hospital and Medical Center</h2>
    </div>

    <div class="login-card custom-box-shadow">
        <h2>Login</h2>
        <form id="login-form" method="POST">
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" id="username-inp" name="username" placeholder="Username" required autocomplete="off">
            </div>
            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password-inp" name="password" placeholder="Password" required autocomplete="off">
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>

        <!-- response message -->
        <div id="login-response"></div>

        <div class="extra-links">
            <a href="#">Forgot Password?</a>
        </div>
    </div>


    
    <?php include("../links/script_links.php") ?>
    <script src="https://rawgit.com/mrdoob/stats.js/r16/build/stats.min.js"></script>
    <script type="text/javascript">
        particlesJS("particles-js", {
            "particles": {
                "number": {"value": 6, "density": {"enable": true, "value_area": 800}},
                "color": {"value": "#4F6F52"},
                "shape": {
                    "type": "polygon",
                    "stroke": {"width": 0, "color": "#000"},
                    "polygon": {"nb_sides": 5},
                    "image": {"src": "img/github.svg", "width": 100, "height": 100}
                },
                "opacity": {
                    "value": 0.3,
                    "random": true,
                    "anim": {"enable": false, "speed": 1, "opacity_min": 0.1, "sync": false}
                },
                "size": {
                    "value": 160,
                    "random": false,
                    "anim": {"enable": true, "speed": 10, "size_min": 40, "sync": false}
                },
                "line_linked": {"enable": false, "distance": 200, "color": "#ffffff", "opacity": 1, "width": 2},
                "move": {
                    "enable": true,
                    "speed": 8,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {"enable": false, "rotateX": 600, "rotateY": 1200}
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {"onhover": {"enable": false, "mode": "grab"}, "onclick": {"enable": false, "mode": "push"}, "resize": true},
                "modes": {
                    "grab": {"distance": 400, "line_linked": {"opacity": 1}},
                    "bubble": {"distance": 400, "size": 40, "duration": 2, "opacity": 8, "speed": 3},
                    "repulse": {"distance": 200, "duration": 0.4},
                    "push": {"particles_nb": 4},
                    "remove": {"particles_nb": 2}
                }
            },
            "retina_detect": true
        });

        var count_particles, stats, update;
        
        // Correct initialization of Stats object
        stats = new Stats(); 
        stats.setMode(0);
        stats.domElement.style.position = 'absolute';
        stats.domElement.style.left = '0px';
        stats.domElement.style.top = '0px';
        document.body.appendChild(stats.domElement);
        document.body.removeChild(stats.domElement);
        count_particles = document.querySelector('.js-count-particles');

        update = function() {
            stats.begin();
            stats.end();
            if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
                count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
            }
            requestAnimationFrame(update);
        };

        requestAnimationFrame(update);
    </script>

    <script src="../assets/js/login/login.js?v=<?php echo time(); ?>"></script>
</body>
</html>