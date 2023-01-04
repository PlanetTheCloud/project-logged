<?php

/**
 * Signup Route Page
 * Project LOGGED v2
 * ---
 * @author PlanetTheCloud <github.com/PlanetTheCloud>
 */

# Load all the required files and functionalities
require '../app/bootstrap.php';

# Set page parameters
Page::setParameters([
    'title' => 'Signup',
    'file' => 'signup.php'
]);

# Display the page
Page::render();
