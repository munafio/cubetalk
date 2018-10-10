@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# @lang('Whoops!')
@else
# @lang('trans.resetPwd_hi')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $key => $line)
@if($key < 1)
<h3>{{ $line }}</h3>
@else
{{ $line }}
@endif
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('trans.thanks'),<br>{{ config('app.name')." " }} @lang('trans.team')
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang('trans.resetPwd_subcopy',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl
    ]
)
@endcomponent
@endisset
@endcomponent
