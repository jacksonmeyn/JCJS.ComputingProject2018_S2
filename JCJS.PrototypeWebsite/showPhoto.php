<?php include 'databaseConnection.php';?>
<?php include 'functionList.php';?>

<?php
  $title = "Uploaded Image";
  $photoID = (int)$_GET["PhotoID"];

  session_start();
  if(isset($_SESSION["EventID"])) {
    $eventID = (int)$_SESSION["EventID"];
  } else {
    header("Location: enterEventCode.php?error=1");
  }

  $sql = "SELECT Filename FROM photos WHERE EventID = $eventID AND PhotoID = $photoID;";
  //echo $sql;
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $fileName = $row["Filename"];
    $filePath = "eventPhotos/".$eventID."/".$fileName;
  } else {
      header("Location: 500.php?error=1");
  }  

  $navbarlinks = createNavLink("Event Gallery","gallery.php");
  $navbarlinks .= createNavLink("Upload Photo","upload_photo.php");
?>
<?php include 'guestHeader.php';?>  
<!--Facebook supplied code-->
<div id="fb-root"></div>
<!-- end Facebook supplied code-->
<script>

  //Facebook supplied code
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1&appId=1023726461149386&autoLogAppEvents=1';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
  //End Facebook supplied code
  

function shareToFacebook() {
  FB.getLoginStatus(function(response) {
    if (response.status === 'connected') {
      var accessToken = response.authResponse.accessToken;
    } 
  } );
  
  var imgURL="http://54.153.242.36/eventPhotos/1/2018-8-6-47253A.jpg";//change with your external photo url
  FB.api('/album_id/photos', 'post', {
    message:'photo description',
    url:imgURL        
  }, function(response){

    if (!response || response.error) {
        alert('Error occured');
    } else {
        alert('Post ID: ' + response.id);
    }

  });
}

function uploadToCloudinary() {
  var filePath = "<?php echo $filePath?>";
  var photoID = <?php echo $photoID?>;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    //if (this.readyState == 4 && this.status == 200) {
     document.getElementById("testDiv").innerHTML = this.responseText;
    //}
  };
  xhttp.open("GET", "./scripts/uploadToCloudinary.php?filePath=" + filePath +"&photoID="+ photoID, true);
  xhttp.send();
}

function applyFilter() {
  alert("Entered applyFilter");
  var photoID = <?php echo $photoID?>;
  alert(document.getElementById("filterDropdown").value);
  var filter = document.getElementById("filterDropdown").value;
  if (filter != "") {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      document.getElementById("saveFilter").href = this.responseText;
      document.getElementById("showImage").src = this.responseText;
      saveFilterResult();
      }
    };
    xhttp.open("GET", "./scripts/applyFilter.php?photoID="+ photoID + "&filter=" + filter, true);
    xhttp.send();
  }
  
}
  
</script>
<!-- Content -->
<div class="container-liquid">


  <div class="personal-gallery tz-gallery" style="margin-top:80px">
    <!--Grid row-->
        
    <!-- selected large images -->
    <!-- original image -->
    <div class="row m-0" style="margin-top:10px">
      <!-- <figure class=""> -->
        <img id ="showImage" alt="picture" src='<?php echo $filePath?>' class="img-fluid col-md-12 p-1">
      <!-- </figure> -->
    </div>
    <div id="default-buttons"> <!-- Wrapper div required for show/hide functions to work-->
    <div class="text-center d-flex justify-content-center" style="font-size:25px">
      <!-- delete photo button (host access only)-->
      <?php
      if(isset($_SESSION["HostAccess"])) {
        echo '<button class="btn" onclick="deletePhoto('.$photoID.')">Delete</button>';
      }          
      ?>      
      <!-- save button-->
          <a href="<?php echo $filePath?>" download><button id="saveButton" class="btn">View Full Size</button></a>
      <!-- apply filter-->
          <button class="btn" onclick="filterMode()">Apply Filter</button>

          <span class="align-middle">Share:</span>
      <!-- facebook-->
          <a class="p-2 m-2 fb-ic" >
             <i class="fa fa-facebook red-text" onclick="shareToFacebook()"></i></a>
             <!--Facebook supplied button-->
              <div class="fb-share-button" data-href="<?php echo $filePath?>" data-layout="button_count" data-size="large" data-mobile-iframe="false"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
            <!-- end Facebook supplied button-->
     <!-- instragram-->
          <a class="p-2 m-2 ins-ic">
            <i class="fa fa-instagram red-text"> </i></a>
    </div>
    </div>
    <div id="apply-filter-buttons"> <!-- Wrapper div required for show/hide functions to work-->
    <div class="text-center d-flex justify-content-center" style="font-size:25px">
      <!-- filter dropdown-->
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select filter
        </button>
        <div class="dropdown-menu" id="filterDropdown" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" value="grayscale">Black and White</a>
          <a class="dropdown-item" value="sepia">Sepia</a>
          <a class="dropdown-item" value="cartoonify">Cartoon</a>
        </div>
      </div>
      <!-- apply filter button-->
          <button class="btn" onclick="applyFilter()">Apply</button>
      <!-- cancel filter button-->
          <a href="#"><button class="btn" onclick="cancelFilter()">Cancel</button></a>
    </div>
    </div>

    <div id="save-filter-buttons"> <!-- Wrapper div required for show/hide functions to work-->
    <div class="text-center d-flex justify-content-center" style="font-size:25px">
      <!-- save filter button-->
          <a id="saveFilter" href="#" download><button class="btn" >Save Full Size</button></a>
      <!-- discard filter result button-->
          <a href="#"><button class="btn" onclick="cancelFilter()">Discard</button></a>
    </div>
    </div>
    <div id="testDiv"></div>

  </div>

</div>
  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" role="dialog">
  <div class="modal-dialog">
  <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Are you sure you want to permanently delete this image?</h4>            
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-error" data-dismiss="modal">No</button>
      <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="location.href='delete_photo.php?id=<?php echo $photoID ?>';">Yes</button>
      </div>
      </div>
  </div>
  </div>
<script>
  var fileName = "<?php echo $filePath?>";

  function cancelFilter() {
    document.getElementById("default-buttons").style.display = "block";
    document.getElementById("apply-filter-buttons").style.display = "none";
    document.getElementById("save-filter-buttons").style.display = "none";
    document.getElementById("showImage").src = fileName;
  }

  function filterMode() {
    alert("Entered filtermode");
    //Upload image in preparation for applying filters
    uploadToCloudinary();
    alert("Finished upload");
    document.getElementById("default-buttons").style.display = "none";
    document.getElementById("apply-filter-buttons").style.display = "block";
    document.getElementById("save-filter-buttons").style.display = "none";
  }

  function saveFilterResult () {
    document.getElementById("default-buttons").style.display = "none";
    document.getElementById("apply-filter-buttons").style.display = "none";
    document.getElementById("save-filter-buttons").style.display = "block";
  }

  cancelFilter();

  function deletePhoto() {
    $('#deleteModal').modal('show');
  }  
</script>
<?php include 'ppFooter.php';?>
