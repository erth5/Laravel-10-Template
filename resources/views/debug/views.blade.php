<?php

$path = public_path('../resources/views');

$files = File::allFiles($path);

dd($files);

