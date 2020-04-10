<header class="main-header">
    <style type="text/css">
        .main-header .logo .logo-mini {
           display: inherit;
           font-size: 19px;
        }
    </style>
    <!-- Logo -->
    <span style="display:none;">{{config('app.name')}}</span>
    <a href="{{ url('/admin/home') }}" class="site_title logo"
       style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <script type="text/javascript">
            var message = "PET - HEALTH"
            var neonbasecolor = "gray"
            var neontextcolor = "white"
            var flashspeed = 150  //in milliseconds
            ///No need to edit below this line/////
            var n = 0
            if (document.all || document.getElementById) {
                document.write('<font color="' + neonbasecolor + '">')
                for (m = 0; m < message.length; m++)
                    document.write('<span id="neonlight' + m + '">' + message.charAt(m) + '</span>')
                document.write('</font>')
            } else
                document.write(message)
            function crossrefaa(number) {
                var crossobj = document.all ? eval("document.all.neonlight" + number) : document.getElementById("neonlight" + number)
                return crossobj
            }
            function neonaa() {
                //Change all letters to base color
                if (n == 0) {
                    for (m = 0; m < message.length; m++)
                        //eval("document.all.neonlight"+m).style.color=neonbasecolor
                        crossrefaa(m).style.color = neonbasecolor
                }
                //cycle through and change individual letters to neon color
                crossrefaa(n).style.color = neontextcolor
                if (n < message.length - 1)
                    n++
                else {
                    n = 0
                    clearInterval(flashing)
                    setTimeout("beginneonaa();", 1500)
                    return
                }
            }
            function beginneonaa() {
                if (document.all || document.getElementById)
                    flashing = setInterval("neonaa();", flashspeed)
            }
            beginneonaa();
        
                </script>
           </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
          </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        

    </nav>
</header>


