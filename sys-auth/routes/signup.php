<?php

/**
 * Signup Route Page
 * Project LOGGED v2
 * ---
 * @author PlanetTheCloud <github.com/PlanetTheCloud>
 */

# Load all the required files and functionalities
require __DIR__ . '/../app/bootstrap.php';

# Initialize CSRF Protection
$csrf = new CsrfProtect();

# Set page parameters
Page::setParameters([
    'title' => 'Signup',
    'file' => 'signup.php',
    '_token' => $csrf->token('signup'),
    'captcha_id' => md5(rand(6000, PHP_INT_MAX))
]);

# Deliver translation for Javascript
Page::deliverTranslations([
    "Subdomain must be between 4 to 16 characters in length.",
    "Hypens are not allowed at the end of subdomain.",
    "Only alphanumeric characters and hyphens are allowed.",
    "Your website will be available at",
    "Choose a subdomain and extension",
    "Please enter a valid email address.",
    "Password must be between 6 to 20 characters in length.",
    "Passwords do not match. Please re-enter your password.",
    "Please select an option.",
    "Please enter a valid domain name.",
    "Please enter a valid subdomain name.",
    "Please enter a captcha with 5 characters.",
    "Something went wrong, please try again later.",
    "Bad Server Response"
]);

# Add scripts
Page::addScript('src/signup.js');

# Display the page
Page::render();
