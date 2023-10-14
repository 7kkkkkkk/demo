<html>
<head>
    <title>INFS7202 Demo</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400&display=swap" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>node_modules/bootstrap/dist/js/bootstrap.js"></script>
</head>

<body>
    <script>
        $(document).ready(function() {
            // Capture input event
            $('#searchInput').on('input', function() {
                var keyword = $(this).val();
                if (keyword !== '') {
                    // Send AJAX request to the server
                    $.ajax({
                        url: '<?php echo base_url('auto-suggestions'); ?>',
                        method: 'POST',
                        data: { keyword: keyword },
                        success: function(response) {
                            // Process the response and update the autocomplete list
                            var suggestions = response.data;
                            showSuggestions(suggestions);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                }
            });

            // Capture keyup event. If the user empties the input, then the dropdown list disappear.
            $('#searchInput').on('keyup', function(event) {
                if (event.keyCode === 8) { // Backspace key
                    var keyword = $(this).val();
                    if (keyword === '') {
                        hideSuggestions();
                    }
                }
            });

            function showSuggestions(suggestions) {
                var dropdown = $('<ul class="dropdown-menu">');

                $.each(suggestions, function(index, suggestion) {
                    var listItem = $('<li>')
                        .addClass('dropdown-item')
                        .append($('<a>').attr('href', '<?php echo base_url('posts/'); ?>' + suggestion.id).text(suggestion.title))
                        .appendTo(dropdown);
                    
                    listItem.on('click', function() {
                        $('#searchInput').val(suggestion);
                        $('.searchInput form').submit();
                    });
                });

                $('.searchInput .resultBox').empty().append(dropdown);
                $('.searchInput').addClass('active');
            }

            function hideSuggestions() {
                $('.searchInput').removeClass('active');
            }
        });
    </script>
    <?php if (!isset($showNavbar)) { ?>
        <nav class="navbar navbar-expand-lg bg-white">
            <div class="container">
                <div class="col-2 d-flex flex-row justify-content-between">
                    <div class="navbar-brand">INFS7202 Demo</div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse justify-content-end col-10">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item me-3">
                            <a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link" href="<?php echo base_url('/profile'); ?>">Profile</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link" href="<?php echo base_url('/post-edit'); ?>">Ask a question</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link" href="<?php echo base_url('/management-dashboard'); ?>">Dashboard</a>
                        </li>
                    </ul>
                    <?= form_open(base_url('search-results').'', ['class' => 'searchInput d-flex align-items-center mb-0']) ?>
                        <?= form_input(['type' => 'search', 'class' => 'form-control me-2', 'name' => 'searchInput', 'id' => 'searchInput', 'placeholder' => 'Search']) ?>
                        <div class="resultBox">
                            <!-- Suggestions will be inserted here dynamically -->
                        </div>
                        <?= form_submit(['class' => 'btn btn-outline-warning', 'value' => 'Search']) ?>
                    <?= form_close() ?>
                    <?php if (session()->get('username')) { ?>
                        <a class="btn btn-primary ms-3" href="<?php echo base_url(); ?>login/logout">Logout</a>
                    <?php } else { ?>
                        <a class="btn btn-primary ms-3" href="<?php echo base_url(); ?>login">Login</a>
                    <?php } ?>
                </div>
            </div>
        </nav>

    <?php } ?>

    <div class="content-wrapper">

