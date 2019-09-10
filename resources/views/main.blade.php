<!doctype html>
<html lang="en">
    <head>
        @include('partials._head')
    </head>
  <body>
    @include('partials._nav')
    <!-- Default navbar -->

    <div class="container">
      @include('partials._messages')

    @include('partials._footer')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    </div><!--end of container div-->    
    @include('partials._javascript')

    @yield('script')
    
  </body>
</html>