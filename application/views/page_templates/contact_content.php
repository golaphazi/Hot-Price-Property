<div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Contact page</h1>               
                    </div>
                </div>
            </div>
        </div>
        <!-- End page header -->

        <!-- property area -->
        <div class="content-area recent-property padding-top-40" style="background-color: #FFF;">
            <div class="container">  
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        $sms_alert = $this->session->userdata('message');
                        if ($sms_alert) {
                            ?>

                            <div class="alert alert-success"> <?php echo $sms_alert; ?> </div> 

                            <?php
                        }
                        $this->session->unset_userdata('message');
                        ?>
                    </div>
                    <div class="col-md-8 col-md-offset-2"> 
                        <div class="" id="contact1">                        
                            <div class="row">
                                <div class="col-sm-4">
                                    <h3><i class="fa fa-map-marker"></i> Address</h3>
                                    <p>Suite 2, 
                                        <br>13 Blackburn St 
                                        <br>Maddington WA 6109 
                                        <br>
                                        <strong>Australia</strong>
                                    </p>
                                </div>
                                <!-- /.col-sm-4 -->
                                <div class="col-sm-4">
                                    <h3><i class="fa fa-phone"></i> Call center</h3>
                                    <p class="text-muted">This number is toll free if calling from
                                        Great Britain otherwise we advise you to use the electronic
                                        form of communication.</p>
                                   <!-- <p><strong><a href="tell:1800 552 163">+ 1800 552 163</a></strong></p> -->
                                </div>
                                <!-- /.col-sm-4 -->
                                <div class="col-sm-4">
                                    <h3><i class="fa fa-envelope"></i> Electronic support</h3>
                                    <p class="text-muted">Please feel free to write an email to us or to use our electronic ticketing system.</p>
                                    <ul>
                                        <li><strong><a href="mailto:support@hotpriceproperty.com">support@hotpriceproperty.com</a></strong>   </li>
                                        <li><strong><a href="#">Ticketio</a></strong> - our ticketing support platform</li>
                                    </ul>
                                </div>
                                <!-- /.col-sm-4 -->
                            </div>
                            <!-- /.row -->
                            <hr>
                            <div id="map">
                                <?php
                                    $map = '';
                                    $map .= 'Suite 2';
                                    $map .= '13 Blackburn St';
                                    $map .= 'Maddington WA 6109';
                                    $map .= 'Australia';
                                    $map = str_replace(' ', '+', $map); 
                                ?>
                                <iframe frameborder="0" height="320" style="border:0px; width:100%; " src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBlxGdYL9gxyiHesq8ft2MdEMnoP35BZzs&q=<?= $map; ?>" allowfullscreen> </iframe>
                            </div>
                            <hr>
                            <h2>Contact form</h2>
                            <?= form_open( SITE_URL.'contact', ['id' => 'contact_from', 'name' => 'contact_from']); ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="firstname">Firstname</label>
                                            <input type="text" name="f_name" class="form-control" id="firstname">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname">Lastname</label>
                                            <input type="text" name="l_name" class="form-control" id="lastname">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="contact_email" class="form-control" id="email">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="subject">Subject</label>
                                            <input type="text" name="subject" class="form-control" id="subject">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea id="message" name="contact_message" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" name="contactMessage" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send message</button>
                                    </div>
                                </div>
                                <!-- /.row -->
                            <?= form_close(); ?>
                        </div>
                    </div>    
                </div>
            </div>
        </div>