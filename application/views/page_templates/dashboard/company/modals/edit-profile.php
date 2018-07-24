
<?= form_open('hpp/admin/manage_admin', [ 'id' => 'EditAdminProfile', 'name' => 'EditadminProfile', 'class' => '']); ?>
    <div class="modal-body">
        <div class="form-group">
            <label for="AdminFullName" class="form-control-label">Admin Full Name :</label>
            <input onblur="removeNumber(this)" type="text" id="AdminFullName" name="admin_full_name" value="<?= $select_user[0]['ADMIN_NAME']; ?>" class="form-control">
            <input type="hidden" id="AdminFullName" name="admin_id" value="<?= $select_user[0]['ADMIN_ID']; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="UserName" class="form-control-label">User name:</label>
            <input onblur="removeNumber(this)"  type="text" name="admin_user_name" value="<?= $select_user[0]['ADMIN_USER']; ?>" class="form-control" id="UserName" >
        </div>
        <div class="form-group">
            <label for="EmailID" class="form-control-label">Email ID:</label>
            <input type="email" name="email_id" value="<?= $select_user[0]['ADMIN_EMAIL']; ?>" class="form-control" id="EmailID">
        </div>
        <div class="form-group">
            <label for="AdminType" class="form-control-label">Admin Role: </label>
            <select name="admin_role" id="AdminType" class="form-control" required="">
                <option <?php if($select_user[0]['ADMIN_TYPE'] == 'Super' ){ echo 'selected';} ?> value="Super">Super</option>
                <option <?php if($select_user[0]['ADMIN_TYPE'] == 'Admin' ){ echo 'selected';} ?> value="Admin">Admin</option>
                <option <?php if($select_user[0]['ADMIN_TYPE'] == 'Manager' ){ echo 'selected';} ?> value="Manager">Manager</option>
            </select>                          
        </div>
        
        <div class="form-group manage-admin-radio">
            Activation Status : 
            <label class="radio-inline mar-l-20">
                <input <?php if ($select_user[0]['ADMIN_STATUS'] == 'Active') { echo 'checked'; } ?> type="radio" name="admin_status" value="Active" class="widthUnset"> Active
            </label>
            <label class="radio-inline">
                <input <?php if ($select_user[0]['ADMIN_STATUS'] == 'DeActive') {echo 'checked'; } ?> type="radio" name="admin_status" value="DeActive" class="widthUnset"> De-Active
            </label>
        </div> 
    </div> <!-- end of modal-body -->
    
    <div class="modal-footer">
        <input  type="submit" name="updateAdminProfile" value="Update User Info" id="EditUserInfo" class="btn btn-primary">
    </div>

<?= form_close(); ?>

    
    
    
<script type="text/javascript">

jQuery(document).ready(function(){
    $("#EditAdminProfile").validate({
        rules: {
            admin_full_name: {
                required: true,
            },
            admin_user_name: {
                required: true,
            },
            admin_role: {
                required: true
            },
            admin_status: {
                required: true,
            }
            
        },
        messages: {
            admin_full_name: {
                required: "Please Admin Full Name",
            },
            admin_user_name: {
                required: "Please Enter Admin User Name",
            },
            admin_role: {
                required: "Please Select Admin Role",
            },
            admin_status: {
                required: "Please Admin Status",
            }
        },
        
    });
});

</script>     