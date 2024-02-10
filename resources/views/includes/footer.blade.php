<footer class="footer">
    <div class="container">
        <div class="di__footer_content text-center">
            <div class="di__footer_logo">
                <a href="#!"><img src="{{ asset('images/Logo.svg') }}" alt=""></a>
            </div>
            <div class="di__social_links d-flex justify-content-center">
                <a href="#" 
                    class="bg-primary d-flex justify-content-center align-items-center rounded-circle"><img
                        src="{{ asset('images/icon/facebook.svg') }}" alt=""></a>
                <a href="#" 
                    class="bg-primary d-flex justify-content-center align-items-center rounded-circle"><img
                        src="{{ asset('images/icon/linkedin.svg') }}" alt=""></a>
                <a href="#"
                    class="bg-primary d-flex justify-content-center align-items-center rounded-circle"><img
                        src="{{ asset('images/icon/twitter.svg') }}" alt=""></a>
            </div>
            <div class="di__policy_link d-flex justify-content-center">
                @foreach ($pages as $page)
                    <a href="{{ url($page->permalink) }}" target="_blank"
                        class="tertiary-color text fw-medium">{{ $page->title }}</a>
                @endforeach

            </div>
        </div>
        <div class="di__footer_copyright mx-auto">
            <p class="text-center mb-0 text-xs tertiary-color">
                © <?= date('Y') ?> Infra 360 Digital Infrastructure for Social Care. All Rights Reserved. - Designed by
                Peak Online
            </p>
        </div>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.3/jquery.validate.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
