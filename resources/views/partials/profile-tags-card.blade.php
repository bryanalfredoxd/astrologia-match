<!-- Sección de Tags Adicionales del Perfil -->
<div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] backdrop-blur-sm rounded-2xl p-4 sm:p-6 mb-6 shadow-lg max-w-4xl mx-auto">
    <div class="flex items-center justify-center mb-6">
        <h2 class="text-2xl sm:text-3xl font-extrabold flex items-center text-center text-white">
            <i class="fas fa-palette text-[#FFD700] mr-4 text-3xl"></i>
            Mis Intereses y Preferencias
        </h2>
    </div>

    {{-- Botón para plegar/desplegar --}}
    <div class="flex justify-center mb-6">
        <button id="toggle-tags-btn"
                class="bg-[#3A3F6D] hover:bg-[#4A4F7D] text-white font-bold py-2 px-6 rounded-full transition duration-300 shadow-md flex items-center">
            Ver/Ocultar Tags
            <i id="toggle-tags-icon" class="fas fa-chevron-down ml-2"></i>
        </button>
    </div>

    {{-- Contenido de los tags (plegado por defecto) --}}
    <div id="tags-content" class="space-y-6 md:space-y-8 hidden">
        @foreach ($masterTags as $category => $tags)
            @php
                $isSingleSelect = in_array($category, $singleSelectionCategories);
                $iconClass = 'fas fa-tag'; // Default icon

                // Assign icon based on category
                switch ($category) {
                    case 'Estado Civil/Sentimental':
                        $iconClass = 'fas fa-heart-crack'; // Broken heart or similar
                        break;
                    case 'Estudio':
                        $iconClass = 'fas fa-graduation-cap'; // Graduation cap
                        break;
                    case 'Trabajo':
                        $iconClass = 'fas fa-briefcase'; // Briefcase
                        break;
                    case 'Tipo de Relación':
                        $iconClass = 'fas fa-handshake'; // Handshake
                        break;
                    case 'Buscando':
                        $iconClass = 'fas fa-magnifying-glass'; // Magnifying glass
                        break;
                    case 'Intereses':
                        $iconClass = 'fas fa-star'; // Star (general interests)
                        break;
                    case 'Idiomas':
                        $iconClass = 'fas fa-language'; // Language
                        break;
                    case 'Ejercicio':
                        $iconClass = 'fas fa-dumbbell'; // Dumbbell
                        break;
                    case 'Bebe':
                        $iconClass = 'fas fa-wine-glass'; // Wine glass
                        break;
                    case 'Fuma':
                        $iconClass = 'fas fa-smoking'; // Cigarette (or crossed out cigarette if non-smoker)
                        break;
                    case 'Religión':
                        $iconClass = 'fas fa-cross'; // Cross (example, could be a crescent moon, etc.)
                        break;
                    case 'Niños':
                        $iconClass = 'fas fa-child'; // Child
                        break;
                    case 'Nivel Educativo':
                        $iconClass = 'fas fa-book-open'; // Open book
                        break;
                    default:
                        $iconClass = 'fas fa-tag'; // Fallback
                        break;
                }
            @endphp
            <div class="bg-[#1A1F4D] p-5 rounded-xl shadow-inner border border-[#3A3F6D]">
                {{-- Category title centered with icon --}}
                <h3 class="text-lg font-bold text-[#FFD700] mb-4 flex items-center justify-center">
                    <i class="{{ $iconClass }} text-[#A7B3EB] mr-3"></i>
                    {{ $category }}
                </h3>
                {{-- Tag buttons centered for all screen sizes --}}
                <div class="flex flex-wrap justify-center gap-3" data-category="{{ $category }}" data-single-select="{{ $isSingleSelect ? 'true' : 'false' }}">
                    @foreach ($tags as $tag)
                        <button type="button"
                                class="tag-button
                                    py-2 px-5 rounded-full text-sm font-semibold
                                    transition-all duration-200 ease-in-out transform hover:scale-105 active:scale-95
                                    focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:ring-opacity-75
                                    @if(in_array($tag->id_tag, $userTagIds))
                                        bg-[#FFD700] text-[#1A1F4D] shadow-lg border border-[#FFD700]
                                    @else
                                        bg-[#3A3F6D] text-white hover:bg-[#4A4F7D] border border-[#3A3F6D]
                                    @endif"
                                data-tag-id="{{ $tag->id_tag }}"
                                data-category-name="{{ $category }}">
                            {{ $tag->nombre_tag }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-10">
        <button id="save-tags-btn"
                class="bg-[#FFD700] hover:bg-[#E0C000] text-[#1A1F4D] font-bold py-3 px-10 rounded-full transition duration-300 shadow-xl border border-[#FFD700]
                       transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-[#FFD700] focus:ring-opacity-50">
            Guardar Cambios
            <i class="fas fa-save ml-2"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleTagsBtn = document.getElementById('toggle-tags-btn');
    const toggleTagsIcon = document.getElementById('toggle-tags-icon');
    const tagsContent = document.getElementById('tags-content');
    const saveTagsBtn = document.getElementById('save-tags-btn');

    // Mapeo para mantener un registro de los tags seleccionados por categoría
    const selectedTagsByCategory = new Map();

    // Initialize selectedTagsByCategory with user's current tags
    document.querySelectorAll('.tag-button').forEach(button => {
        const tagId = parseInt(button.dataset.tagId);
        const categoryName = button.dataset.categoryName;
        const categoryDiv = button.closest('[data-category]');
        const isSingleSelect = categoryDiv.dataset.singleSelect === 'true';

        if (button.classList.contains('bg-[#FFD700]')) {
            if (isSingleSelect) {
                selectedTagsByCategory.set(categoryName, tagId);
            } else {
                if (!selectedTagsByCategory.has(categoryName)) {
                    selectedTagsByCategory.set(categoryName, new Set());
                }
                selectedTagsByCategory.get(categoryName).add(tagId);
            }
        }
    });

    document.querySelectorAll('.tag-button').forEach(button => {
        button.addEventListener('click', function() {
            const tagId = parseInt(this.dataset.tagId);
            const categoryName = this.dataset.categoryName;
            const categoryDiv = this.closest('[data-category]');
            const isSingleSelect = categoryDiv.dataset.singleSelect === 'true';

            if (isSingleSelect) {
                // Logic for single selection
                if (selectedTagsByCategory.has(categoryName) && selectedTagsByCategory.get(categoryName) === tagId) {
                    // If the same button was already selected, deselect it
                    selectedTagsByCategory.delete(categoryName);
                    this.classList.remove('bg-[#FFD700]', 'text-[#1A1F4D]', 'shadow-lg', 'border');
                    this.classList.add('bg-[#3A3F6D]', 'text-white', 'hover:bg-[#4A4F7D]', 'border');
                } else {
                    // Deselect any other button in the same category
                    categoryDiv.querySelectorAll('.tag-button').forEach(otherButton => {
                        if (otherButton !== this && otherButton.classList.contains('bg-[#FFD700]')) {
                            otherButton.classList.remove('bg-[#FFD700]', 'text-[#1A1F4D]', 'shadow-lg', 'border');
                            otherButton.classList.add('bg-[#3A3F6D]', 'text-white', 'hover:bg-[#4A4F7D]', 'border');
                        }
                    });
                    // Select the current button
                    selectedTagsByCategory.set(categoryName, tagId);
                    this.classList.remove('bg-[#3A3F6D]', 'text-white', 'hover:bg-[#4A4F7D]', 'border');
                    this.classList.add('bg-[#FFD700]', 'text-[#1A1F4D]', 'shadow-lg', 'border');
                }
            } else {
                // Logic for multiple selection (existing)
                let currentSelections = selectedTagsByCategory.get(categoryName);
                if (!currentSelections) {
                    currentSelections = new Set();
                    selectedTagsByCategory.set(categoryName, currentSelections);
                }

                if (currentSelections.has(tagId)) {
                    currentSelections.delete(tagId);
                    this.classList.remove('bg-[#FFD700]', 'text-[#1A1F4D]', 'shadow-lg', 'border');
                    this.classList.add('bg-[#3A3F6D]', 'text-white', 'hover:bg-[#4A4F7D]', 'border');
                } else {
                    currentSelections.add(tagId);
                    this.classList.remove('bg-[#3A3F6D]', 'text-white', 'hover:bg-[#4A4F7D]', 'border');
                    this.classList.add('bg-[#FFD700]', 'text-[#1A1F4D]', 'shadow-lg', 'border');
                }
            }
        });
    });

    // Lógica para el botón de plegar/desplegar
    toggleTagsBtn.addEventListener('click', function() {
        tagsContent.classList.toggle('hidden');
        if (tagsContent.classList.contains('hidden')) {
            toggleTagsIcon.classList.remove('fa-chevron-up');
            toggleTagsIcon.classList.add('fa-chevron-down');
            saveTagsBtn.classList.add('hidden'); // Ocultar botón Guardar si se pliega
        } else {
            toggleTagsIcon.classList.remove('fa-chevron-down');
            toggleTagsIcon.classList.add('fa-chevron-up');
            saveTagsBtn.classList.remove('hidden'); // Mostrar botón Guardar si se despliega
        }
    });

    // Ocultar el botón de guardar por defecto si los tags están ocultos
    if (tagsContent.classList.contains('hidden')) {
        saveTagsBtn.classList.add('hidden');
    }

    saveTagsBtn.addEventListener('click', async function() {
        saveTagsBtn.disabled = true;
        saveTagsBtn.textContent = 'Guardando...';

        // Collect all selected tag IDs to send to the backend
        const allSelectedTagIds = [];
        selectedTagsByCategory.forEach((value, key) => {
            if (typeof value === 'number') { // It's a single selection
                allSelectedTagIds.push(value);
            } else if (value instanceof Set) { // It's a multiple selection
                value.forEach(tagId => allSelectedTagIds.push(tagId));
            }
        });

        try {
            const response = await fetch('{{ route('profile.tags.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ tag_ids: allSelectedTagIds })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                alert('Tags actualizados correctamente.');
                window.location.reload(); // Reload to reflect changes
            } else {
                alert('Error al guardar los tags: ' + (data.message || 'Unknown error.'));
            }
        } catch (error) {
            console.error('Error al enviar la solicitud:', error);
            alert('Connection error when saving tags.');
        } finally {
            saveTagsBtn.disabled = false;
            saveTagsBtn.textContent = 'Guardar Cambios';
        }
    });
});
</script>
