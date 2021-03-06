<?php include 'functionList.php';?>
<?php
  $title = "Enter Event Code";
  $navbarlinks = "";
?>
<?php include 'guestHeader.php';?>

      <!-- Content -->
      <div class="container-liquid">
        <!--Grid row-->
        <div class="row" style="margin-top:80px">
          <!--Grid column-->
          <div class="col-sm-12 col-md-6 white-text text-center text-md-left">
            <div class="leftcol ml-auto">
            <h1 class="h1-responsive font-weight-bold animated fadeInLeft">Got your code? </h1>
            <hr class="hr-light animated fadeInLeft">
            <h6 class="mb-3 animated fadeInLeft">Enter the event code (look for a sign near the booth!) or unique code (printed on the top of your photo strip) here to access your photos.</h6>
          </div>

          </div>
          <!--Grid column-->
          <!--Grid column-->
          <div class="col-sm-12 col-md-6 col-xl-5 mb-4">
            <!--Form for event code-->
            <div class="rightcol card animated fadeInRight">
              <div class="card-body">
                <!--Body of event code form-->
                <!--<form method="post" action="gallery.php" class="md-form"> <!-- The action method will need to change according to the PHP code implemeneted, but this is a short work around now.-->
                  <div class="md-form">
                  <i class="fa fa-user prefix white-text active"></i>
                  <input type="text" id="eventCode" name="eventCode" class="white-text form-control">
                  <label for="eventCode" class="active">Code</label>

                  <div class="text-center mt-4">
                    <button id="enterButton" class="btn btn-white">Enter</button> <!-- Event code button -->
                  <br><br>
                    <!--Terms of Use and Privacy Policy text and links-->
                    <h6 style="color: white"><i>By continuing, you agree to the
                    <a style="color:white" data-toggle="modal" href="#myTermsModal">Terms of Use and Privacy Policy</i></a></h6>
                  </div>
                <!--</form>-->
                </div>
              </div>
            </div>
            <!--Form-->
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
        <!-- Terms of Use ...Modal -->
      <div id="myTermsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
           <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                 <h4>Terms of Use and Privacy Notice</h4>
                 <button type="button" style ="align:right" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <p>Thanks for using Little Red Photobooth and our unique Photobooth Management System.
              The services we offer bring event photos to life, enabling guests to access and share
              photos taken in our photobooth during the event and photos uploaded by guests.</p>
              <p>By using the services, you agree to be bind to these Terms.</p>
              <p style="font-weight:bold">What information do we collect?</p>
              <p>No personal information is collected. Access to services are via a unique event code
              or photobooth session code supplied to you by the event host.
              No email or other data is required.</p>
              <p style="font-weight:bold">How do we keep event photos secure?</label>
              <p>All photos that are taken during Photobooth photo sessions or are uploaded from a device
              are kept confidential. Various electronic and physical security systems are maintained
              to ensure the safety of photos.
              Access to photos is restricted and protected by a secure server.
              We reserve the right to delete any photo that we deem in violation of the Terms. </p>
            </div>
           </div>
         </div>
       </div>
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id='modalText'></h4>
            </div>
            <div class="modal-footer">
              <button type="button" id='modalButton' class="btn btn-error" data-dismiss="modal">OK</button>
            </div>
          </div>
        </div>
      </div>

    <!-- SCRIPTS -->
    <script>
      $(document).ready(function() {
          $("#enterButton").click(function(){
            $.post("ajaxSubmitEventCode.php",
            {
                eventCode: document.getElementById('eventCode').value
            },
            function(data, status){
                if(data === "true") {
                  location.href='gallery.php';
                } else {
                  $('#myModal').modal('show');
                  document.getElementById('modalButton').className = "btn btn-danger";
                  document.getElementById('modalText').innerHTML = "Invalid event code";
                }
                
            });
          });
      });
      </script>
    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
</body>
</html>
