@component('mail::message')
# Restablecimiento de Contraseña

Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en AstroMatch.

@component('mail::button', ['url' => $resetUrl, 'color' => 'primary'])
Restablecer Contraseña
@endcomponent

Este enlace de restablecimiento expirará en 60 minutos. Si no solicitaste un restablecimiento de contraseña, no es necesario realizar ninguna acción.

Gracias,<br>
El equipo de AstroMatch
@endcomponent