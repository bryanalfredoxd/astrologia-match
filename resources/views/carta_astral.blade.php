@extends('layouts.app')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen py-10 px-4 sm:px-6 relative overflow-hidden">

    <div class="max-w-7xl mx-auto text-center relative z-10">
        <h1 class="text-3xl md:text-5xl font-bold mb-6 text-[#FFD700]">¿Qué es tu Carta Astral?</h1>
        <p class="text-lg md:text-xl mb-10 leading-relaxed max-w-4xl mx-auto text-[#A7B3EB]">
            La carta astral es como una <strong class="text-white">foto del cielo en el instante exacto en que naciste</strong>. Observa dónde estaban el Sol, la Luna y el horizonte en ese momento. Esta información revela tu forma de ser, sentir y actuar, a través de tres signos clave:
        </p>

        <!-- CÓMO SE CALCULA -->
        <div class="flex justify-center mb-12">
            <div class="bg-white bg-opacity-10 rounded-xl p-6 backdrop-blur-sm shadow-lg max-w-3xl text-left border border-[#4A0E7B] border-opacity-40">
                <h2 class="text-2xl font-semibold mb-3 text-[#FFD700] text-center flex items-center justify-center">
                    <i class="fas fa-calculator mr-2"></i> ¿Cómo se calcula?
                </h2>
                <p class="text-[#A7B3EB] leading-relaxed">
                    Para calcular tus signos necesitas datos específicos:
                </p>
                <ul class="list-disc list-inside text-[#A7B3EB] mt-3 space-y-1">
                    <li><strong class="text-white">Fecha de nacimiento</strong>: día exacto que naciste.</li>
                    <li><strong class="text-white">Hora de nacimiento</strong>: lo más precisa posible (idealmente con minutos).</li>
                    <li><strong class="text-white">Lugar de nacimiento</strong>: ciudad o municipio donde naciste.</li>
                </ul>
                <p class="mt-4 text-[#A7B3EB]">Con esto, el sistema puede ubicar cómo estaba el cielo justo cuando llegaste al mundo <i class="fas fa-star text-yellow-300"></i>.</p>
            </div>
        </div>

        <!-- LOS TRES SIGNOS -->
        <div class="grid md:grid-cols-3 gap-6 text-left mb-16">
            <!-- Signo Solar -->
            <div class="bg-white bg-opacity-10 p-6 rounded-2xl shadow-lg backdrop-blur-sm hover:scale-[1.02] transition-all duration-300 border border-[#4A0E7B] border-opacity-40">
                <div class="flex items-center mb-4">
                    <i class="fas fa-sun text-[#FFD700] text-3xl mr-3"></i>
                    <h3 class="text-2xl font-bold text-white">Signo Solar</h3>
                </div>
                <p class="text-[#A7B3EB] leading-relaxed">
                    Es el signo del zodiaco donde estaba el <strong class="text-white">Sol</strong> cuando naciste. Representa tu <strong class="text-white">identidad principal</strong>, tu energía vital, tu ego y tu voluntad.
                    <br><br>
                    Es como el papel protagónico que vienes a interpretar en la vida. La gente suele conocer este signo porque es el que se usa en el horóscopo tradicional.
                    <br><br>
                    <span class="font-semibold text-[#FFD700]">Dato necesario:</span> <u>fecha de nacimiento</u>.
                </p>
            </div>

            <!-- Signo Lunar -->
            <div class="bg-white bg-opacity-10 p-6 rounded-2xl shadow-lg backdrop-blur-sm hover:scale-[1.02] transition-all duration-300 border border-[#4A0E7B] border-opacity-40">
                <div class="flex items-center mb-4">
                    <i class="fas fa-moon text-[#A7B3EB] text-3xl mr-3"></i>
                    <h3 class="text-2xl font-bold text-white">Signo Lunar</h3>
                </div>
                <p class="text-[#A7B3EB] leading-relaxed">
                    La <strong class="text-white">Luna</strong> muestra tu parte emocional. Representa lo que necesitas para sentirte seguro, cómo reaccionas en lo íntimo y cómo manejas tus emociones.
                    <br><br>
                    A veces puede ser diferente a lo que muestras. Es lo que sientes cuando nadie te ve. Influye mucho en tus relaciones afectivas.
                    <br><br>
                    <span class="font-semibold text-[#FFD700]">Datos necesarios:</span> <u>fecha</u>, <u>hora</u> y <u>lugar de nacimiento</u>.
                </p>
            </div>

            <!-- Ascendente -->
            <div class="bg-white bg-opacity-10 p-6 rounded-2xl shadow-lg backdrop-blur-sm hover:scale-[1.02] transition-all duration-300 border border-[#4A0E7B] border-opacity-40">
                <div class="flex items-center mb-4">
                    <i class="fas fa-arrow-up text-[#8A2BE2] text-3xl mr-3"></i>
                    <h3 class="text-2xl font-bold text-white">Ascendente</h3>
                </div>
                <p class="text-[#A7B3EB] leading-relaxed">
                    Es el signo que se levantaba por el horizonte cuando naciste. Muestra cómo te ven los demás, cómo te presentas y tu estilo personal.
                    <br><br>
                    Es como tu envoltorio externo: la primera impresión que causas. También influye en tu aspecto físico y comportamiento espontáneo.
                    <br><br>
                    <span class="font-semibold text-[#FFD700]">Datos necesarios:</span> <u>hora exacta</u> y <u>lugar de nacimiento</u>.
                </p>
            </div>
        </div>

        <!-- IMPORTANCIA EN ASTROMATCH -->
        <div class="flex justify-center">
            <div class="bg-white bg-opacity-10 p-8 rounded-2xl backdrop-blur-sm shadow-lg max-w-4xl text-left border border-[#4A0E7B] border-opacity-40">
                <h2 class="text-2xl font-bold mb-4 text-[#FFD700] text-center flex items-center justify-center">
                    <i class="fas fa-heart mr-2"></i> ¿Por qué esto es importante en AstroMatch?
                </h2>
                <p class="text-[#A7B3EB] mb-4 text-center">
                    Conocer tus signos ayuda al sistema a entender mejor tu personalidad y emociones, y así sugerirte personas que realmente puedan hacer conexión contigo.
                </p>
                <ul class="list-disc list-inside text-[#A7B3EB] space-y-2">
                    <li><strong class="text-white">Encuentra personas afines</strong> según cómo piensas, sientes y actúas.</li>
                    <li><strong class="text-white">Evita relaciones conflictivas</strong> con signos con los que puedes chocar mucho.</li>
                    <li><strong class="text-white">Conecta con gente que te entiende</strong>, no solo por gusto físico, sino por energía compatible.</li>
                    <li><strong class="text-white">Recibe recomendaciones personalizadas</strong> que van más allá del horóscopo común.</li>
                </ul>
                <p class="mt-4 text-[#A7B3EB] text-center">
                    Tus signos astrológicos no definen todo sobre ti, pero pueden darte una guía para conocer mejor tus afinidades.
                </p>
            </div>
        </div>

        <!-- CTA FINAL -->
        <div class="mt-12 text-center">
            <a href="{{ route('register') }}"
               class="inline-flex items-center px-6 py-3 bg-[#FFD700] hover:bg-[#F8C800] text-[#0A0E2A] font-extrabold rounded-full transition duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <i class="fas fa-rocket mr-2"></i> Descubre tus signos ahora
            </a>
        </div>

        {{-- La animación decorativa con id="lottieCartaAstral" ha sido comentada/removida para eliminar el espacio. --}}
        {{-- Si deseas usarla, considera posicionarla de forma absoluta o ajustar sus márgenes. --}}

    </div>

    <!-- Elementos decorativos de fondo -->
    <div class="absolute top-0 left-0 w-48 h-48 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>
</section>

@endsection