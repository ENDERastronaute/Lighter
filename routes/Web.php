<?php

use Server\Router\Router;

Router::GET('/', function () { return view('welcome'); });

