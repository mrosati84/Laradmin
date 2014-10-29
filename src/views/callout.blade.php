@if(Session::get('calloutMessage'))
    <div class="bs-callout bs-callout-{{ Session::get('calloutClass') }}">
        <h4>{{ Session::get('calloutTitle') }}</h4>
        <p>{{ Session::get('calloutMessage') }}</p>
    </div>
@endif
