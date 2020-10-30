<div>
    @if(count($errors))
        <div class="alert-danger">
            @foreach($errors as $error_array)
                @foreach($error_array as $error_item)
                    {{ $error_item }}
                @endforeach
            @endforeach
            <button class="close-button" arial-lable="dismiss message" type="button" data-close>
                <span arial-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(count($success))
        <div class="alert-success">
            {{ $success }}
            <button class="close-button" arial-lable="dismiss message" type="button" data-close>
                <span arial-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>