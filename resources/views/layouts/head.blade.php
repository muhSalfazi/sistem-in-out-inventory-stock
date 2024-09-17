<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Your Default Title')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logoTitle.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/assets/css/styles.min.css') }}" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('../assets/images/icon-kbi.png') }}" width="5%" alt="" />
    @stack('head')

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">


    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">


    <!-- Include Simple DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">

    <!-- Include Simple DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/umd/simple-datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Tablesaw CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tablesaw/3.0.7/tablesaw.css">

    <!-- Include Tablesaw JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tablesaw/3.0.7/tablesaw.jquery.js"></script>




</head>
