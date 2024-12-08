<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
  $page_title = 'All Image';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php $keyboard_files = find_all('keyboard');?>
<?php
if (isset($_POST['submit'])) {
  $photo = new keyboard();
  $photo->upload($_FILES['file_upload']);
  
  if ($photo->process_keyboard()) {
      $session->msg('s', 'Barcode Photo has been uploaded.');
      redirect('bar3.php?success=true'); // Redirect with success parameter
  } else {
      $js_error_msgs[] = "" . join($photo->errors);
  }
}


?>

<?php include_once('layouts/header.php'); ?>
<!-- Check if there is an error message (from the URL) -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'true'): ?>
  <script src="css/sweetalert.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorMessage = "<?php echo htmlspecialchars($_GET['message']); ?>"; 
            swal("Error", errorMessage, "error");
        });
    </script>
<?php endif; ?>
<!--END-->
<center><h1>Add Barcode|Keyboard</h1></center>

     <div class="row">

      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="col-md-12">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
          <div  style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
            <span style="text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);">All Photos</span>
            <div class="pull-right">
              <form class="form-inline" action="bar3" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-btn">
                    <input   style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="file" name="file_upload" multiple="multiple" class="btn btn-primary btn-file"/>
                 </span>

                 <button   style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="submit" name="submit" class="btn btn-default">Upload</button>
               </div>
              </div>
             </form>
            </div>
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">#</th>
                  <th class="text-center">Photo</th>
                  <th class="text-center">Photo Name</th>
                  <th class="text-center" style="width: 20%;">Photo Type</th>
                  <th class="text-center" style="width: 50px;">Actions</th>
                </tr>
              </thead>
                <tbody>
                <?php foreach ($keyboard_files as $keyboard_file): ?>
                <tr class="list-inline">
                 <td class="text-center"><?php echo count_id();?></td>
                  <td class="text-center">
                      <img src="uploads/products/<?php echo $keyboard_file['file_name'];?>" class="img-thumbnail" />
                  </td>
                <td class="text-center">
                  <?php echo $keyboard_file['file_name'];?>
                </td>
                <td class="text-center">
                  <?php echo $keyboard_file['file_type'];?>
                </td>
                <td class="text-center">
                <a href="edit_bar3.php?id=<?php echo (int) $keyboard_file['id'];?>" class="btn btn-info btn-xs"  title="Edit">
                    <span class="glyphicon glyphicon-edit"></span>
                  </a>
                  <a href="delete_bar3.php?id=<?php echo (int) $keyboard_file['id'];?>" class="btn btn-danger btn-xs"  title="Delete">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                </td>
               </tr>
              <?php endforeach;?>
            </tbody>
          </div>
        </div>
      </div>
</div>
<?php include_once('layouts/footer.php'); ?>
<?php if (!empty($js_error_msgs)): ?>
  <script src="css/sweetalert.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorMessages = <?php echo json_encode($js_error_msgs); ?>;
            errorMessages.forEach(function(msg) {
                swal({
                    title: "",
                    text: msg,
                    icon: "warning",
                    dangerMode: true
                });
            });
        });
    </script>
<?php endif; ?>
<script src="css/sweetalert.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    let successMessage = "";

    // Handle success message for photo uploads
    if (successParam === 'true') {
        if (urlParams.get('delete_photo')) {
            // Handle photo deletion (if needed, add code here)
        } else if (urlParams.get('Photos')) { 
            successMessage = "Successfully Updated Barcode Photos.";
        } else {
            successMessage = "Barcode Photo has been uploaded.";
        }

        // Show success message if photo is uploaded
        if (successMessage) {
            swal("", successMessage, "success")
                .then((value) => {
                  window.location.href = href; 
                });
        }
    }

    // Add confirmation before deletion
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default behavior (directly following the link)
            const href = this.getAttribute('href'); // Get the link (URL) of the delete button
            swal({
              title: "Are you sure?",
              text: "Once deleted, this barcode photo cannot be recovered!",
              icon: "warning",
              buttons: ["Cancel", "Delete"],
              dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    // If user confirms, show success message then redirect to delete URL
                    swal("Barcode Photo deleted successfully.", {
                        icon: "success",
                    }).then(() => {
                        window.location.href = href; // Proceed with the deletion
                    });
                } 
            });
        });
    });
});
</script>





