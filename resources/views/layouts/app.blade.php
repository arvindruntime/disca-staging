<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.head')

    @yield('css')
</head>

<body>
    @include('includes.header')

    @yield('content')

</body>
@include('includes.footer')

<script>
    function img2svg() {

        jQuery('.in-svg').each(function(i, e) {

            var $img = jQuery(e);

            var imgID = $img.attr('id');

            var imgClass = $img.attr('class');

            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function(data) {

                // Get the SVG tag, ignore the rest

                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG

                if (typeof imgID !== 'undefined') {

                    $svg = $svg.attr('id', imgID);

                }

                // Add replaced image's classes to the new SVG

                if (typeof imgClass !== 'undefined') {

                    $svg = $svg.attr('class', ' ' + imgClass + ' replaced-svg');

                }

                // Remove any invalid XML tags as per http://validator.w3.org

                $svg = $svg.removeAttr('xmlns:a');

                // Replace image with new SVG

                $img.replaceWith($svg);

            }, 'xml');

        });

    }

    img2svg();



    // Swiper Slider

    var swiper = new Swiper(".logo-slider", {
        slidesPerView: "auto",
        spaceBetween: 80,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        breakpoints: {
            0: {
                spaceBetween: 40,
            },
            575: {
                spaceBetween: 50,
            },
            767: {
                spaceBetween: 60,
            },
            1200: {
                spaceBetween: 80,
            },
        },
    });
    var swiper = new Swiper(".offer-slider", {
        // loop: true,
        // autoplay: {
        //   delay: 2500,
        //   disableOnInteraction: false,
        spaceBetween: 24,
        // },
        breakpoints: {
            0: {
                slidesPerView: "1",
            },
            575: {
                slidesPerView: "2",
            },
            767: {
                slidesPerView: "3",
            },
            1200: {
                slidesPerView: "4",
            },
        },
    });
    $(document).ready(function() {
        $('.select2box').select2();

        $("#country_id").select2({
            placeholder: function() {
                $(this).data('placeholder');
            }
        })

        $(".togglePassword").click(function() {
            const passwordInput = $("#password");
            const type = passwordInput.attr("type") === "password" ? "text" : "password";
            passwordInput.attr("type", type);
            $(this).attr("src", `images/icon/eye${type === "password" ? '-slash' : ''}.svg`);
        });


        $('#RegisterBtn').click(function() {
            if ($("#RegisterForm").valid()) {
                $('#register-success').text('');
                $('#register-error').text('');
                $.ajax({
                    url: "{{ url('api/v1/register') }}",
                    type: 'POST',
                    data: $("#RegisterForm").serialize(),
                    success: function(response) {
                        if (response.status === 200) {
                            alert(response.message);
                            window.location.href="login";
                            $('#register-success').text(response.message);
                            $('#RegisterForm')[0].reset();
                        } else {
                            $('#register-error').text(response.message);
                        }
                    },
                    error: function(xhr, status, error) {}
                });
            }
        });

        $("#RegisterForm").validate({
            rules: {
                name: "required",
                company_lead: "required",
                organization: "required",
                street: "required",
                city: "required",
                country_id: "required",
                post_code: "required",
                email: {
                    required: true,
                    email: true
                },
                phone_no: {
                required: true,
                minlength: 7,
                maxlength: 15,
                digits: true 
                },
                mobile_no:
                {
                required: true,
                minlength: 7,
                maxlength: 15,
                digits: true 
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
                sectore: "required",
                terms_and_condition: "required"
            }
        });

    });
</script>

</html>
