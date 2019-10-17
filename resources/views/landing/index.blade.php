<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.title') }}</title>
    <link href="{{ asset('resources/views/default/images/logo.png') }}" rel="shortcut icon" sizes="196x196">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i|PT+Serif:700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/views/landing/dist/css/style.css') }}">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" id="ao_optimized_gfonts" href="https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C400%2C600%2C800%7CDosis%3A300%2C600%7CRoboto:400,600%7CRoboto:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" />
</head>
<body class="is-boxed has-animations specialfont">
    <div class="body-wrap boxed-container">
        <header class="site-header">
            <div class="container">
                <div class="site-header-inner">
                    <div class="brand header-brand">
                        <h1 class="m-0">
                            <a href="{{ url('/') }}" class="specialfont" style="color: white; text-decoration: none;font-size: 25px">Autobot</a>
                        </h1>
                    </div>
                    <ul class="header-links list-reset m-0">
                        @guest
                            <li>
                                <a href="{{ url('login') }}">Login</a>
                            </li>
                            <li>
                                <a class="button button-sm button-shadow" href="{{ url('register') }}">Signup</a>
                            </li>
                        @else
                        <li>
                            <a href="{{ url('login') }}">Hi, {{ Auth::user()->name }}</a>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </header>

        <main>
            <section class="hero text-light text-center">
                <div class="container-sm">
                    <div class="hero-inner">
                        <h1 class="hero-title h2-mobile mt-0 is-revealing specialfont">Professional Instagram Automation Tools</h1>
                        <p class="hero-paragraph is-revealing">Use Instagram Bot to auto follow, auto like, auto comment, auto unfollow, auto DM, post, schedule and much more then grow your network with real followers and save your precious time.</p>
                        <p class="hero-cta is-revealing"><a class="button button-secondary button-shadow" href="{{ url('register') }}">Get started now</a></p>
                        <div class="hero-media"><img src="{{asset('resources/views/landing/image/land.png') }}"></div>
                    </div>
                </div>
            </section>

            <section class="features section text-center">
                <div class="container">
                    <div class="features-inner section-inner has-top-divider">
                        <h2 class="section-title mt-0 specialfont">Some features</h2>
                        <div class="features-wrap">
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none" fill-rule="evenodd">
                                                <path fill="#667eea" d="M48 16v32H16z"/>
                                                <path fill="#764ba2" d="M0 0h32v32H0z"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile specialfont">Auto Follow</h4>
                                    <p class="text-sm specialfont">Auto follow feature is one of the best ways to grow your follower base organically. You can target hashtags or user accounts and system will do auto following for you.</p>
                                </div>
                            </div>
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none" fill-rule="evenodd">
                                                <path fill="#667eea" d="M48 16v32H16z"/>
                                                <path fill="#764ba2" d="M0 0v32h32z"/>
                                                <circle fill="#764ba2" cx="29" cy="9" r="4"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile specialfont">Auto Unfollow</h4>
                                    <p class="text-sm specialfont">Auto unfollow feature saves your time/nerves and allows you to automatically unfollow the accounts that you don’t want to follow anymore.</p>
                                </div>
                            </div>
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none" fill-rule="evenodd">
                                                <path fill="#667eea" d="M0 0h32v32H0z"/>
                                                <path fill="#764ba2" d="M16 16h32L16 48z"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile specialfont">Auto Like</h4>
                                    <p class="text-sm specialfont">Auto like feature allows you to automate the liking of content. No need to find or and scroll through posts anymore! You can use the Instagram auto like feature to target users or hashtags.</p>
                                </div>
                            </div>
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none" fill-rule="evenodd">
                                                <path d="M32 40H0c0-8.837 7.163-16 16-16s16 7.163 16 16z" fill="#667eea" style="mix-blend-mode:multiply"/>
                                                <path fill="#667eea" d="M12 8h8v8h-8z"/>
                                                <path fill="#764ba2" d="M32 0h16v48H32z"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile specialfont">Auto Comment</h4>
                                    <p class="text-sm specialfont">Auto Comment feature allows you to increase engagement by commenting on the posts of other users. You can create multiple custom messages that are sent to the posts that are targeted by users or hashtags.</p>
                                </div>
                            </div>
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none" fill-rule="evenodd">
                                                <path fill="#667eea" d="M0 0h32v32H0z"/>
                                                <path fill="#764ba2" d="M16 16h32L16 48z"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile specialfont">Auto Repost</h4>
                                    <p class="text-sm specialfont">Auto Repost is a fantastic tool to keep your social feed active. Repost feature allows you to temporarily repost content from other users or hashtags feeds and this way your account is always active!</p>
                                </div>
                            </div>
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none" fill-rule="evenodd">
                                                <path fill="#667eea" d="M48 16v32H16z"/>
                                                <path fill="#764ba2" d="M0 0h32v32H0z"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile specialfont">Auto Direct Messages</h4>
                                    <p class="text-sm specialfont">Auto DM feature sends to every new follower or your targets automatically a message that you can customize. Auto DM a great way to welcome or thank your new followers and engage with them. No need to do manual outreach anymore!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="features-extended section">
                <div class="container">
                    <div class="features-extended-inner section-inner has-top-divider">
                        <div class="features-extended-header text-center">
                            <div class="container-sm">
                                <h2 class="section-title mt-0 specialfont">Schedule</h2>
                                <p class="section-paragraph specialfont">Smart features for content creation and scheduling</p>
                            </div>
                        </div>
                        <div class="feature-extended">
                            <div class="feature-extended-image is-revealing">
                                <img src="{{ asset('resources/views/landing/image/schedule.png') }}">
                            </div>
                            <div class="feature-extended-body">
                                <h3 class="mt-0 specialfont">Auto Post to Instagram</h3>
                                <p>You can use to schedule your Instagram posting. You can create and schedule photo and video posts or even stories.</p>
                            </div>
                        </div>
                        <div class="feature-extended">
                            <div class="feature-extended-image is-revealing">
                                <img src="{{ asset('resources/views/landing/image/systematic.png') }}">
                            </div>
                            <div class="feature-extended-body">
                                <h3 class="mt-0 specialfont">Systematic Posts</h3>
                                <p>You can use the systematic feature to post at regular intervals. System every day automatically post at any time you want.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="features-extended section">
                <div class="container">
                    <div class="features-extended-inner section-inner has-top-divider">
                        <div class="features-extended-header text-center">
                            <div class="container-sm">
                                <h2 class="section-title mt-0 specialfont">And much more..</h2>
                                <p class="section-paragraph specialfont">Sign up to explore the endless features of our system.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="site-footer-inner">
                    <div class="brand footer-brand">
                        <a href="{{ url('/') }}" class="specialfont" style="color: black; text-decoration: none;font-size: 25px"><strong>Autobot</strong></a>
                    </div>
                    <ul class="footer-links list-reset specialfont">
                        <li>
                            <a href="#">Contact</a>
                        </li>
                        <li>
                            <a href="#">About us</a>
                        </li>
                        <li>
                            <a href="#">FAQ's</a>
                        </li>
                        <li>
                            <a href="#">Support</a>
                        </li>
                    </ul>
                    <ul class="footer-social-links list-reset">
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Facebook</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.023 16L6 9H3V6h3V4c0-2.7 1.672-4 4.08-4 1.153 0 2.144.086 2.433.124v2.821h-1.67c-1.31 0-1.563.623-1.563 1.536V6H13l-1 3H9.28v7H6.023z" fill="#764ba2"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Twitter</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 3c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.7 0-3.2 1.5-3.2 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4C.7 7.7 1.8 9 3.3 9.3c-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H0c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4C15 4.3 15.6 3.7 16 3z" fill="#764ba2"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="screen-reader-text">Google</span>
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.9 7v2.4H12c-.2 1-1.2 3-4 3-2.4 0-4.3-2-4.3-4.4 0-2.4 2-4.4 4.3-4.4 1.4 0 2.3.6 2.8 1.1l1.9-1.8C11.5 1.7 9.9 1 8 1 4.1 1 1 4.1 1 8s3.1 7 7 7c4 0 6.7-2.8 6.7-6.8 0-.5 0-.8-.1-1.2H7.9z" fill="#764ba2"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <div class="footer-copyright specialfont">&copy; 2019 Autobot, all rights reserved</div>
                </div>
            </div>
        </footer>
    </div>
    <script src="{{ asset('resources/views/landing/dist/js/main.min.js') }}"></script>
</body>
</html>
