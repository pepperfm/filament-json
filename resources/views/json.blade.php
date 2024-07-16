<div>
@foreach($getState() as $variable => $value)
@if(!empty($value))
    <p>
        <b>{{ $variable }}</b>: {{ $value }}
        &nbsp;
    </p>
@endif
@endforeach
</div>
