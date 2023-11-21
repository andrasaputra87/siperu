<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div
        class="{{ !empty($containerNav) ? $containerNav : 'container-fluid' }} d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            &copy;
            <script>
                document.write(new Date().getFullYear());
            </script>
            , made with ❤️ by <b>{{ !empty(config('variables.creatorName')) ? config('variables.creatorName') : '' }}
                @if (!empty(config('variables.Redesign')))
                    &nbsp;|&nbsp; Redesign by {{ config('variables.Redesign') }}
                @endif
            </b>
        </div>
    </div>
</footer>
<!--/ Footer -->
