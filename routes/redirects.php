<?php

use Illuminate\Support\Facades\Route;

// RedirectPermanent /repertoire/page-a-rediriger.html http://www.exemple.net/repertoire/page-de-destination.html

Route::permanentRedirect('/old-url', '/new-url');