<p>Hello {!! $user->name !!},</p>

<p>Welcome to {!! env('APP_NAME') !!}! Please click on the following link to confirm your {!! env('APP_NAME') !!}  account:</p>

<p><a href="{!! $activationUrl !!}">{!! $activationUrl !!}</a></p>

<p>Best regards,</p>

<p>{!! env('APP_NAME') !!} Team</p>
