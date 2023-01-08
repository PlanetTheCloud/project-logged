<?php

/**
 * Signup Route Page
 * Project LOGGED v2
 * ---
 * @author PlanetTheCloud <github.com/PlanetTheCloud>
 */

# Load all the required files and functionalities
require __DIR__ . '/../app/bootstrap.php';

# Set page parameters
Page::setParameters([
    'title' => 'Signup',
    'file' => 'signup.php',
    'captcha_id' => md5(rand(6000, PHP_INT_MAX))
]);

# Deliver translation for Javascript
Page::deliverTranslations([
    "Your website will be available at",
    "Choose a subdomain and extension",
]);

# Add scripts
Page::addScript('src/signup.js'); // TEMPORARY, Change to dist later

# Display the page
Page::render();
