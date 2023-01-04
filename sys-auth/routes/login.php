<?php

/**
 * Login Route Page
 * Project LOGGED v2
 * ---
 * @author PlanetTheCloud <github.com/PlanetTheCloud>
 */

# Load all the required files and functionalities
require '../app/bootstrap.php';

# Set page parameters
Page::setParameters([
    'title' => 'Login',
    'file' => 'login.php'
]);

# Add scripts
Page::addScript('src/login.js'); // TEMPORARY, Change to dist later

# Display the page
Page::render();
