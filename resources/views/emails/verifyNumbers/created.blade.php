@component('mail::message')

    <p class="title" style="font-size:16px; text-align:center;">인증번호:
        <span class="point" style="font-size:16px; font-weight:bold; color:blue;">{{$verifyNumber->number}}</span>
    </p>

{{--@component('mail::button', ['url' => ''])
Button Text
@endcomponent--}}

@endcomponent
