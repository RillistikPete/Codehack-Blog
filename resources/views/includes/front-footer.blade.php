
    <!-- Footer -->
    <div class="container">
        <footer>
            <div class="row">
                <div class="col-lg-12">
                <p>Copyright &copy; G. Forrest Blog {{now()->year}}</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- for CommonMark emit of ```csharp e.g. -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11/build/styles/github-dark.min.css">
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11/build/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>

    @yield('scripts')

</body>
</html>
