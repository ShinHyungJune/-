@component('mail::message')
{{__("mail.passwordReset")["created"]}}

<div class="box_btns" style="margin-top:15px; text-align:center;">
    <a href="{{$url}}" style="display:inline-block; padding:7px 20px; font-size:16px; text-decoration:none; color:#fff; background-color:#6FDDFE; box-shadow:2px 4px 6px rgba(0,0,0,0.16);">
        {{__("mail.passwordReset")["name"]}}
    </a>
</div>

@endcomponent
