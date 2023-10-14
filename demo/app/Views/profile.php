        <div class="row justify-content-center">
            <div class="col-9 mt-3">
                <div class="card">
                    <div class="card-body p-5">
                        <h5 class="card-title">Profile</h5>
                        <hr>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="avatar-container">
                                    <img src="<?php echo $filename; ?>" alt="Avatar" class="avatar rounded-circle img-fluid" style="height: 200px; width: 200px;">
                                    <?= form_open_multipart(base_url() . 'profile/upload_image') ?>
                                        <input type="file" name="image" id="image">
                                        <br>
                                        <button type="submit" name="submit-upload" id="submit-upload">Upload</button>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                        <!-- Image processing -->
                        <?php if (isset($success)): ?>
                            <?= form_open(base_url('profile/select_image')) ?>
                                <h3>Choose a profile picture:</h3>
                                <div>
                                    <?= form_radio('profile-picture', $original, TRUE, ['id' => 'original-image-radio']) ?>
                                    <?= form_label('Original Image', 'original-image-radio') ?>
                                    <br>
                                    <img src="<?= $original ?>" style="height: 200px; width: 200px;">
                                </div>
                                <div>
                                    <?= form_radio('profile-picture', $rot, FALSE, ['id' => 'rotated-image-radio']) ?>
                                    <?= form_label('Rotated Image', 'rotated-image-radio') ?>
                                    <br>
                                    <img src="<?= $rot ?>" style="height: 200px; width: 200px;">
                                </div>
                                <div>
                                    <?= form_radio('profile-picture', $crop, FALSE, ['id' => 'cropped-image-radio']) ?>
                                    <?= form_label('Cropped Image', 'cropped-image-radio') ?>
                                    <br>
                                    <img src="<?= $crop ?>" style="height: 200px; width: 200px;">
                                </div>
                                <?= form_button(['name' => 'submit-profile', 'id' => 'submit-profile', 'type' => 'submit', 'content' => 'Save Profile Picture', 'class' => 'btn btn-primary my-3']) ?>
                            <?= form_close() ?>
                        <?php endif; ?>

                        <?php if (isset($error)): ?>
                            <div class="form-group">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>
                        <!-- Email and change password -->
                        <div class="col-12">
                            <?php echo form_open(base_url('profile/edit_profile')) ?>
                                <div class="form-group mb-3">
                                    <?php echo form_label('Username', 'username'); ?>
                                    <?php echo form_input(['name' => 'username', 'id' => 'username', 'value' => $username, 'class' => 'form-control', 'required' => 'required']); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="d-flex flex-row">
                                        <?php echo form_label('Email', 'email'); ?>
                                        <?php if ($verification_status == 1): ?>
                                            <button type="button" id="email-verified" class="btn btn-outline-success btn-sm disabled ms-1 mb-1" disabled>Verified</button>  
                                        <?php endif; ?>
                                    </div>
                                    <?php echo form_input(['name' => 'email', 'id' => 'email', 'value' => $email, 'class' => 'form-control', 'required' => 'required']); ?>
                                </div>
                                <div class="form-group mb-3">
                                    <?php echo form_submit(['name' => 'submit', 'value' => 'save', 'class' => 'btn btn-primary']); ?>
                                </div>
                            <?php echo form_close() ?>
                        </div>
                        <!-- Google Map -->
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAPS_API_KEY') ?>&libraries=places&callback=initMap" async defer></script>
    <script>
        function initMap() {
            // Create a map object and specify the initial location
            var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 50, lng: 150.644 }, // Set initial latitude and longitude
            zoom: 8, // Set initial zoom level
            });

        // Get the user's current location
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var userLatLng = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
            };

            // Set the map's center to the user's current location
            map.setCenter(userLatLng);

            // Add a marker at the user's current location
            var marker = new google.maps.Marker({
            position: userLatLng,
            map: map,
            title: 'You are here',
            });
        }, function () {
                // Handle geolocation errors
                handleLocationError(true, map.getCenter());
            });
            } else {
            // Browser doesn't support geolocation
            handleLocationError(false, map.getCenter());
            }
        }

        function handleLocationError(browserHasGeolocation, pos) {
            var infoWindow = new google.maps.InfoWindow();
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }
    </script>
