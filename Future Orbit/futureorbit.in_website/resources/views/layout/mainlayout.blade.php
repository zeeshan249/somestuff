<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layout.partials.head')
  </head>
  <body>

  <!-- Main Wrapper -->
 
  <div class="main-wrapper">
  @include('layout.partials.header')
  @yield('content')
  @include('layout.partials.footer')
  </div>		
  <!-- /Main Wrapper -->
   @include('layout.partials.footer-scripts')
  </body>
</html>