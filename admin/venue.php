<?php
include('db_connect.php');

// Query to fetch venues
$venues = $conn->query("SELECT * FROM venue");
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">List of Venues</h4>
                    <a href="index.php?page=manage_venue" class="btn btn-primary btn-sm float-right">
                        <i class="fa fa-plus"></i> New Venue
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Venue</th>
                                    <th>Address</th>
                                    <th>Description</th>
                                    <th>Rate</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                while($row = $venues->fetch_assoc()): ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td><?php echo ucwords($row['venue']) ?></td>
                                    <td><?php echo $row['address'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td class="text-right"><?php echo number_format($row['rate'], 2) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary edit_venue" data-id="<?php echo $row['id'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger delete_venue" data-id="<?php echo $row['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    td, th {
        vertical-align: middle !important;
    }
    td p {
        margin: unset;
    }
    img {
        max-width: 100px;
        max-height: 150px;
    }
</style>

<script>
    $(document).ready(function(){
        // Initialize DataTables
        $('table').dataTable();

        // Edit button click handler
        $('.edit_venue').click(function(){
            var venue_id = $(this).data('id');
             location.href = "index.php?page=manage_venue&id=" + venue_id;
        });

        // Delete button click handler
        $('.delete_venue').click(function(){
            var venue_id = $(this).data('id');
            // Implement confirmation modal or direct delete function call here
            // Example:
            _conf("Are you sure to delete this venue?", "delete_venue", [venue_id]);
        });

        // Function to handle deletion after confirmation
        function delete_venue(venue_id) {
            stvenue_load();
            $.ajax({
                url: 'ajax.php?action=delete_venue',
                method: 'POST',
                data: { id: venue_id },
                success: function(resp){
                    if (resp == 1) {
                        alert_toast("Venue successfully deleted", 'success');
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast("Failed to delete venue. Response: " + resp, 'error');
                    }
                },
                error: function(xhr, status, error){
                    console.error("AJAX Error: " + status + " " + error);
                    alert_toast("An error occurred while trying to delete the venue: " + error, 'error');
                }
            });
        }
    });
</script>
