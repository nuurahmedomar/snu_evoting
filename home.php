<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
     
    <div class="content-wrapper">
        <div class="container">

            <!-- Main content -->
            <section class="content">
                <?php
                $parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
                $title = isset($parse['election_title']) ? $parse['election_title'] : '';
                ?>
                <h1 class="page-header text-center title"><b><?php echo strtoupper($title); ?></b></h1>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <?php
                        if(isset($_SESSION['error'])){
                            ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <ul>
                                    <?php
                                    foreach($_SESSION['error'] as $error){
                                        echo "<li>".$error."</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                            unset($_SESSION['error']);
                        }
                        if(isset($_SESSION['success'])){
                            ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Success!</h4>
                                <?php echo $_SESSION['success']; ?>
                            </div>
                            <?php
                            unset($_SESSION['success']);
                        }
                        ?>

                        <div class="alert alert-danger alert-dismissible" id="alert" style="display:none;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <span class="message"></span>
                        </div>

                        <?php
                        $sql = "SELECT * FROM votes WHERE voters_id = '".$voter['id']."'";
                        $vquery = $conn->query($sql);
                        if($vquery->num_rows > 0){
                            ?>
                            <div class="text-center">
                                <h3>You have already voted for this election.</h3>
                                <a href="#view" data-toggle="modal" class="btn btn-flat btn-primary btn-lg">View Ballot</a>
                            </div>
                            <?php
                        }
                        else{
                            ?>
                            <!-- Voting Ballot -->
                            <form method="POST" id="ballotForm" action="submit_ballot.php">
                                <?php
                                include 'includes/slugify.php';

                                $sql = "SELECT positions.description, positions.id AS position_id, positions.max_vote, candidates.id, candidates.firstname, candidates.lastname, candidates.platform, candidates.photo FROM positions INNER JOIN candidates ON positions.id = candidates.position_id WHERE positions.id = $voter_position_id ORDER BY positions.id, candidates.id";

                                $query = $conn->query($sql);

                                if ($query && $query->num_rows > 0) {
                                    $currentPositionID = null;
                                    $max_vote = null;
                                    echo '<div class="row">
                                            <div class="col-xs-12">
                                                <div class="box box-solid" id="candidates_section">
                                                    <div class="box-header with-border">
                                                        <div class="pull-left">Select one candidate and press the vote button</div>
                                                        <div class="pull-right"><button type="button" class="btn btn-success btn-sm btn-flat reset" id="reset_candidates"><i class="fa fa-refresh"></i> Reset</button></div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div id="candidate_list">
                                                            <ul>';
                                    while($row = $query->fetch_assoc()){
                                        $slug = slugify($row['description']);
                                        $checked = '';

                                        if(isset($_SESSION['post'][$slug])){
                                            $value = $_SESSION['post'][$slug];

                                            if(is_array($value)){
                                                foreach($value as $val){
                                                    if($val == $row['id']){
                                                        $checked = 'checked';
                                                    }
                                                }
                                            }
                                            else{
                                                if($value == $row['id']){
                                                    $checked = 'checked';
                                                }
                                            }
                                        }

                                        $input = ($row['max_vote'] > 1) ? '<input type="checkbox" class="flat-red '.$slug.'" name="'.$slug."[]".'" value="'.$row['id'].'" '.$checked.'>' : '<input type="radio" class="flat-red '.$slug.'" name="'.slugify($row['description']).'" value="'.$row['id'].'" '.$checked.'>';
                                        $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/profile.jpg';
                                ?>
                                        <li>
                                            <?php echo $input; ?><button type="button" class="btn btn-primary btn-sm btn-flat clist platform" data-platform="<?php echo $row['platform']; ?>" data-fullname="<?php echo $row['firstname'].' '.$row['lastname']; ?>"><i class="fa fa-search"></i> Platform</button><img src="<?php echo $image; ?>" height="100px" width="100px" class="clist"><span class="cname clist"><?php echo $row['firstname'].' '.$row['lastname']; ?></span>
                                        </li>
                                <?php
                                    }
                                    echo '</ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                } else {
                                    echo "No positions found for this voter.";
                                }
                                ?>
                                <div class="text-center">
                                    <button type="button" class="btn btn-success btn-flat" id="preview"><i class="fa fa-file-text"></i> Preview</button>
                                    <button type="submit" class="btn btn-primary btn-flat" name="vote"><i class="fa fa-check-square-o"></i> Vote Now</button>
                                </div>
                            </form>
                            <!-- End Voting Ballot -->
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </section>

        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/ballot_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
    $('.content').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

    $(document).on('click', '#reset_candidates', function(e){
        e.preventDefault();
        $('.flat-red').iCheck('uncheck');
    });

    $(document).on('click', '.platform', function(e){
        e.preventDefault();
        $('#platform').modal('show');
        var platform = $(this).data('platform');
        var fullname = $(this).data('fullname');
        $('.candidate').html(fullname);
        $('#plat_view').html(platform);
    });

    $('#preview').click(function(e){
        e.preventDefault();
        var form = $('#ballotForm').serialize();
        if(form == ''){
            $('.message').html('You must vote at least one candidate');
            $('#alert').show();
        }
        else{
            $.ajax({
                type: 'POST',
                url: 'preview.php',
                data: form,
                dataType: 'json',
                success: function(response){
                    if(response.error){
                        var errmsg = '';
                        var messages = response.message;
                        for (i in messages) {
                            errmsg += messages[i]; 
                        }
                        $('.message').html(errmsg);
                        $('#alert').show();
                    }
                    else{
                        $('#preview_modal').modal('show');
                        $('#preview_body').html(response.list);
                    }
                }
            });
        }
    });
});
</script>
</body>
</html>
