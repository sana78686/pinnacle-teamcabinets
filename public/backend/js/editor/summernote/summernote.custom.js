// Ensure that the jQuery code is wrapped in the document ready function
jQuery(document).ready(function($) {

    // Define summernote_custom object
    var summernote_custom = {
        init: function() {
            // Initialize Summernote for elements with class 'summernote'
            $('.summernote').summernote({
                height: 300,
                tabsize: 2
            });

            // Initialize Summernote for elements with class 'inline-editor'
            $('.inline-editor').summernote({
                airMode: true
            });

            // Initialize Summernote for elements with class 'hint2basic'
            $(".hint2basic").summernote({
                height: 100,
                toolbar: false,
                placeholder: 'type with apple, orange, watermelon, lemon',
                hint: {
                    words: ['apple', 'orange', 'watermelon', 'lemon'],
                    match: /\b(\w{1,})$/,
                    search: function (keyword, callback) {
                        callback($.grep(this.words, function (item) {
                            return item.indexOf(keyword) === 0;
                        }));    
                    }
                }
            });
        }
    };

    // Call the init method of summernote_custom
    summernote_custom.init();

    // Define the 'edit' function
    window.edit = function() {
        $('.click2edit').summernote({ focus: true });
    };

    // Define the 'save' function
    window.save = function() {
        var markup = $('.click2edit').summernote('code');
        $('.click2edit').summernote('destroy');
    };

    // Optional: Attach 'click' event to the 'edit' button
    $('#edit').on('click', function() {
        edit();
    });

    // Optional: Attach 'click' event to the 'save' button
    $('#save').on('click', function() {
        save();
    });

    // Your other code here (if any)

});