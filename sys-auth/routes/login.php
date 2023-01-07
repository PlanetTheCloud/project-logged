<?php

/**
 * Login Route Page
 * Project LOGGED v2
 * ---
 * @author PlanetTheCloud <github.com/PlanetTheCloud>
 */

# Load all the required files and functionalities
require __DIR__ . '/../app/bootstrap.php';

# Set page parameters
Page::setParameters([
    'title' => 'Login',
    'file' => 'login.php'
]);

# Deliver translation for Javascript
Page::deliverTranslations([
    'Username is not valid',
    'Password cannot be empty',
    'Password is too short',
]);

# Add scripts
Page::addScript('src/login.js'); // TEMPORARY, Change to dist later

# Display the page
Page::render();
