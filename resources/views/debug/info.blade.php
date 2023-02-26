@extends('debug.layout')
@section('c')
    <?php
    echo 'Current PHP version: ' . phpversion();
    ?>

    <?php
    phpinfo();
    ?>
@endsection
