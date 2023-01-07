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
    'file' => 'signup.php'
]);

# Deliver translation for Javascript
Page::deliverTranslations([
// LATER
]);

# Add scripts
Page::addScript('src/signup.js'); // TEMPORARY, Change to dist later

# Display the page
Page::render();
