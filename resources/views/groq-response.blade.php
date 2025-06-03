{{-- resources/views/groq-response.blade.php --}}

@extends('layouts.app_sesion') {{-- Asegúrate de que este layout exista y sea adecuado --}}

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen p-4 sm:p-6 flex items-center justify-center">
    <div class="max-w-2xl mx-auto bg-[#1A1F4D] rounded-xl p-8 shadow-lg text-center border border-[#FFD700]">
        <h2 class="text-3xl font-bold text-[#FFD700] mb-6">Resultados Astrológicos de la IA</h2>

        <div id="groq-astrology-output" class="text-lg text-[#A7B3EB] leading-relaxed whitespace-pre-wrap">
            Cargando resultados...
        </div>

        <a href="{{ route('astromatch') }}" class="mt-8 inline-block bg-[#FFD700] text-[#0A0E2A] font-bold py-3 px-6 rounded-full hover:bg-white transition duration-300">
            Volver a mi Perfil
        </a>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const groqResponse = localStorage.getItem('groqResponse');
        const outputDiv = document.getElementById('groq-astrology-output');

        if (groqResponse) {
            try {
                const data = JSON.parse(groqResponse);
                if (data.astrology_data) {
                    outputDiv.textContent = data.astrology_data;
                } else if (data.error) {
                    outputDiv.textContent = 'Error de la API: ' + data.error;
                    outputDiv.classList.add('text-red-500');
                } else {
                    outputDiv.textContent = 'Respuesta inesperada de la IA.';
                }
            } catch (e) {
                outputDiv.textContent = 'Error al parsear la respuesta de la IA.';
                outputDiv.classList.add('text-red-500');
                console.error("Error parsing localStorage data:", e);
            } finally {
                localStorage.removeItem('groqResponse'); // Limpiar después de usar
            }
        } else {
            outputDiv.textContent = 'No se encontraron resultados. Intenta de nuevo desde tu perfil.';
        }
    });
</script>
@endsection