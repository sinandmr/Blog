<?php 
echo defined('guvenlik') ? null : die();
?>       
       <footer id="footer">

            <div class="copyright-content">
                <div class="container">
                    <div class="copyright-text pull-left">Sinan Demir &copy; 2021</div>
                    <div class="copyright-text pull-right">
                        <?php
                         $sosyal = $db->prepare("SELECT * FROM sosyalmedya WHERE durum=:d");
                         $sosyal->execute([':d' => 1]);
                         if($sosyal->rowCount()){
                             foreach($sosyal as $medya){
                             echo '<a style="margin:0 3px" target="_blank" href="'.$medya['link'].'" class="fa fa-'.$medya['ikon'].' fa-lg"></a>';
                             echo '    ';}
                         }
                         ?>

                    </div>
                </div>

            </div>
        </footer>
        <!-- end: Footer -->

        </div>
        <!-- end: Body Inner -->

        <!-- Scroll top -->
        <a id="scrollTop"><i class="icon-chevron-up1"></i><i class="icon-chevron-up1"></i></a>

        <!--Plugins-->
        <script src="js/jquery.js?v=<?=time()?>"></script>
        <script src="js/plugins.js?v=<?=time()?>"></script>

        <!--Template functions-->
        <script src="js/sweetalert/sweetalert.min.js"></script>
        <script src="js/ajax.js?v=<?=time()?>"></script>
        <script src="js/functions.js"></script>
        <script src="https://use.fontawesome.com/24eacb6277.js"></script>
        <?=$arow->analytics_kodu?>
        </body>

        </html>