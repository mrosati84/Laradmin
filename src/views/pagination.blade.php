@if($results->links())
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{ $results->links() }}
            </div>
        </div>
    </div>
@endif
