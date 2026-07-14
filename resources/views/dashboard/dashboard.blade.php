   <!DOCTYPE html>
   <html lang="en">

   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Document</title>
       <link rel="preconnect" href="https://fonts.googleapis.com">
       <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
       <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
           rel="stylesheet">

       <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
       <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
   </head>

   <body>
       @include('layouts.sidebar')
       @include('layouts.header2')
   </body>

   </html>